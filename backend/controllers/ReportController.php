<?phpnamespace backend\controllers;use appxq\sdii\utils\SDdate;use appxq\sdii\utils\SDUtility;use appxq\sdii\utils\VarDumper;use backend\classes\BillManager;use backend\models\BillItems;use backend\models\BillType;use backend\models\Commissions;use backend\models\Groups;use backend\models\SellBill;use backend\models\SellItems;use backend\models\UserSippings;use yii\data\ActiveDataProvider;use yii\db\Exception;use yii\db\Expression;use yii\db\Query;use yii\web\Controller;class ReportController extends Controller{    public function beforeAction($action)    {        $actionArr = ['customer-car','sell-bill','bill-items','find-bill-all','customer-car-data','sell-product-by-docno','block','block-data'];        if(in_array($action->id , $actionArr))        {            if(!\Yii::$app->user->can('report')){                return $this->redirect(['/site/']);            }        }        //return true;        return parent::beforeAction($action);    }    public function actionCustomerCar()    {//        $model        return $this->render("customer-car");    }    public function actionIndex(){        $stdate = \Yii::$app->request->get('stdate',null);        $endate = \Yii::$app->request->get('endate',null);        $bill_type = \Yii::$app->request->get('bill_type',null);        $rstat = \Yii::$app->request->get('rstat',null);        $bill_status = \Yii::$app->request->get('bill_status',null);        $charge = \Yii::$app->request->get('charge',null);        $shiping = \Yii::$app->request->get('shiping',null);        $customer1 = \Yii::$app->request->get('customer1',null);        $customer2 = \Yii::$app->request->get('customer2',null);        \Yii::$app->session['sqlCommand']="";        //customer        //shiping        $model = BillItems::find()            ->where("billref NOT LIKE '%POS%' AND rstat not in(3)");        if($stdate != null && $endate != null){            $stdate = SDdate::convertDmyToYmd($stdate);            $endate = SDdate::convertDmyToYmd($endate);            $model = $model->andWhere(['between', 'bill_date', $stdate, $endate]);        }        if($customer1 != null || $customer2 != null){            $customerId = [];            for($i=$customer1; $i<=$customer2; $i++)            {                array_push($customerId, "AR{$i}");            }            $output = join("|", $customerId);            //VarDumper::dump($output);            $model = $model->where('customer_id REGEXP :params',[                ':params' => $output            ]);            //VarDumper::dump($model->all());        }        if($charge != null){            $model = $model->andWhere('charge=:charge',[                ':charge' => $charge            ]);        }        if($rstat != null){            $model = $model->andWhere('rstat=:rstat',[                ':rstat' => $rstat            ]);        }        if($bill_status != null){            $model = $model->andWhere('status=:status',[                ':status' => $bill_status            ]);        }        if( $shiping != null){            $model = $model->andWhere('shiping=:shiping',[                ':shiping' => $shiping            ]);        }        //status        $model = $model->orderBy(['bill_date'=>SORT_DESC]);        $dataProvider = new ActiveDataProvider([            'query' => $model,            'pagination' => [                'pageSize' => 50,            ],        ]);        $count = $model->count();        return $this->render("index",[            'dataProvider'=>$dataProvider,            'count'=>$count,            'title'=>''        ]);    }    public function actionSellBill(){        $stdate = \Yii::$app->request->get('stdate');        $endate = \Yii::$app->request->get('endate');        $model = SellBill::find();        if($stdate != null && $endate != null){            $stdate = SDdate::convertDmyToYmd($stdate);            $endate = SDdate::convertDmyToYmd($endate);            //VarDumper::dump($stdate);            $model = $model->andWhere(['between', 'docdate', $stdate, $endate]);        }        $dataProvider = new ActiveDataProvider([            'query' => $model,            'pagination' => [                'pageSize' => 50,            ],        ]);        return $this->render("sell-bill",[            'dataProvider'=>$dataProvider        ]);    }    public function actionBillItems(){        $model = BillItems::find()            ->where('rstat not in(0,3) AND status <> 5');        $dataProvider = new ActiveDataProvider([            'query' => $model,            'pagination' => [                'pageSize' => 50,            ],        ]);        return $this->render("bill-items",[            'dataProvider'=>$dataProvider        ]);    }    public function actionFindBillAll()    {        return $this->render("find-bill-all",[            //'dataProvider'=>$dataProvider        ]);    }    public function actionCustomerCarData()    {        ini_set("memory_limit","1024M");        $output = [];        $stdate = \Yii::$app->request->post('stdate');        $endate = \Yii::$app->request->post('endate');        $user_id = \Yii::$app->request->post('user_id');//        $userx = UserSippings::find()->all();//        foreach($userx as $k=>$v){//            $bill = BillItems::findOne($v['bill_id']);//            if($bill){//                $v->bill_date = $bill->bill_date;//                $v->save();//            }//        }        $sql ="select * from user_sippings where bill_date BETWEEN :stdate AND :endate AND user_id=:user_id AND treasury is null AND  rstat not in(0,3) group by bill_id";        $billAll = \Yii::$app->db->createCommand($sql,[':stdate'=>$stdate,':endate'=>$endate,':user_id'=>$user_id])->queryAll();//        VarDumper::dump($billAll);        if (!$billAll) {            return "<h3 class='text-center'>ไม่พบข้อมูล</h3>";        }        $token = SDUtility::getMillisecTime();        foreach ($billAll as $k => $v) {//            $bill = BillManager::reportCustomerCar2($v['bill_id'],[],$v['user_id']);//            VarDumper::dump($bill);            foreach($bill as $k2=>$b){                if(isset($b['user_id'])){                    $model = new Commissions();                    $model->token = $token;                    $model->bill_id = $v['bill_id'];                    $model->user_id = $b['user_id'];                    $model->driver = $b['driver'];                    $model->position = $b['position'];                    $model->price = $b['price'];                    $model->create_date = $v['bill_date'];                    $model->save();                }            }        }        $data = Commissions::find()            ->where('token=:token',[':token' => $token])->all();        $output = $data;        foreach($data as $k=>$v){            $v->delete();        }//        VarDumper::dump($data);        return $this->renderAjax("customer-car-data",[            'data'=>$data        ]);    }    public function actionSellProductByDocno(){        $docno = \Yii::$app->request->get('docno');        $model = SellItems::find()->where('docno=:docno',[":docno" => $docno]);        $dataProvider = new ActiveDataProvider([            'query' => $model,            'pagination' => [                'pageSize' => 10000,            ],        ]);        return $this->renderAjax("sell-product-by-docno",[            'dataProvider'=>$dataProvider        ]);    }    public function actionBlock(){        $block=Groups::find()->all();        return $this->render("block",[            'block'=>$block        ]);    }    public function actionBlockData(){        if(\Yii::$app->request->post()){            $block = \Yii::$app->request->post('block');            \Yii::$app->session['block'] = $block;            $blog = Groups::findOne($block);            $billno = [];           //VarDumper::dump($blog);            for($i=$blog->value;$i<$blog->value+500; $i++){                array_push($billno,(string)$i);            }            //$model = BillItems::find()->where(['billno'=>$billno])->all();        }        return $this->renderAjax("block-data",[            'billno'=>$billno,            'block'=>$block,            'blog'=>$blog            //'model'=>$model        ]);    }    public function actionCustomerPackage(){        return $this->render("customer-package",[        ]);    }    public function actionCustomerPackageData()    {        $output = [];        $stdate = \Yii::$app->request->post('stdate');        $endate = \Yii::$app->request->post('endate');        $user_id = \Yii::$app->request->post('user_id');        $sql ="select * from user_sippings where bill_date BETWEEN :stdate AND :endate AND user_id=:user_id AND treasury <> '' AND rstat not in(0,3) group by bill_id";        $billAll = \Yii::$app->db->createCommand($sql,[':stdate'=>$stdate,':endate'=>$endate,':user_id'=>$user_id])->queryAll();        if (!$billAll) {            return "<h1 class='text-center'>ไม่พบข้อมูล</h1>";        }        $token = SDUtility::getMillisecTime();        foreach ($billAll as $k => $v) {            $bill = BillManager::reportCustomerPackage2($v['bill_id'],$user_id);            foreach($bill as $k2=>$b){                if(isset($b['user_id'])){                    $model = new Commissions();                    $model->token = $token;                    $model->bill_id = $v['bill_id'];                    $model->user_id = $b['user_id'];                    $model->driver = $b['driver'];                    $model->position = 'พนักงานจัดของ';                    $model->price = (string)$b['com'];                    $model->create_date = $v['bill_date'];                    $model->percent_package = $b['percent_package'];                    $model->treasury = $b['treasury'];                    $model->factor = $b['factor'];                    if(!$model->save()){                        VarDumper::dump($model->errors);                    }                }            }        }            $data = Commissions::find()                ->where('token=:token',[':token' => $token])->all();            $output = $data;            foreach($data as $k=>$v){                $v->delete();            }            //VarDumper::dump($dataOutput);            return $this->renderAjax("customer-package-data",[                'data'=>$output            ]);    }}