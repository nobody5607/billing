<div class="alert alert-default" style="background: white;border: 1px solid #dee9f7;">    <div class="row">        <div class="col-md-4 col-sm-4 col-xs-4">            <?php            use kartik\date\DatePicker;            echo '<label class="control-label">วันที่เริ่มต้น</label>';            echo DatePicker::widget([                'name' => 'stdate',                'type' => DatePicker::TYPE_COMPONENT_PREPEND,                //'value' => date('d-m-Y'),//Y-m-d                'options' => ['id'=>'stdate'],                'pluginOptions' => [                    'autoclose'=>true,                    'format' => 'dd-mm-yyyy'//'yyyy-mm-dd'                ]            ]);            ?>        </div>        <div class="col-md-4 col-sm-4 col-xs-4">            <?php            echo '<label class="control-label">ถึงวันที่</label>';            echo DatePicker::widget([                'name' => 'endate',                'type' => DatePicker::TYPE_COMPONENT_PREPEND,                //'value' => date('d-m-Y'),//Y-m-d                'options' => ['id'=>'endate'],                'pluginOptions' => [                    'autoclose'=>true,                    'format' => 'dd-mm-yyyy'//'yyyy-mm-dd'                ]            ]);            ?>        </div>        <div class="col-md-4 col-sm-4 col-xs-4">            <label>ค้นหา</label>            <div>                <button class="btn btn-primary" id="btnProcess">ค้นหา</button>            </div>        </div>    </div></div>