<form  id="form-search">    <div class="alert alert-default" style="background: white;border: 1px solid #dee9f7;border-radius: 5px;">        <div class="row">            <div class="col-md-4 col-xs-6">                <?php                use kartik\date\DatePicker;                echo '<label class="control-label">วันที่เริ่มต้น</label>';                echo DatePicker::widget([                    'name' => 'stdate',                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,                    'value' => date('d-m-Y'),//Y-m-d                    'options' => ['id' => 'stdate'],                    'pluginOptions' => [                        'autoclose' => true,                        'format' => 'dd-mm-yyyy'//'yyyy-mm-dd'                    ]                ]);                ?>            </div>            <div class="col-md-4 col-xs-6">                <?php                echo '<label class="control-label">ถึงวันที่</label>';                echo DatePicker::widget([                    'name' => 'endate',                    'type' => DatePicker::TYPE_COMPONENT_APPEND,                    'value' => date('d-m-Y'),//Y-m-d                    'options' => ['id' => 'endate'],                    'pluginOptions' => [                        //'orientation' => 'top right',                        'autoclose' => true,                        'format' => 'dd-mm-yyyy'//'yyyy-mm-dd'                    ]                ]);                ?>            </div>            <div class="col-md-4 col-xs-6" >                <label>ประเภทบิล</label>                <?php                    $bill_type_value = Yii::$app->request->get('bill_type');                    $bill_type = \backend\models\BillType::find()->where('type=1 AND rstat not in(0,3)')->all();                    $items = \yii\helpers\ArrayHelper::map($bill_type,'id','name');                    echo \yii\bootstrap\Html::dropDownList('bill_type',$bill_type_value,$items,[                        'class'=>'form-control',                        'prompt'=>'--เลือกสถานะบิล--'                    ]);                ?>            </div>        </div>        <div class="row" style="margin-top:20px">            <div class="col-md-4 col-xs-6" >                <label>สถานะการใช้งานบิล</label>                <?php                    $rstat_value = Yii::$app->request->get('rstat');                    $items = [1=>'เปิดการใช้งานบิล',0=>'ปิดการใช้งานบิล','2'=>'ไม่สามารถแก้ไขบิลได้'];;                    echo \yii\bootstrap\Html::dropDownList('rstat',$rstat_value,$items,[                        'class'=>'form-control',                        'prompt'=>'--เลือกสถานะบิล--'                    ]);                ?>            </div>            <div class="col-md-4 col-xs-6" >                <label>สถานะบิล</label>                <?php                    $bill_status_value = Yii::$app->request->get('bill_status');                    $bill_type = \backend\models\BillStatus::find()->where('rstat not in(0,3)')->all();                    $items = \yii\helpers\ArrayHelper::map($bill_type,'id','name');                    echo \yii\bootstrap\Html::dropDownList('bill_status',$bill_status_value,$items,[                        'class'=>'form-control',                        'prompt'=>'--เลือกสถานะบิล--'                    ]);                ?>            </div>            <div class="col-md-4 col-xs-6" >                <label>สถานะเก็บเงิน</label>                <?php                    $bill_status_value = Yii::$app->request->get('charge');                    $bill_type = \backend\models\BillStatus::find()->where('rstat not in(0,3)')->all();                    $items = \yii\helpers\ArrayHelper::map(\backend\models\BillStatusCharge::find()->where('rstat not in(0,3)')->all(), 'id', 'name');                echo \yii\bootstrap\Html::dropDownList('charge',$bill_status_value,$items,[                    'class'=>'form-control',                    'prompt'=>'--เลือกสถานะเก็บเงิน--'                ]);                ?>            </div>        </div>        <div class="row">            <div class="col-md-12" style="margin-top:25px;">                <button class="btn btn-primary" id="btnProcess">ค้นหา</button>            </div>        </div>    </div></form>