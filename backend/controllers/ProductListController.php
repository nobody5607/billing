<?phpnamespace backend\controllers;use appxq\sdii\utils\SDdate;use appxq\sdii\utils\VarDumper;use backend\classes\KNUser;use backend\models\BillItems;use backend\models\UserPercent;use backend\models\UserSippings;use cpn\chanpan\classes\CNMessage;use \common\modules\user\models\User;use yii\web\Controller;class ProductListController extends Controller{    public function actionIndex(){      $output=[];      $bill_id = isset(\Yii::$app->session['bill_id'])?\Yii::$app->session['bill_id']:'';      $bill = BillItems::find()->where('id=:id',[          ':id'=>$bill_id      ])->orderBy(['create_by'=>SORT_ASC])->one();      $billType = \backend\models\BillType::findOne($bill['bill_type']);          $output['bill'] = $bill;        $totalCommission = 0;      if($bill){          $sql="            SELECT *,(SELECT groupname FROM sell_shipping WHERE sell_items.itemcode like groupcond) as groupname,            (SELECT percent*100 FROM sell_shipping WHERE sell_items.itemcode like groupcond) as percent,            netprice*(SELECT percent FROM sell_shipping WHERE sell_items.itemcode like groupcond) as commission             FROM sell_items WHERE docno=:billref;          ";          $data = \Yii::$app->db->createCommand($sql,[':billref'=>$billType['name'].$bill['billref']])->queryAll();          foreach($data as $k=>$v){              $totalCommission += isset($v['commission'])?$v['commission']:0;          }          if($data){              $output['billDetail'] = $data;          }          $output['totalCommission'] = $totalCommission;          \Yii::$app->session['totalCommission'] = $output['totalCommission'];      }      if(\Yii::$app->request->isAjax){          return $this->renderAjax('index',[              'output'=>$output          ]);      }      return $this->render('index',[          'output'=>$output      ]);    }    public function actionAddDriver(){        $type = \Yii::$app->request->get('type');        $parent_id = \Yii::$app->request->get('parent_id');        $model = new UserSippings();        $model->type = $type;        $model->parent_id = $parent_id;        $model->percent = "0.30";        if($model->load(\Yii::$app->request->post())){            $bill_id = isset(\Yii::$app->session['bill_id'])?\Yii::$app->session['bill_id']:'';            $model->bill_id = $bill_id;            $model->rstat = 1;            $model->create_by = KNUser::getUserId();            $model->create_date = SDdate::get_current_date_time();            if($model->save()){                return CNMessage::getSuccess('Success');            }else{                return CNMessage::getError("Error", $model->errors);            }        }        if(\Yii::$app->request->isAjax){            return $this->renderAjax('add-driver',[                'model'=>$model            ]);        }        return $this->render('add-driver',[            'model'=>$model        ]);    }    public function actionDelete(){        $id = \Yii::$app->request->get('id');        $model = UserSippings::find()->where('id=:id',[":id"=>$id])->one();        if($model){            $model->rstat = 3;            if($model->save()){                return CNMessage::getSuccess('Success');            }else{                return CNMessage::getError("Error");            }        }    }    public function actionInitPreviewUserShipping(){        $bill_id = isset(\Yii::$app->session['bill_id'])?\Yii::$app->session['bill_id']:'';        $model = UserSippings::find()->where('bill_id=:id AND parent_id is null AND rstat not in(0,3)',[':id'=>$bill_id])->all();        $output = [            'driver'=>[            ],        ];                foreach($model as $k=>$v){            $user = User::findOne($v->user_id);            $name = isset($user->profile->name)?$user->profile->name:'';            $output['driver'][$k] = ['id'=>$v->id,'userId'=>$user->id,'userName'=>$name,'percent'=>isset($v->percent)?$v->percent:'0.00'];            $parent = UserSippings::find()->where('bill_id=:id AND parent_id=:parent_id AND rstat not in(0,3)',[                ':id'=>$bill_id,                ':parent_id'=>$v->id            ])->all();            if($parent){                foreach($parent as $k2=>$v2){                    $user2 = \backend\models\Customers::findOne($v2->user_id);                    $name = isset($user2->name)?$user2->name:'';                                        $output['driver'][$k]['parent'][$k2] = [                        'id'=>$v2->id,                        'userId'=>isset($user2->id)?$user2->id:'',                        'userName'=>$name,                        'percent'=>isset($v2->percent)?$v2->percent:'0.00'                    ];//                    \appxq\sdii\utils\VarDumper::dump($output);                }            }        }                if(\Yii::$app->request->isAjax){            return $this->renderAjax('init-preview-user-shipping',[                'model'=>$output            ]);        }        return $this->render('init-preview-user-shipping',[               'model'=>$output        ]);    }    public function actionCalPercent(){        $rdpTotal=0;        $rdkTotal = 0;        $rdks=0;        $rdps=0;        $rdk=0;        $rdp=0;        $a=0;$b=0;$dk=0;        $bill_id = isset(\Yii::$app->session['bill_id'])?\Yii::$app->session['bill_id']:'';        $totalCommission = isset(\Yii::$app->session['totalCommission'])?\Yii::$app->session['totalCommission']:0;        $userShipping = UserSippings::find()->where('bill_id = :bill_id and rstat not in(0,3)',[            ':bill_id' => $bill_id        ])->all();        $userPercent = UserPercent::find()->where(['bill_id'=>$bill_id, 'default'=>1])->one();        if($userPercent){            $dk = isset($userPercent['customer'])?$userPercent['customer']:0;        }        //VarDumper::dump($userPercent['customer']);        if($userShipping){            foreach($userShipping as $k=>$v){                if($v['parent_id'] == ''){                    $a++;                }                if($v['parent_id'] != ''){                    $b++;                }            }        }        $total = $totalCommission; //จำนวน percent ทั้งหมด        //$a = 2; //จำนวนคนขับ        //$b = 4; //จำนวนลูกน้อง        //$dk = 30; //ลูกน้อง 30%        if($dk==0 && $a == 0){            $rdk = 0;        }else{            $rdk = $dk/$a; //30/2 = 15% //ลูกน้องแต่ละคนจะได้        }         if($rdk == 0 && $b == 0 && $a == 0){            $rdp = 0;        }else{            $rdp = (100-$rdk*$b)/$a; // (100-15*4)/2 = 20% คนขับแต่ละคนจะได้        }                        $rdks = $rdk*$b;        $rdps = $rdp*$a;        $rdpTotal = ($rdp*$total)/100; //คนขับคนนึงจะได้        $rdkTotal = ($rdk*$total)/100; //ลูกน้องคนนึงจะได้        $rdpTotals = number_format($rdpTotal, 2);        $rdkTotals = number_format($rdkTotal, 2);        $rdkss = number_format($rdks, 2);        $rdpss = number_format($rdps, 2);        $rdks = number_format($rdk, 2);        $rdps = number_format($rdp, 2);        //คนขับ จะได้คนละ 20%(64 บาท)  มี 2 คน รวมกันด้ 40%(128 บาท)        //ลูกน้องจะได้คนละ 15%(48 บาท) มี 4 คน รวมกันได้ 60% (192 บาท)        $msgRdp = "คนขับ จะได้คนละ {$rdps}%({$rdpTotals} บาท)  มี {$a} คน รวมกันได้ {$rdpss}%(".$rdpTotal*$a." บาท)";        $msgRdk = "ลูกน้องจะได้คนละ {$rdks}%({$rdkTotals} บาท) มี {$b} คน รวมกันได้ {$rdkss}% (".$rdkTotal*$b." บาท)";        $output = [          'driver'=>$msgRdp,          'customer'=>$msgRdk        ];        //VarDumper::dump($totalCommission);        return $this->renderAjax('cal-percent',['output'=>$output]);        //VarDumper::dump($msgRdk);    }    //add-driver    public function actionUpload(){        $file = \yii\web\UploadedFile::getInstanceByName('exfile');        if($file){             $fileName = date('YmdHis').rand(0,99).'.'.$file->extension;             $path = \Yii::getAlias('@storage').'/web/uploads';             $filePath= "{$path}/{$fileName}";             if($file->saveAs($filePath)){                 if(\backend\classes\BillManager::saveData($fileName)['status'] == true){                     return CNMessage::getSuccess('อัปโหลดสำเร็จ');                 }             }            return CNMessage::getSuccess('เกิดข้อผิดพลาด');        }    }}