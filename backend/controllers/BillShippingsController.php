<?php

namespace backend\controllers;

use Yii;
use backend\models\BillShippings;
use backend\models\search\BillShippings as BillShippingsSearch;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use appxq\sdii\helpers\SDHtml;

/**
 * BillShippingsController implements the CRUD actions for BillShippings model.
 */
class BillShippingsController extends Controller
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
     * Lists all BillShippings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new \backend\models\search\BillItems();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionManage(){
        $bill_id = \Yii::$app->request->get('bill_id');
        $query = BillShippings::find()->where('bill_id=:bill_id AND rstat not in(0,3)',[':bill_id'=>$bill_id]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20000,
            ],
        ]);

        return $this->renderAjax('manage', [
            'dataProvider' => $dataProvider,
            'bill_id' => $bill_id
        ]);
    }


    /**
     * Displays a single BillShippings model.
     * @param string $bill_id
     * @param string $user_id
     * @return mixed
     */
    public function actionView($bill_id, $user_id)
    {
	if (Yii::$app->getRequest()->isAjax) {
	    return $this->renderAjax('view', [
		'model' => $this->findModel($bill_id, $user_id),
	    ]);
	} else {
	    return $this->render('view', [
		'model' => $this->findModel($bill_id, $user_id),
	    ]);
	}
    }

    /**
     * Creates a new BillShippings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = new BillShippings();
            $bill_id = \Yii::$app->request->get('bill_id');
	    if ($model->load(Yii::$app->request->post())) {
		$file = \backend\classes\KNFileUpload::upload($model, 'file_upload');
                if($file['success'] == true){
                    $model->file_upload = $file['msg'];
                }
                $model->rstat = 1;
                $model->create_by = \backend\classes\CNUser::get_id();
                $model->create_date = \appxq\sdii\utils\SDdate::get_current_date_time();
		if ($model->save()) {
		    return \cpn\chanpan\classes\CNMessage::getSuccess('Create successfully');
		} else {
		    return \cpn\chanpan\classes\CNMessage::getError('Can not create the data.', $model->errors);
		}
	    } else {
                $model->bill_id = $bill_id;
		return $this->renderAjax('create', [
		    'model' => $model,
		]);
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }

    /**
     * Updates an existing BillShippings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $bill_id
     * @param string $user_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = BillShippings::find()->where('bill_id =:id',[':id'=>$id])->one();

	    if ($model->load(Yii::$app->request->post())) {
		$file = \backend\classes\KNFileUpload::upload($model, 'file_upload');
                if($file['success'] == true){
                    $model->file_upload = $file['msg'];
                }
                $model->rstat = 1;
                $model->update_by = \backend\classes\CNUser::get_id();
                $model->update_date = \appxq\sdii\utils\SDdate::get_current_date_time();
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
     * Deletes an existing BillShippings model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $bill_id
     * @param string $user_id
     * @return mixed
     */
    public function actionDelete($id)
    {
	if (Yii::$app->getRequest()->isAjax) {

	    $model = BillShippings::find()->where('id =:id',[':id'=>$id])->one();
	    //\appxq\sdii\utils\VarDumper::dump($id);

            $model->rstat = 3;
            $model->update_by = \backend\classes\CNUser::get_id();
            $model->update_date = \appxq\sdii\utils\SDdate::get_current_date_time();
	    if ($model->update()) {
		    return \cpn\chanpan\classes\CNMessage::getSuccess('Delete successfully');
	    } else {
		    return \cpn\chanpan\classes\CNMessage::getError('Can not delete the data.');
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
     * Finds the BillShippings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $bill_id
     * @param string $user_id
     * @return BillShippings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($bill_id, $user_id)
    {
        if (($model = BillShippings::findOne(['bill_id' => $bill_id, 'user_id' => $user_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
