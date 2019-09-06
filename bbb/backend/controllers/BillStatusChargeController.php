<?php

namespace backend\controllers;

use Yii;
use backend\models\BillStatusCharge;
use backend\models\search\BillStatusCharge as BillStatusChargeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use appxq\sdii\helpers\SDHtml;

/**
 * BillStatusChargeController implements the CRUD actions for BillStatusCharge model.
 */
class BillStatusChargeController extends Controller
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

    public function beforeAction($action) {
	if (parent::beforeAction($action)) {
	    if (in_array($action->id, array('create', 'update'))) {
		
	    }
	    return true;
	} else {
	    return false;
	}
    }
    
    /**
     * Lists all BillStatusCharge models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BillStatusChargeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BillStatusCharge model.
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
     * Creates a new BillStatusCharge model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = new BillStatusCharge();

	    if ($model->load(Yii::$app->request->post())) {
		$model->rstat = 1;
                $model->create_by = \backend\classes\CNUser::get_id();
                $model->create_date = \appxq\sdii\utils\SDdate::get_current_date_time();
		if ($model->save()) {
		    return \cpn\chanpan\classes\CNMessage::getSuccess('Create successfully', $model->errors);
		} else {
		    return \cpn\chanpan\classes\CNMessage::getError('Can not create the data.'.\appxq\sdii\utils\SDUtility::array2String($model->errors), $model->errors);
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
     * Updates an existing BillStatusCharge model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = $this->findModel($id);
            
	    if ($model->load(Yii::$app->request->post())) {
		$model->rstat = 1;
                $model->update_by = \backend\classes\CNUser::get_id();
                $model->update_date = \appxq\sdii\utils\SDdate::get_current_date_time();
		if ($model->save()) {
		    return \cpn\chanpan\classes\CNMessage::getSuccess('Update successfully', $model);
		} else {
		    return \cpn\chanpan\classes\CNMessage::getError('Can not update the data.'.\appxq\sdii\utils\SDUtility::array2String($model->errors), $model->errors);
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
     * Deletes an existing BillStatusCharge model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = $this->findModel($id);
            $model->rstat = 3;
            $model->update_by = \backend\classes\CNUser::get_id();
            $model->update_date = \appxq\sdii\utils\SDdate::get_current_date_time();
	    if ($model->save()) {
		return \cpn\chanpan\classes\CNMessage::getSuccess('Delete successfully', $model); 
	    } else {
		return \cpn\chanpan\classes\CNMessage::getError('Can not delete the data.'.\appxq\sdii\utils\SDUtility::array2String($model->errors), $model->errors);
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }

    public function actionDeletes() {
	if (Yii::$app->getRequest()->isAjax) {
	     
	    if (isset($_POST['selection'])) {
		foreach ($_POST['selection'] as $id) {
                    $model = $this->findModel($id)->delete();
                    $model->rstat = 3;
                    $model->update_by = \backend\classes\CNUser::get_id();
                    $model->update_date = \appxq\sdii\utils\SDdate::get_current_date_time();
                    $model->save();
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
     * Finds the BillStatusCharge model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BillStatusCharge the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BillStatusCharge::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
