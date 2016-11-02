<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for User model.
 */
class UsersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
        if (! Yii::$app->user->can('viewUsers')) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $user = $this->findModel($id);

        if (! Yii::$app->user->can('viewUser', ['user' => $user])) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('view', [
            'model' => $user,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createUser')) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $request = Yii::$app->request;

        $model = new User(['scenario' => 'create']);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if(empty($request->post('User')['status'])) {
                $model->status = 10;
            }

            $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($request->post('User')['password_hash']);
            $model->password_repeat = $model->password_hash;
            $model->auth_key = Yii::$app->getSecurity()->generateRandomString();
  
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (! Yii::$app->user->can('updateUser', ['user' => $model])) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model->setScenario('update');
        $oldPassword = $model->password_hash;
        $request = Yii::$app->request;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->password_hash = $oldPassword;

            if( ! empty($request->post('User')['password_hash'])) {
                $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($request->post('User')['password_hash']);         
            }

            $model->password_repeat = $model->password_hash;   

            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->password_hash = '';

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (! Yii::$app->user->can('deleteUser', ['user' => $model])) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
