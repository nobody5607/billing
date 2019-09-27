<?phpnamespace backend\classes;use appxq\sdii\utils\SDUtility;use appxq\sdii\utils\VarDumper;use backend\models\BillItems;use backend\models\BillType;use backend\models\Customers;use backend\models\SellBill;use backend\models\SellItems;use backend\models\UserPercent;use backend\models\UserSippings;use common\modules\user\models\Profile;use Yii;use yii\db\Exception;class BillManager{    public static  function renderBillDetail(){        $billId = isset(Yii::$app->session['bill_id'])?Yii::$app->session['bill_id']:'';        $bill = BillItems::find()->where('id=:id and rstat not in(0,3)',[            ':id'=>$billId        ])->one();       if($bill){           $billType = BillType::findOne($bill->bill_type);           $billStatus = BillType::findOne($bill->billref);           $type = isset($billType->name)?$billType->name:'ไม่ได้ตั้ง';           $status = isset($billStatus->name)?$billStatus->name:'ไม่ได้ตั้ง';           $price = number_format($bill->amount, 2);           $docno = "{$type}{$bill->billref}";           $sellBill = SellBill::findOne($docno);           $customername= isset($sellBill->customername)?$sellBill->customername:'';           $cpackage = Profile::find()->where(['cashier'=>$sellBill['cashier']])->one();           $fname = isset($cpackage['firstname'])?$cpackage['firstname']:'';           $lname = isset($cpackage['lastname'])?$cpackage['lastname']:'';           $name = "{$fname} {$lname}";           return '<div class="kt-portlet kt-iconbox kt-iconbox--success kt-iconbox--animate-slow">'           . '<div class="kt-portlet__body"><div class="kt-iconbox__body">'                   . '<div class="kt-iconbox__icon"><br></div><div class="kt-iconbox__desc">'                   . '<h4 class="kt-iconbox__title" style="font-size: 1.6rem;"><a class="kt-link" href="#">'                   . '<img src="https://img.icons8.com/color/48/000000/check.png"></a>'                   . 'หมายเลขบิล:'.$bill->billno.' เลขที่เอกสาร: '.$type.$bill->billref.' สถานะบิล: '.$status.' บิลเล่มที่: '.$bill->bookno.' จำนวนเงิน: '.$price.' บาท<br> ลูกค้า: '.$customername.' พนักงานขาย '.$name.'</h4>'                   . '</div></div></div></div>';           return "                           <div class='alert alert-info'>                <div>                    <img src=\"https://img.icons8.com/color/48/000000/check.png\">                    หมายเลขบิล:{$bill->billno} เลขที่เอกสาร:<b>{$bill->billref}</b> ประเภทบิล: {$type} สถานะบิล:{$status} บิลเล่มที่:{$bill->bookno}                &nbsp;&nbsp;&nbsp;&nbsp; <label>จำนวนเงิน: {$price} บาท</label>                </div>            </div>           ";       }    }    /**     * @param $fileName     * @throws \PHPExcel_Exception     * @throws \PHPExcel_Reader_Exception     */    public static function saveData($fileName){        ini_set('memory_limit', '-1');        set_time_limit(500); //        $path = \Yii::getAlias('@storage').'/web/uploads';        $file= "{$path}/{$fileName}";        try{            $inputFile = \PHPExcel_IOFactory::identify($file);            $objReader = \PHPExcel_IOFactory::createReader($inputFile);            $objPHPExcel = $objReader->load($file);        }catch (Exception $e){            return [                'status'=>false,                'message'=>'เกิดข้อผิดพลาด'. $e->getMessage()            ];                     }        $sheet = $objPHPExcel->getSheet(0);        $highestRow = $sheet->getHighestRow();        $highestColumn = $sheet->getHighestColumn();        $objWorksheet = $objPHPExcel->getActiveSheet();        $arr=[];//        VarDumper::dump($arr);        foreach($objWorksheet->getRowIterator() as $rowIndex => $row){            if($rowIndex < 10){ continue; }            $arr[] = $objWorksheet->rangeToArray('A'.$rowIndex.':'.$highestColumn.$rowIndex, null, false);        }        $column = [        ];        $docno = '';        $test = [];        foreach($arr as $k=>$v){            $date = isset($v[0][0]) ? $v[0][0]:'';//เอกสารวันที่            if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date))            {                try{//                    return $v[0];                    $docno = isset($v[0][1])?$v[0][1]:''; //เอกสารเลขที่                    if($docno == ''){continue;}                    //ถ้ามีข้อมูลจะแก้ไข                    $shellBill = SellBill::find()->where('docno=:docno',[                        ':docno' => $docno                    ])->one();                    if(!$shellBill){ //ถ้าไม่มีข้อมูลจะเพิ่มใหม่                        $shellBill = new SellBill();                    }                    $shellBill->docno = $docno;                    $shellBill->docdate = $date;                    $shellBill->doctime = isset($v[0][2])?$v[0][2]:null; //เวลา                    $shellBill->refdata = isset($v[0][3])?$v[0][3]:null;//เอกสารอ้างอิง                    $shellBill->refdate = isset($v[0][4])?$v[0][4]:null;//เอกสารอ้างอิงวันที่                    $shellBill->customerno = isset($v[0][5])?$v[0][5]:null;//ลูกหนี้/เจ้าหนี้                    $shellBill->customername = isset($v[0][6])?$v[0][6]:null;//ชื่อลูกหนี้/เจ้าหนี้                    $shellBill->totalprice = isset($v[0][7])?(string)$v[0][7]:null;//มูลค่าสินค้า                    $shellBill->netprice = isset($v[0][9])?(string)$v[0][9]:null;//มูลค่าหลังหักส่วนลด                    $shellBill->tax = isset($v[0][10])?(string)$v[0][10]:null;//มูลค่ายกเว้นภาษี                    $shellBill->vat = isset($v[0][11])?(string)$v[0][11]:null;//ภาษีมูลค่าเพิ่ม                    $shellBill->net_value = isset($v[0][12])?(string)$v[0][12]:null;//มูลค่าสุทธิ                    $shellBill->cashier = isset($v[0][13])?(string)$v[0][13]:null;//cashier                    if(!$shellBill->save()){                        VarDumper::dump($shellBill->errors);                    }                }catch (Exception $ex){}            }else{                try{                    if($docno == ''){continue;}                    $itemcode = isset($v[0][0])?$v[0][0]:null; //รหัสสินค้า                    if($itemcode == null) {continue;}                    $sellItems = SellItems::find()->where('docno=:docno AND itemcode=:itemcode',[                        ':docno'=>$docno,                        ':itemcode'=>$itemcode                    ])->one();                    //VarDumper::dump($docno);                    if(!$sellItems){ $sellItems = new SellItems(); }                    $sellItems->docno = $docno;//เอกสารเลขที่                    $sellItems->itemcode = $itemcode;//รหัสสินค้า                    $sellItems->itemname = isset($v[0][1])?$v[0][1]:null;//ชื่อสินค้า                    $sellItems->treasury = isset($v[0][2])?$v[0][2]:null;//คลัง                    $sellItems->storage = isset($v[0][3])?$v[0][3]:null;//พื้นที่เก็บ                    $sellItems->unit = isset($v[0][4])?$v[0][4]:null;//หน่วยนับ                    $sellItems->amount = isset($v[0][5])?(string)$v[0][5]:null;//จำนวน                    $sellItems->unitprice = isset($v[0][6])?(string)$v[0][6]:null;//ราคา                    $sellItems->unitdiscount = isset($v[0][7])?(string)$v[0][7]:null;//ส่วนลด                    $sellItems->discountvalue = isset($v[0][8])?$v[0][8]:null;//มูลค่าส่วนลด                    $sellItems->totaldiscount = isset($v[0][9])?(string)$v[0][9]:null;                    $sellItems->netprice = isset($v[0][10])?(string)$v[0][10]:null;//รวมมูลค่า                    if(!$sellItems->save()){ VarDumper::dump($sellItems->errors); }                }catch (Exception $ex){}            }        }        //VarDumper::dump("OK");        return [                'status'=>true,                'message'=>'เพิ่มข้อมูลสำเร็จ'        ];    }    public static function getTotalCommission($bill_id)    {        $output = [];//        $bill_id = \Yii::$app->request->get('bill_id');        $bill = BillItems::find()->where('id=:id', [            ':id' => $bill_id        ])->orderBy(['create_by' => SORT_ASC])->one();        $billType = \backend\models\BillType::findOne($bill['bill_type']);        $output['bill'] = $bill;        $totalCommission = 0;        if ($bill) {            $sql = "            SELECT *,            (SELECT groupname FROM sell_shipping WHERE sell_items.itemcode like groupcond) as groupname,            (SELECT (percent*100)/100 FROM sell_shipping WHERE sell_items.itemcode like groupcond) as percent,            netprice*(SELECT percent FROM sell_shipping WHERE sell_items.itemcode like groupcond)/100 as commission             FROM sell_items WHERE docno=:billref;          ";            //VarDumper::dump($billType['name'].$bill['billref']);            $data = \Yii::$app->db->createCommand($sql, [':billref' => $billType['name'] . $bill['billref']])->queryAll();            foreach ($data as $k => $v) {                $totalCommission += isset($v['commission']) ? $v['commission'] : 0;            }            if ($data) {                $output['billDetail'] = $data;            }            $output['totalCommission'] = $totalCommission;            return $output['totalCommission'];//            \Yii::$app->session['totalCommission'] = $output['totalCommission'];        }    }    public static function reportCustomerCar($bill_id){        $rdpTotal=0;        $rdkTotal = 0;        $rdks=0;        $rdps=0;        $rdk=0;        $rdp=0;        $a=0;$b=0;$dk=0;        //$bill_id = isset(\Yii::$app->session['bill_id'])?\Yii::$app->session['bill_id']:'';        $totalCommission = self::getTotalCommission($bill_id); //isset(\Yii::$app->session['totalCommission'])?\Yii::$app->session['totalCommission']:0;        $userShipping = UserSippings::find()->where('bill_id = :bill_id AND type <> 99 AND rstat not in(0,3)',[            ':bill_id' => $bill_id        ])->all();        $userPercent = UserPercent::find()->where(['bill_id'=>$bill_id, 'default'=>1])->one();        if(!$userPercent){            $userPercent = UserPercent::find()->where(['id'=>'10000'])->one();        }        if($userPercent){            $dk = isset($userPercent['customer'])?$userPercent['customer']:0;        }        if($userShipping){            foreach($userShipping as $k=>$v){                if($v['parent_id'] == ''){                    $a++; //คนขับ                }                if($v['parent_id'] != ''){                    $b++; //ลูกน้อง                }            }        }        $percentAffective = 0;        $percentAffectiveSum = 0;        $total = $totalCommission; //จำนวน percent ทั้งหมด        $billItems = BillItems::findOne($bill_id);        $affective_score = isset($billItems['affective_score'])?$billItems['affective_score']:'';        //ความยาก        $bill = BillItems::findOne($bill_id);        $difficulty = \backend\models\Difficultys::findOne($bill->difficulty);        $dify = $difficulty['percent']/100; //ค่าความยาก        $total *= $dify; //หาความยาก        $difPrice = $total;        $models = \backend\models\AffectiveScore::find()->where('id=:id',[            ':id'=>$affective_score        ])->one();        //จิตวิสัย        $aff = '';        if($models){            $percent = isset($models['percent'])?$models['percent']:0;            $aff = $percent/100; //จิตวิสัย            $total *= $aff; //คูนจิตพิสัย        }  //        //VarDumper::dump($total);        //$a = 2; //จำนวนคนขับ        //$b = 4; //จำนวนลูกน้อง        //$dk = 30; //ลูกน้อง 30%        if($dk==0 || $a == 0){            $rdk = 0;        }else{            $rdk = $dk/$a; //30/2 = 15% //ลูกน้องแต่ละคนจะได้        }        if($rdk == 0 && $b == 0 && $a == 0){            $rdp = 0;        }else{            $rdp = (100-$rdk*$b)/$a; // (100-15*4)/2 = 20% คนขับแต่ละคนจะได้        }        $rdks = $rdk*$b;        $rdps = $rdp*$a;        $rdpTotal = ($rdp*$total)/100; //คนขับคนนึงจะได้        $rdkTotal = ($rdk*$total)/100; //ลูกน้องคนนึงจะได้        $rdpTotals = number_format($rdpTotal, 2);        $rdkTotals = number_format($rdkTotal, 2);        $rdkss = number_format($rdks, 2);        $rdpss = number_format($rdps, 2);        $rdks = number_format($rdk, 2);        $rdps = number_format($rdp, 2);        //คนขับ จะได้คนละ 20%(64 บาท)  มี 2 คน รวมกันด้ 40%(128 บาท)        //ลูกน้องจะได้คนละ 15%(48 บาท) มี 4 คน รวมกันได้ 60% (192 บาท)        $totalRDP = $rdpTotal*$a;        $totalrdkTotal = $rdkTotal*$b;        $msgRdp = "คนขับ จะได้คนละ {$rdps}%({$rdpTotals} บาท)  มี {$a} คน รวมกันได้ {$rdpss}%(". number_format($totalRDP, 2)." บาท)";        $msgRdk = "ลูกน้องจะได้คนละ {$rdks}%({$rdkTotals} บาท) มี {$b} คน รวมกันได้ {$rdkss}% (". number_format($totalrdkTotal, 2)." บาท)";        $drivers = [];        $totalMoney = 0;        foreach($userShipping as $uk=>$uv){            $customer = \backend\models\Customers::findOne($uv['user_id']);            if($uv['parent_id'] == null){                //คนขับ                $drivers[] = [                    'bill_id'=>$bill_id,                    'user_id'=>$uv['user_id'],                    'driver'=>$customer['name'], 'status'=>1,'price'=>$rdpTotals,'position'=>'คนขับ',                    'output'=>[                        'difficulty'=>$difPrice,                        'difficultyName'=>$difficulty['name'],                        'aff'=>$aff,                        'percentAffectiveSum'=>$percentAffectiveSum,                        'driver'=>$msgRdp,                        'customer'=>$msgRdk,                        'totalMoney'=>$totalMoney                    ]                ];            }else{                $drivers[] = [                    'bill_id'=>$bill_id,                    'driver'=>$customer['name'], 'status'=>2,'price'=>$rdkTotals,'position'=>'ลูกน้อง',                    'output'=>[                        'difficulty'=>$difPrice,                        'difficultyName'=>$difficulty['name'],                        'aff'=>$aff,                        'percentAffectiveSum'=>$percentAffectiveSum,                        'driver'=>$msgRdp,                        'customer'=>$msgRdk,                        'totalMoney'=>$totalMoney                    ]                ];            }        }        foreach($drivers as $k=>$p){            $totalMoney += $p['price'];        }        //VarDumper::dump($drivers);        return $drivers;    }}