<?php

namespace mdm\admin\models;

use mdm\admin\components\Configs;
use mdm\admin\components\UserStatus;
use pulse\worker\models\Worker;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use simialbi\yii2\models\UserInterface;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property array $statusList
 * @property UserProfile $profile
 * @property Worker $worker
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_CREATE = 9;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Configs::instance()->userTable;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'in', 'range' => [UserStatus::ACTIVE, UserStatus::INACTIVE, UserStatus::CREATE]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => UserStatus::ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => UserStatus::ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByCreateUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => UserStatus::CREATE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => UserStatus::ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public static function getDb()
    {
        return Configs::userDb();
    }

    public function getStatusTitle(){
        $statusList=self::getStatusList();
        return $statusList[$this->status];
    }

    public static function getStatusList(){
        return [
            0=>'Деактивирован',
            9=>'Без пароля',
            10=>'Активен',
        ];
    }

    public function getStatusClass(){
        $array=[
            0=>'danger',
            9=>'warning',
            10=>'success',
        ];
        return $array[$this->status];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('rbac-admin', 'Username'),
            'worker_id' => Yii::t('rbac-admin', 'Worker'),
            'status' => Yii::t('rbac-admin', 'Status'),
            'gpassword' => Yii::t('rbac-admin', 'gpassword'),
            'worker.fullName' => Yii::t('rbac-admin', 'fullName'),
        ];
    }

    /**
     * Gets query for [[TelecomPatient]].
     *
     * @return ActiveQuery
     */
    public function getWorker() : ActiveQuery
    {
        return $this->hasOne(Worker::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritDoc}
     */
    public function getImage() {
        //return $this->image;
    }

    /**
     * {@inheritDoc}
     */
    public function getName() {
        if ($this->worker){
            return $this->worker->fullNameActive.'['.$this->username.']';
        }
        return trim($this->username);
    }

    /**
     * {@inheritDoc}
     */
    public static function findIdentities() {
        return static::find()->all();
    }
}
