<?php

namespace backend\controllers;

use appxq\sdii\utils\VarDumper;
use cpn\chanpan\classes\CNMessage;
use Yii;
use backend\models\BillItems;
use backend\models\search\BillItems as BillItemsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
// use appxq\sdii\helpers\SDHtml; 

/**
 * BillItemsController implements the CRUD actions for BillItems model.
 */
class BillItemsController extends Controller
{
    public function behaviors()
    {
        return [
//	    'access' => [
//            'class' => AccessControl::className(),
//            'rules' => [
//                [
//                'allow' => true,
//                'actions' => ['index', 'view'],
//                'roles' => ['?', '@'],
//                ],
//                [
//                'allow' => true,
//                'actions' => ['view', 'create', 'update', 'delete', 'deletes'],
//                'roles' => ['@'],
//                ],
//            ],
//	    ],
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
     * Lists all BillItems models.
     * @return mixed
     */
    public function actionIndex()
    {
         
        $searchModel = new BillItemsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    

    /**
     * Displays a single BillItems model.
     * @param string $id
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
     * Creates a new BillItems model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
	if (Yii::$app->getRequest()->isAjax) {
            
            $model = new BillItems(); 
            $billno = 0001;
            $lastrecord = BillItems::find()->orderBy(['billno'=>SORT_DESC])->one();
            if($lastrecord){
                $billno = $lastrecord['billno']+1;
            }
            $model->billno = sprintf("%05d",$billno); 
            $model->id = \appxq\sdii\utils\SDUtility::getMillisecTime();
             
	    if ($model->load(Yii::$app->request->post())) {
                
                $model->shop_id = 0;
//                $model->btype =1;
//                $model->status=1;
//                $model->charge=1;
//                $model->amount=0;
//                $model->amount='0';
                $model->rstat=1; 
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
     * Updates an existing BillItems model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
	    $model = $this->findModel($id);
        $bid = $model->id;
        Yii::$app->session['bill_id'] = $bid;
        Yii::$app->session['price'] = $model->amount;

	    if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return \cpn\chanpan\classes\CNMessage::getSuccess('Update successfully');
            } else {
                return \cpn\chanpan\classes\CNMessage::getError('Can not update the data.', $model->errors);
            }
	    } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
	    }
    }

    /**
     * Deletes an existing BillItems model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
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

    public function actionDeletes() {
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
     * Finds the BillItems model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return BillItems the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BillItems::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionUploadFiles($id) {
        
	 if (Yii::$app->getRequest()->isAjax) {
	    $model = new BillItems(); 
            $post = \Yii::$app->request->post('BillItems');
	    if ($post) {
                $file = \backend\classes\KNFileUpload::upload($model, 'bill_upload');
                
                if($file['success'] == true){
                    $bill = new \backend\models\Files();
                    $bill->bill_id = $id;
                    $bill->filename = $file['msg'];
                    $bill->filepath = $file['path'];
                    $bill->create_at = \backend\classes\KNUser::getUserId();
                    $bill->create_date = \appxq\sdii\utils\SDdate::get_current_date_time();
                    $bill->rstat = 1;
                    $bill->billtype = $post['billtype'];
                    if($bill->save()){
                        $files = \backend\models\Files::find()->where('bill_id=:bill_id',[
                            ':bill_id'=>$id
                        ])->all();
                        return \cpn\chanpan\classes\CNMessage::getSuccess('Success', $files);
                    }
                     
                }
                
	    } 
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }
    public function actionPreviewImage($id) {
            $files = \backend\models\Files::find()->where('bill_id=:bill_id AND rstat not in(0,3)', [
                        ':bill_id' => $id
                    ])->orderBy(['id' => SORT_DESC])->all();
            if ($files) {
                return $this->renderAjax("preview-image", ['files' => $files]);
            }
            return '<h3 class="text-center">ยังไม่มีรูปภาพ</h3>';
        
    }
    public function actionDeleteFiles() {
        if (\Yii::$app->getRequest()->isAjax) {
            $id = \Yii::$app->request->post('id');
            $files = \backend\models\Files::find()->where('id=:id AND rstat not in(0,3)', [
                        ':id' => $id
                    ])->one();
            // \appxq\sdii\utils\VarDumper::dump($files);
            if ($files) {
                $files->rstat = 3;
                if ($files->update()) {
                    return \cpn\chanpan\classes\CNMessage::getSuccess('Success');
                } else {
                    return \cpn\chanpan\classes\CNMessage::getError('Error');
                }
            }
        } else {
            throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
        }
    }
    public function actionUpdateShipping() {
        $shiping = Yii::$app->request->post('shiping','');
        $bill_id = Yii::$app->request->post('bill_id','');
        $status = Yii::$app->request->post('status','');

        if($status == 'shipping'){
            if($shiping == '2'){
                return CNMessage::getError('ไม่สามารถจัดสินค้าได้');
            }
        }

        $model = BillItems::findOne($bill_id);
        if($model){
            $model->shiping = $shiping;
            if($model->update()){
                return CNMessage::getSuccess("Success");
            }
            return CNMessage::getError("Error");
        }
    }
    
    public function actionGenerateBillType() {
        $bilName = date('ym');
        return $bilName."-";
    }
    
    public function actionGetBillno() {
        $id = Yii::$app->request->get('id','');
        $model = \backend\models\Groups::find()->where('id=:id',[':id'=>$id])->one();
        if($model){
            $value = "1";
            if(!isset($model->selecteds) || $model->selecteds == ''){
                if(isset($model->value) && $model->value != ''){
                    $value = $model->value; //default
                    $model->selecteds = $value;
                    $model->save();
                   
                }
            }else{
                $value = (int)$model->selecteds;
                $value = sprintf("%05d",$value); 
                $billItems = BillItems::find()->where('billno=:billno',[':billno'=>$value])->one();
                if($billItems){
                    $value = (int)$model->selecteds+1;
                }
                $value = sprintf("%05d",$value);
            }
            
        }
        return $value;
        
    }
    
    
}
