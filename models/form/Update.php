<?php
namespace mdm\admin\models\form;

use mdm\admin\components\Configs;
use mdm\admin\components\UserStatus;
use mdm\admin\models\User;
use pulse\worker\models\Worker;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Signup form
 */
class Update extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Configs::instance()->userTable;
    }

    public $worker_id;
    public $password;
    public $retypePassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $class = Yii::$app->getUser()->identityClass ? : 'mdm\admin\models\User';
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => $class, 'message' => 'Этот логин уже используется','filter'=>['<>','id',$this->id]],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['worker_id','integer'],
            ['worker_id', 'exist', 'skipOnError' => true, 'targetClass' => Worker::class, 'targetAttribute' => ['worker_id' => 'id'],'filter' => ['active' => 1]],

            ['password', 'string', 'min' => 6],
            ['retypePassword', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * Signs user up.
     *
     * @param bool $runValidation
     * @param null $attributeNames
     * @return boolean
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save($runValidation = true, $attributeNames = null): bool
    {

        if ($runValidation && !$this->validate($attributeNames)) {
            return false;
        }
        /** @var User $class */
        $class = Yii::$app->getUser()->identityClass ? : 'mdm\admin\models\User';
        $class::findIdentity($this->id);
        if ($this->password){
            $class->setPassword($this->password);
            $class->generateAuthKey();
        }

        if ($this->update(false)) {
            $worker=Worker::find()->where(['id'=>$this->worker_id])->limit(1)->one();
            $worker->user_id=$this->id;
            $worker->save();
            return true;
        }


        return false;
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('rbac-admin', 'Username'),
            'password' => Yii::t('rbac-admin', 'Password'),
            'worker_id' => Yii::t('rbac-admin', 'Worker'),
            'retypePassword' => Yii::t('rbac-admin', 'Retype password'),
        ];
    }
}
