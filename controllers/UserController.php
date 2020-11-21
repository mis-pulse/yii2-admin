<?php

namespace mdm\admin\controllers;

use mdm\admin\components\UserStatus;
use mdm\admin\models\form\Create;
use mdm\admin\models\form\CreatePassword;
use mdm\admin\models\form\Login;
use mdm\admin\models\form\Update;
use mdm\admin\models\searchs\User as UserSearch;
use mdm\admin\models\User;
use Yii;
use yii\base\UserException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * User controller
 */
class UserController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                    'logout' => ['post'],
                    'activate' => ['post'],
                    'reset' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create new user
     * @return string
     */
    public function actionCreate()
    {
        $model = new Create();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->create()) {
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Update User model
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model= new Update(['id' => $id]);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->update()) {
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Update User model
     * @return mixed
     */
    public function actionMyConfig(): string
    {
        $model= new Update(['id' => Yii::$app->user->identity->id]);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->update()) {
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Activate new user
     * @param integer $id
     * @return Response
     * @throws UserException
     * @throws NotFoundHttpException
     */
    public function actionActivate($id): Response
    {
        /* @var $user User */
        $user = $this->findModel($id);
        if ($user->status === UserStatus::INACTIVE) {
            $user->status = UserStatus::CREATE;
            if ($user->save()) {
                return $this->redirect(['index']);
            }
            $errors = $user->firstErrors;
            throw new UserException(reset($errors));
        }
        return $this->redirect(['index']);
    }

    /**
     * Reset password an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionReset($id)
    {
        $model=$this->findModel($id);
        $model->status=UserStatus::CREATE;
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        $model->status=UserStatus::INACTIVE;
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Login
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->getUser()->isGuest) {
            return $this->goHome();
        }
        $this->layout='/login';
        $model = new Login();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->goHome();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->getUser()->logout();
        return $this->goHome();
    }

    /**
     * Create password
     * @return string
     */
    public function actionCreatePassword(): string
    {
        if (!Yii::$app->getUser()->isGuest) {
            return $this->goHome();
        }
        $this->layout='/login';
        $model = new CreatePassword();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->create()) {
            return $this->goBack(['user/login']);
        }
        return $this->render('createPassword', [
                'model' => $model,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): ?User
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
