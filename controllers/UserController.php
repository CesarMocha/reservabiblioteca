<?php

namespace app\controllers;

use app\models\User;
use app\models\UserSearch;
use app\models\ChangePasswordForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $now = \Yii::$app->formatter;
        $model = new User();
        $model->Auth_key = \Yii::$app->security->generateRandomString(); //GENERACION DE AUTOKEY. MICAEL
        $model->Created_at = $now->asDatetime(new \DateTime(), 'php:Y-m-d H:i:s');

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Configura la contraseña del usuario después de cargar los datos del formulario
                $model->setPassword($model->password);
            
            // Guarda el modelo si pasa las validaciones
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
         } else {
             $model->loadDefaultValues();
         }

    return $this->render('create', [
        'model' => $model,
    ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        
        $model = $this->findModel($id);
        $now = \Yii::$app->formatter;
        $model->Updated_at = $now->asDatetime(new \DateTime(), 'php:Y-m-d H:i:s');

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Configura la contraseña del usuario después de cargar los datos del formulario
                $model->setPassword($model->password);
            
            // Guarda el modelo si pasa las validaciones
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
         } else {
             $model->loadDefaultValues();
         }

    return $this->render('update', [
        'model' => $model,
    ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();
    
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Validar la contraseña actual
            if (Yii::$app->user->identity->validatePassword($model->currentPassword)) {
                // Cambiar la contraseña del usuario
                $user = Yii::$app->user->identity;
                $user->setPassword($model->newPassword);
                $user->save();
                
                Yii::$app->session->setFlash('success', 'Contraseña cambiada con éxito.');
                //return $this->redirect(['view', 'id' => $user->id]);
                return $this->redirect(['change-password']);
            } else {
                Yii::$app->session->setFlash('error', 'La contraseña actual es incorrecta.');
            }
        }
    
        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

}
