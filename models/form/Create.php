<?php
namespace mdm\admin\models\form;

use mdm\admin\components\UserStatus;
use mdm\admin\models\User;
use pulse\worker\models\Worker;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Signup form
 */
class Create extends Model
{
    public $username;
    public $worker_id;
    //public $email;
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
            ['username', 'unique', 'targetClass' => $class, 'message' => 'Этот логин уже используется'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['worker_id','integer'],
            ['worker_id', 'exist',
                'targetClass' => Worker::class,
                'filter' => ['active' => 1],
                'message' => 'Сотрудник не найден'
            ],

            ['password', 'string', 'min' => 6],
            ['retypePassword', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function create()
    {
        if ($this->validate()) {
            $class = Yii::$app->getUser()->identityClass ? : 'mdm\admin\models\User';
            /** @var \app\models\User $user */
            $user = new $class();
            $user->username = $this->username;
            //$user->email = $this->email;
            if ($this->password){
                //Если есть пароль, тогда статус АКТИВЕН
                $user->status = ArrayHelper::getValue(Yii::$app->params, 'user.defaultStatus', UserStatus::ACTIVE);
            }else{
                //Если пароля нет, тогда статус СОЗДАН
                $user->status = ArrayHelper::getValue(Yii::$app->params, 'user.defaultStatus', UserStatus::CREATE);
            }

            $user->setPassword($this->password);
            $user->generateAuthKey();

            if ($user->save()) {
                return $user;
            }
        }

        return null;
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
