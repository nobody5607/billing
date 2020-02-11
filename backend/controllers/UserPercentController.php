<?php

namespace backend\controllers;

use appxq\sdii\utils\VarDumper;
use Yii;
use backend\models\UserPercent;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use appxq\sdii\helpers\SDHtml;

/**
 * UserPercentController implements the CRUD actions for UserPercent model.
 */
class UserPercentController extends Controller
{
    public function behaviors()
    {
        return [
            /*	    'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['?', '@'],
                        ],
                        [
                        'allow' => true,
                        'actions' => ['view', 'create', 'update', 'delete', 'deletes'],
                        'roles' => ['@'],
                        ],
                    ],
                    ],*/
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (in_array($action->id, array('create', 'update'))) {

            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Lists all UserPercent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $bill_id = isset(\Yii::$app->session['bill_id']) ? \Yii::$app->session['bill_id'] : '';
        $query = UserPercent::find()->where('bill_id=:bill_id', [':bill_id' => $bill_id]);
        if (!$query->all()) {
            $query = UserPercent::find()->where(['id' => '10000']);
        }
        //VarDumper::dump($query->one());
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', [
                'dataProvider' => $dataProvider,
            ]);
        }
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Displays a single UserPercent model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->getRequest()->isAjax) {
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new UserPercent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        if (Yii::$app->getRequest()->isAjax) {
            $model = new UserPercent();
            $bill_id = isset(\Yii::$app->session['bill_id']) ? \Yii::$app->session['bill_id'] : '';
            $model->bill_id = $bill_id;
            $model->default = 2;

            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                if ($model->save()) {
                    return \cpn\chanpan\classes\CNMessage::getSuccess('Create successfully');
                } else {
                    return \cpn\chanpan\classes\CNMessage::getError('Can not create the data.', $model->errors);
                }
            } else {
                return $this->renderAjax('create', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Updates an existing UserPercent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->getRequest()->isAjax) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    return \cpn\chanpan\classes\CNMessage::getSuccess('Update successfully');
                } else {
                    return \cpn\chanpan\classes\CNMessage::getError('Can not update the data.');
                }
            } else {
                return $this->renderAjax('update', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Deletes an existing UserPercent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->getRequest()->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($this->findModel($id)->delete()) {
                return \cpn\chanpan\classes\CNMessage::getSuccess('Delete successfully');
            } else {
                return \cpn\chanpan\classes\CNMessage::getError('Can not delete the data.');
            }
        } else {
            throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionDeletes()
    {
        if (Yii::$app->getRequest()->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (isset($_POST['selection'])) {
                foreach ($_POST['selection'] as $id) {
                    $this->findModel($id)->delete();
                }
                return \cpn\chanpan\classes\CNMessage::getSuccess('Delete successfully');
            } else {
                return \cpn\chanpan\classes\CNMessage::getError('Can not delete the data.');
            }
        } else {
            throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Finds the UserPercent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserPercent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserPercent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
