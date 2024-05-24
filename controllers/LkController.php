<?php

namespace app\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use app\models\Car;

use app\models\RequestCreateForm;
use app\models\Request;
use app\models\RequestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RequestController implements the CRUD actions for Request model.
 */
class LkController extends Controller
{
    public function beforeAction($action)
    {
        if(Yii::$app->user->isGuest){
            $this->redirect(['/site/login']);
            return false;
        }
        if(!parent::beforeAction($action)){
            return false;
        }
        return true;
    }
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
     * Lists all Request models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RequestSearch();
        $dataProvider = $searchModel->searchForUser($this->request->queryParams, Yii::$app->user->identity->id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Request model.
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
     * Creates a new Request model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new RequestCreateForm();
        $model->id_user = Yii::$app->user->identity->id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success' , 'Вы успешно отправили заявку!');
                return $this->redirect(['/lk', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        $cars = Car::find()->all();
        $cars = ArrayHelper::map($cars, 'id', 'name');


        return $this->render('create', [
            'model' => $model,
            'cars' => $cars,
        ]);
    }

    /**
     * Updates an existing Request model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success' , 'Вы успешно удалили заявку!');

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Request::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSolve($id)
    {
        $model = $this->findModel($id);
        $statusArray = explode(',', $model->id_status);
        $statusArray = array_diff($statusArray, ['1']);
        $statusArray[] = '2';
        $model->id_status = implode(',', $statusArray);
        $model->save(false);

        Yii::$app->session->setFlash('success' , 'Вы успешно подтвердили заявку!');
        return $this->redirect(['index']);
    }

    public function actionCancel($id)
    {
        $model = $this->findModel($id);
        $statusArray = explode(',', $model->id_status);
        $statusArray = array_diff($statusArray, ['1']);
        $statusArray[] = '3';
        $model->id_status = implode(',', $statusArray);
        $model->save(false);

        Yii::$app->session->setFlash('success' , 'Вы успешно отклонили заявку!');
        return $this->redirect(['index']);
    }

}
