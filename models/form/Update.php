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
class Update extends Model
{

    public $id;
    public $worker_id;
    public $gpassword;
    public $username;
    public $password;
    public $retypePassword;
    /** @var User $_user */
    public $_user;

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

            ['gpassword', 'integer', 'numberPattern' => "/^\d{4,}/",'message' => 'Графический ключ должен быть длиннее 4-х знаков'],

            ['password', 'string', 'min' => 6],
            ['retypePassword', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        if (!$this->id){
            return false;
        }
        /** @var User|mdm\admin\models\User $class */
        $class = Yii::$app->getUser()->identityClass ? : 'mdm\admin\models\User';

        $this->_user=$class::findOne(['id'=>$this->id]);
        if ($this->_user===null){
            return false;
        }
        $this->username=$this->_user->username;
        if ($this->_user->worker){
            $this->worker_id=$this->_user->worker->id;
        }
        return $this;
    }

    /**
     * Signs user up.
     *
     * @return bool
     */
    public function update(): bool
    {
        if ($this->validate()) {
            $this->_user->username = $this->username;
            //$user->email = $this->email;
            if ($this->password){
                $this->_user->setPassword($this->password);
                $this->_user->generateAuthKey();
            }

            if ($this->_user->save()) {
                $this->updateWorker();
                return true;
            }
        }

        return false;
    }

    public function updateWorker(){
        //TODO:: Можно ли изменять сотрудника?
        if ($this->worker_id){
            $worker=Worker::find()->where(['id'=>$this->worker_id])->limit(1)->one();
            $worker->user_id=$this->_user->id;
            if ($this->gpassword){
                $worker->gpassword=$this->gpassword;
            }
            $worker->save();
        }
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('rbac-admin', 'Username'),
            'password' => Yii::t('rbac-admin', 'Password'),
            'worker_id' => Yii::t('rbac-admin', 'Worker'),
            'retypePassword' => Yii::t('rbac-admin', 'Retype password'),
            'gpassword' => Yii::t('rbac-admin', 'gpassword'),
        ];
    }
}
