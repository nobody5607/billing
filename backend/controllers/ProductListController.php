<?phpnamespace backend\controllers;use appxq\sdii\utils\SDdate;use appxq\sdii\utils\SDUtility;use appxq\sdii\utils\VarDumper;use backend\classes\BillManager;use backend\classes\KNUser;use backend\models\BillItems;use backend\models\BillType;use backend\models\Customers;use backend\models\Storages;use backend\models\Tcpg;use backend\models\Treasurys;use backend\models\UserPercent;use backend\models\UserSippings;use cpn\chanpan\classes\CNMessage;use \common\modules\user\models\User;use yii\web\Controller;class ProductListController extends Controller{    public function actionIndex(){        $bill_id = \Yii::$app->request->get('bill_id');         if(\Yii::$app->request->isAjax){             return $this->renderAjax('index',[                 'bill_id'=>$bill_id             ]);         }else{             return $this->render('index',[                 'bill_id'=>$bill_id             ]);         }    }    public function actionData(){      $output=[];      $bill_id = \Yii::$app->request->get('bill_id');      $bill = BillItems::find()->where('id=:id',[          ':id'=>$bill_id      ])->orderBy(['create_by'=>SORT_ASC])->one();      // VarDumper::dump($bill);      //$billType = \backend\models\BillType::findOne($bill['bill_type']);        $output['bill'] = $bill;        $totalCommission = 0;      if($bill){          $sql="            SELECT *,             (SELECT groupname FROM sell_shipping WHERE si.itemcode like groupcond) as groupname,             (SELECT (percent*100)/100 FROM sell_shipping WHERE si.itemcode like groupcond) as percent,             totaldiscount*(SELECT percent FROM sell_shipping WHERE si.itemcode like groupcond)/100 as commission,             (SELECT percent_package FROM sell_shipping WHERE si.itemcode like groupcond) as percent_package,             totaldiscount*(SELECT percent_package/100 FROM sell_shipping WHERE si.itemcode like groupcond) as commission_package            FROM sell_items as si WHERE docno=:billref;          ";          //VarDumper::dump($billType['name'].$bill['billref']);          $data = \Yii::$app->db->createCommand($sql,[':billref'=>$bill['billref']])->queryAll();          foreach($data as $k=>$v){              $totalCommission += isset($v['commission'])?$v['commission']:0;          }          if($data){              $output['billDetail'] = $data;          }          $output['totalCommission'] = $totalCommission;          \Yii::$app->session['totalCommission'] = $output['totalCommission'];      }      if(\Yii::$app->request->isAjax){          return $this->renderAjax('data',[              'output'=>$output          ]);      }      return $this->render('data',[          'output'=>$output      ]);    }        public function actionAddDriver(){        $type = \Yii::$app->request->get('type');        $parent_id = \Yii::$app->request->get('parent_id');        $model = new UserSippings();        $model->type = $type;        $model->parent_id = $parent_id;        $model->percent = "0.30";        if($model->load(\Yii::$app->request->post())){            $bill_id = isset(\Yii::$app->session['bill_id'])?\Yii::$app->session['bill_id']:'';            $model->bill_id = $bill_id;            $model->rstat = 1;            $model->create_by = KNUser::getUserId();            $model->create_date = SDdate::get_current_date_time();            if($model->save()){                return CNMessage::getSuccess('Success');            }else{                return CNMessage::getError("Error", $model->errors);            }        }        if(\Yii::$app->request->isAjax){            return $this->renderAjax('add-driver',[                'model'=>$model            ]);        }        return $this->render('add-driver',[            'model'=>$model        ]);    }    public function actionAddPackage(){        $type = \Yii::$app->request->get('type');        $parent_id = \Yii::$app->request->get('parent_id');        $model = new UserSippings();        $model->type = $type;        $model->parent_id = $parent_id;        $model->percent = "0.30";        if($model->load(\Yii::$app->request->post())){            $bill_id = isset(\Yii::$app->session['bill_id'])?\Yii::$app->session['bill_id']:'';            $model->bill_id = $bill_id;            $model->rstat = 1;            $model->create_by = KNUser::getUserId();            $model->create_date = SDdate::get_current_date_time();            //VarDumper::dump($model);            if($model->save()){//                VarDumper::dump('OK');                return CNMessage::getSuccess('Success');            }else{                return CNMessage::getError("Error", $model->errors);            }        }        if(\Yii::$app->request->isAjax){            return $this->renderAjax('add-package',[                'model'=>$model            ]);        }        return $this->render('add-package',[            'model'=>$model        ]);    }    public function actionDelete(){        $id = \Yii::$app->request->get('id');        $model = UserSippings::find()            ->where('id=:id',[":id"=>$id])->one();        if($model){            $model->rstat = 3;            if($model->save()){                $model = UserSippings::find()                    ->where('parent_id=:id',[":id"=>$id])->one();            if($model){                 $model->rstat = 3;                 $model->save();            }                return CNMessage::getSuccess('Success');            }else{                return CNMessage::getError("Error", $model->errors);            }        }    }    public function actionInitPreviewUserShipping(){        $bill_id = isset(\Yii::$app->session['bill_id'])?\Yii::$app->session['bill_id']:'';        $type = \Yii::$app->request->get('type','');        if($type == '99'){            $model = UserSippings::find()                ->where('bill_id=:id AND parent_id is null AND type=:type AND rstat not in(0,3)',[                    ':id'=>$bill_id,                    ':type'=>$type                ])->all();        }else{            $model = UserSippings::find()                ->where('bill_id=:id AND parent_id is null AND type not in(99) AND rstat not in(0,3)',[':id'=>$bill_id])->all();        }        $output = [            'driver'=>[            ],        ];                foreach($model as $k=>$v){            $user = \backend\models\Customers::findOne($v->user_id);                         $name = isset($user->name)?$user->name:'';            $storage = null;            $treasury = null;            if(isset($v->storage) && isset($v->treasury)){                $storage = Storages::findOne($v->storage);                $treasury = Treasurys::findOne($v->treasury);            }            $output['driver'][$k] = [                'storage'=>($storage != null)?$storage['name']:'',                'treasury'=>($treasury != null)?$treasury['name']:'',                'id'=>$v->id,'userId'=>$user->id,                'userName'=>$name,                'percent'=>isset($v->percent)?$v->percent:'0.00'            ];            $parent = UserSippings::find()->where('bill_id=:id AND parent_id=:parent_id AND rstat not in(0,3)',[                ':id'=>$bill_id,                ':parent_id'=>$v->id            ])->all();            if($parent){                foreach($parent as $k2=>$v2){                    $user2 = \backend\models\Customers::findOne($v2->user_id);                    $name = isset($user2->name)?$user2->name:'';                                        $output['driver'][$k]['parent'][$k2] = [                        'id'=>$v2->id,                        'userId'=>isset($user2->id)?$user2->id:'',                        'userName'=>$name,                        'percent'=>isset($v2->percent)?$v2->percent:'0.00'                    ];                                    }            }        }//        VarDumper::dump($output);        if(\Yii::$app->request->isAjax){            if($type == '99'){                return $this->renderAjax('init-preview-user-package',[                    'model'=>$output,                    'type'=>$type                ]);            }            return $this->renderAjax('init-preview-user-shipping',[                'model'=>$output,                'type'=>$type            ]);        }        return $this->render('init-preview-user-shipping',[               'model'=>$output,                'type'=>$type        ]);    }    public function actionCalPercent(){        $rdpTotal=0;        $rdkTotal = 0;        $rdks=0;        $rdps=0;        $rdk=0;        $rdp=0;        $a=0;$b=0;$dk=0;        //totaldiscount จำนวนเงินทั้งสิ้น        $bill_id = isset(\Yii::$app->session['bill_id'])?\Yii::$app->session['bill_id']:'';        //Yii::$app->session['totalCommission']        $totalCommission = BillManager::getTotalCommission($bill_id);//isset(\Yii::$app->session['totalCommission'])?\Yii::$app->session['totalCommission']:0;        //VarDumper::dump($totalCommission);        $userShipping = UserSippings::find()->where('bill_id = :bill_id AND type <> 99 AND rstat not in(0,3)',[            ':bill_id' => $bill_id        ])->all();         $userPercent = UserPercent::find()->where(['bill_id'=>$bill_id, 'default'=>1])->one();                        if(!$userPercent){            $userPercent = UserPercent::find()->where(['id'=>'10000'])->one();        }        if($userPercent){            $dk = isset($userPercent['customer'])?$userPercent['customer']:0;        }        if($userShipping){            foreach($userShipping as $k=>$v){                if($v['parent_id'] == ''){                    $a++; //คนขับ                }                if($v['parent_id'] != ''){                    $b++; //ลูกน้อง                }            }        }        $percentAffective = 0;        $percentAffectiveSum = 0;        $total = $totalCommission; //จำนวน percent ทั้งหมด                $billItems = BillItems::findOne($bill_id);        $affective_score = isset($billItems['affective_score'])?$billItems['affective_score']:'';                //ความยาก        $bill = BillItems::findOne($bill_id);        $difficulty = \backend\models\Difficultys::findOne($bill->difficulty);        $dify = $difficulty['percent']/100; //ค่าความยาก                        $total *= $dify; //หาความยาก        $difPrice = $total;                $models = \backend\models\AffectiveScore::find()->where('id=:id',[            ':id'=>$affective_score        ])->one();        //จิตวิสัย                                                 $aff = '';        if($models){            $percent = isset($models['percent'])?$models['percent']:0;             $aff = $percent/100; //จิตวิสัย            $total *= $aff; //คูนจิตพิสัย//            $percentAffective = $total;// * $percent;//            $percentAffectiveSum = $total-$percentAffective;//            $total = $percentAffective*$difficulty;            //VarDumper::dump($total);        }  //        //VarDumper::dump($total);        //$a = 2; //จำนวนคนขับ        //$b = 4; //จำนวนลูกน้อง        //$dk = 30; //ลูกน้อง 30%        if($dk==0 || $a == 0){            $rdk = 0;        }else{            $rdk = $dk/$a; //30/2 = 15% //ลูกน้องแต่ละคนจะได้        }         if($rdk == 0 && $b == 0 && $a == 0){            $rdp = 0;        }else{            $rdp = (100-$rdk*$b)/$a; // (100-15*4)/2 = 20% คนขับแต่ละคนจะได้        }                        $rdks = $rdk*$b;        $rdps = $rdp*$a;        $rdpTotal = ($rdp*$total)/100; //คนขับคนนึงจะได้        $rdkTotal = ($rdk*$total)/100; //ลูกน้องคนนึงจะได้        $rdpTotals = number_format($rdpTotal, 2);        $rdkTotals = number_format($rdkTotal, 2);        $rdkss = number_format($rdks, 2);        $rdpss = number_format($rdps, 2);        $rdks = number_format($rdk, 2);        $rdps = number_format($rdp, 2);        //คนขับ จะได้คนละ 20%(64 บาท)  มี 2 คน รวมกันด้ 40%(128 บาท)        //ลูกน้องจะได้คนละ 15%(48 บาท) มี 4 คน รวมกันได้ 60% (192 บาท)                $totalRDP = $rdpTotal*$a;        $totalrdkTotal = $rdkTotal*$b;                $msgRdp = "คนขับ จะได้คนละ {$rdps}%({$rdpTotals} บาท)  มี {$a} คน รวมกันได้ {$rdpss}%(". number_format($totalRDP, 2)." บาท)";        $msgRdk = "ลูกน้องจะได้คนละ {$rdks}%({$rdkTotals} บาท) มี {$b} คน รวมกันได้ {$rdkss}% (". number_format($totalrdkTotal, 2)." บาท)";                $drivers = [];                 $totalMoney = 0;        foreach($userShipping as $uk=>$uv){            $customer = \backend\models\Customers::findOne($uv['user_id']);                         if($uv['parent_id'] == null){                //คนขับ                $drivers[] = ['driver'=>$customer['name'], 'status'=>1,'price'=>$rdpTotals,'position'=>'คนขับ'];            }else{                $drivers[] = ['driver'=>$customer['name'], 'status'=>2,'price'=>$rdkTotals,'position'=>'ลูกน้อง'];            }        }        foreach($drivers as $k=>$p){            $totalMoney += $p['price'];        }        //VarDumper::dump($drivers);         $output = [          'difficulty'=>$difPrice,          'difficultyName'=>$difficulty['name'],          'aff'=>$aff,          'percentAffectiveSum'=>$percentAffectiveSum,          'driver'=>$msgRdp,          'customer'=>$msgRdk,          'totalMoney'=>$totalMoney          ];        //VarDumper::dump($totalCommission);        return $this->renderAjax('cal-percent',['output'=>$output,'drivers'=>$drivers]);        //VarDumper::dump($msgRdk);    }    public function actionCalPercent2(){        $bill_id = isset(\Yii::$app->session['bill_id'])?\Yii::$app->session['bill_id']:'';        $billItems = BillItems::findOne($bill_id);        $billType = BillType::find()->where('id=:id',[':id'=>$billItems->bill_type])->one();        $userShipping = UserSippings::find()->where('bill_id = :bill_id AND type=99 AND rstat not in(0,3)',[            ':bill_id' => $bill_id        ])->all();        //VarDumper::dump($userShipping);        $billref = "{$billItems['billref']}";        $sql="            SELECT storage,          (SELECT percent_package FROM sell_shipping WHERE sell_items.itemcode like groupcond) as percent_package,            FORMAT(totaldiscount*(SELECT percent_package/100 FROM sell_shipping WHERE sell_items.itemcode like groupcond),2) as commission_package            FROM sell_items WHERE docno=:billref;        ";        $data = \Yii::$app->db->createCommand($sql,[':billref'=>$billref])->queryAll();        $token = md5(SDUtility::getMillisecTime());        foreach($data as $k=>$v){            $model = new Tcpg();            $model->token = $token;            $model->treasury = $v['storage'];            $model->percent_package = $v['percent_package'];            $model->commission_package = $v['commission_package'];            $model->save();        }        $output = [];        $com = 0;        foreach($userShipping as $k=>$v){            $customer = Customers::findOne($v['user_id']);            $treasuryFind = Treasurys::findOne($v->treasury);            $treasury = $treasuryFind->name;            $countUserShipping = UserSippings::find()                ->where('bill_id = :bill_id AND type=99 AND treasury=:treasury AND rstat not in(0,3)',[                ':bill_id' => $bill_id,                    ':treasury' => $v['treasury']            ])->count();            $sql="                SELECT percent_package, sum(commission_package) as com FROM tcpg WHERE treasury=:treasury AND token = :token                              ";            $data = \Yii::$app->db->createCommand($sql,[':treasury'=>$treasury,':token'=>$token])->queryOne();            $com = isset($data['com'])?($data['com']/$countUserShipping)*$treasuryFind->factor:0;            $output[] = [                'factor'=>$treasuryFind->factor,                'customer'=>$customer['name'],                'treasury'=>$treasury,                'percent_package'=>$data['percent_package'],                'com'=>$com            ];        }        return $this->renderAjax('cal-percent2',['output'=>$output]);    }    //add-driver    public function actionUpload(){        $file = \yii\web\UploadedFile::getInstanceByName('exfile');        if($file){             $fileName = date('YmdHis').rand(0,99).'.'.$file->extension;             $path = \Yii::getAlias('@storage').'/web/uploads';             $filePath= "{$path}/{$fileName}";             if($file->saveAs($filePath)){                 if(\backend\classes\BillManager::saveData($fileName)['status'] == true){                     return CNMessage::getSuccess('อัปโหลดสำเร็จ');                 }             }            return CNMessage::getError('เกิดข้อผิดพลาด');        }    }    public function actionUploadRc(){        $file = \yii\web\UploadedFile::getInstanceByName('exfile');        if($file){            $fileName = date('YmdHis').rand(0,99).'.'.$file->extension;            $path = \Yii::getAlias('@storage').'/web/uploads';            $filePath= "{$path}/{$fileName}";            if($file->saveAs($filePath)){                if(\backend\classes\BillManager::saveData($fileName, 'rc')['status'] == true){                    return CNMessage::getSuccess('อัปโหลดสำเร็จ');                }            }            return CNMessage::getError('เกิดข้อผิดพลาด');        }    }}