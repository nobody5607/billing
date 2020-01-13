<?php    $this->title = 'รายงานบิล';use appxq\sdii\helpers\SDHtml;use appxq\sdii\helpers\SDNoty;use appxq\sdii\widgets\GridView;use appxq\sdii\widgets\ModalForm;use backend\models\BillType;use kartik\date\DatePicker;use kartik\select2\Select2;use yii\helpers\Html;use yii\helpers\Url;use yii\web\JsExpression;use yii\widgets\Pjax; ?><div>     <?= $this->render("_search2");?></div><div id="content" style="background: #fff;padding:10px;border-radius: 5px;">    <div>        <h3>จำนวนบิลทั้งหมด <b><?= $count; ?></b> รายการ</h3>    </div>    <?php Pjax::begin(['id' => 'bill-items-grid-pjax']); ?>        <?php            $pdfFooter = [            'L' => [                'content' => Yii::t('kvgrid', '© Krajee Yii2 Extensions'),                'font-size' => 8,                'font-style' => 'B',                'color' => '#999999',            ],            'R' => [                'content' => '[ {PAGENO} ]',                'font-size' => 10,                'font-style' => 'B',                'font-family' => 'serif',                'color' => '#333333',            ],            'line' => true,        ];            $cssStyles = [            '.kv-group-even' => ['background-color' => '#f0f1ff'],            '.kv-group-odd' => ['background-color' => '#f9fcff'],            '.kv-grouped-row' => ['background-color' => '#fff0f5', 'font-size' => '1.3em', 'padding' => '10px'],            '.kv-table-caption' => [                'border' => '1px solid #ddd',                'border-bottom' => 'none',                'font-size' => '1.5em',                'padding' => '8px',            ],            '.kv-table-footer' => ['border-top' => '4px double #ddd', 'font-weight' => 'bold'],            '.kv-page-summary td' => [                'background-color' => '#ffeeba',                'border-top' => '4px double #ddd',                'font-weight' => 'bold',            ],            '.kv-align-center' => ['text-align' => 'center'],            '.kv-align-left' => ['text-align' => 'left'],            '.kv-align-right' => ['text-align' => 'right'],            '.kv-align-top' => ['vertical-align' => 'top'],            '.kv-align-bottom' => ['vertical-align' => 'bottom'],            '.kv-align-middle' => ['vertical-align' => 'middle'],            '.kv-editable-link' => [                'color' => '#428bca',                'text-decoration' => 'none',                'background' => 'none',                'border' => 'none',                'border-bottom' => '1px dashed',                'margin' => '0',                'padding' => '2px 1px',            ],        ];            $pdfHeader = [            'L' => [                'content' => Yii::t('kvgrid', 'Yii2 Grid Export (PDF)'),                'font-size' => 8,                'color' => '#333333',            ],            'C' => [                'content' => $title,                'font-size' => 16,                'color' => '#333333',            ],            'R' => [                'content' => Yii::t('kvgrid', 'Generated') . ': ' . date('D, d-M-Y'),                'font-size' => 8,                'color' => '#333333',            ],        ];        ?>        <?=  \kartik\grid\GridView::widget([                'id' => 'bill-items-grid',                'dataProvider' => $dataProvider,                'panel'=>[                    'before'=>'',                    'footer'=>false,                ],                'export'=>[                    'label' => 'ส่งออกรายงาน',                    'messages' => [                        'allowPopups' => Yii::t(                            'kvgrid',                            'ปิดการใช้งานตัวบล็อกป๊อปอัปในเบราว์เซอร์ของคุณเพื่อให้แน่ใจว่าการดาวน์โหลดที่เหมาะสม'                        ),                        'confirmDownload' => Yii::t('kvgrid', 'ตกลงเพื่อดำเนินการต่อ'),                        'downloadProgress' => Yii::t('kvgrid', 'กำลังสร้างไฟล์การส่งออก โปรดรอ...'),                        'downloadComplete' => Yii::t(                            'kvgrid',                            'ส่งคำขอแล้ว! คุณสามารถปิดกล่องโต้ตอบนี้ได้อย่างปลอดภัยหลังจากบันทึกไฟล์ที่ดาวน์โหลด'                        ),                    ],                    'options'=>['class'=>'btn btn-warning'],                ],                'exportConfig'=>[                    \kartik\grid\GridView::PDF=>[                        'label' => Yii::t('kvgrid', 'PDF'),                        'icon' => 'fa fa-file-pdf-o',                        'iconOptions' => ['class' => 'text-danger'],                        'showHeader' => false,                        'showPageSummary' => true,                        'showFooter' => false,                        'showCaption' => true,                        'filename' => Yii::t('kvgrid', 'grid-export'),                        'alertMsg' => Yii::t('kvgrid', 'ไฟล์การส่งออก PDF จะถูกสร้างขึ้นสำหรับการดาวน์โหลด'),                        'options' => ['title' => Yii::t('kvgrid', 'รูปแบบเอกสารพกพา')],                        'mime' => 'application/pdf',                        'cssStyles' => $cssStyles,                        'config' => [                            'mode' => 'UTF-8',                            'format' => 'A4-L',                            'destination' => 'D',                            'marginTop' => 20,                            'marginBottom' => 20,                            'cssInline' => 'body{font-family: "Garuda" !important;}.kv-wrap{padding:20px}',                            'methods' => [                                'SetHeader' => [$pdfHeader,'even' => $pdfHeader],                                'SetFooter' => [                                    ['odd' => $pdfFooter, 'even' => $pdfFooter],                                ],                            ],                            'options' => [                                'title' => $title,                                'subject' => Yii::t('kvgrid', ''),                                'keywords' => Yii::t('kvgrid', ''),                            ],                            'contentBefore' => '',                            'contentAfter' => '',                        ],                    ],                   \kartik\grid\GridView::EXCEL=>[                            'label' => 'Excel',                            'icon' => 'fa fa-file-excel-o',                            'iconOptions' => ['class' => 'text-success'],                            'showHeader' => true,                            'showPageSummary' => true,                            'showFooter' => false,                            'showCaption' => true,                            'filename' => 'Report bill '.date('Y-m-d H:i:s'),                            'alertMsg' => Yii::t('kvgrid', 'ไฟล์ส่งออก EXCEL จะถูกสร้างขึ้นสำหรับการดาวน์โหลด'),                            'options' => ['title' => Yii::t('kvgrid', 'Microsoft Excel 95 ขึ้นไป')],                            'mime' => 'application/vnd.ms-excel',                            'config' => [                                'worksheet' => Yii::t('kvgrid', 'ExportWorksheet'),                                'cssFile' => '',                            ],                        ],                    ],                'layout'=> "{summary}\n{items}\n{pager}",                'columns' => [                    [                        'class' => 'yii\grid\SerialColumn',                        'headerOptions' => ['style' => 'text-align: center;'],                        'contentOptions' => ['style' => 'width:60px;text-align: center;'],                    ],                    [                        'format' => 'raw',                        'attribute' => 'bill_date',                        'value' => function ($model) {                            if (isset($model->bill_date) && $model->bill_date != '') {                                return \appxq\sdii\utils\SDdate::mysql2phpDate($model->bill_date);                            }                        },                    ],                    'billno',                    'billref',                    [                        'contentOptions' => ['style'=>'width:100px'],                        'label' => 'ชื่อลูกค้า',                        'value' => function($model){                                $billType = BillType::find()->where('id=:bill_type',[                                    ':bill_type' => $model->bill_type                                ])->one();                                $bill_type =  isset($billType->name)?$billType->name:'';                                $billref = isset($model->billref)?$model->billref:'';                                $idbill = "{$bill_type}{$billref}";                                $sellBill = \backend\models\SellBill::find()->where('docno=:docno',[                                    ':docno' => $idbill                                ])->one();                                $customername = isset($sellBill->customername)?$sellBill->customername:'-';                                $customerno = isset($sellBill->customerno)?"({$sellBill->customerno})":'';                                $name = "{$customerno} {$customername}";                                return $name;                        }                    ],                    [                        'format' => 'raw',                        'attribute' => 'bill_type',                        'value' => function ($model) {                            if(!$model->bill_type){                                return '';                            }                            $url = \yii\helpers\Url::to(['/select2/bill-type?type=1']);                            $data = isset($model->bill_type) ? backend\models\BillType::findOne($model->bill_type) : '';                            return isset($data['name']) ? $data['name'] : 'ไม่ได้ตั้ง';                        },                    ],                    [                        'format' => 'raw',                        'attribute' => 'status',                        'value' => function ($model) {                            if ($model->status) {                                return isset($model->statuss->name) ? $model->statuss->name : '';                            }                        },                    ],                    [                        'format' => 'raw',                        'attribute' => 'shiping',                        'value' => function ($model) {                            return isset($model->shippings->name) ? $model->shippings->name : 'ยังไม่จัดสินค้า';                        },                    ],                    [                        'format' => 'raw',                        'attribute' => 'charge',                        'value' => function ($model) {                            return isset($model->charge) ? $model->charges->name : '';                        },                    ],                    [                        'contentOptions' =>['style'=>'text-align:right'],                        'attribute'=>'amount',                        'value'=>function($model){                            return isset($model->amount)?$model->amount:0;                        }                    ],                    [                        'class' => 'appxq\sdii\widgets\ActionColumn',                        'contentOptions' => ['style' => 'width:150px;text-align: center;'],        //                                'template' => '{update-status} {update} {delete}',                        'template' => '{update}',                        'buttons' => [                            'update' => function ($url, $model) {                                return Html::a('<span class="fa fa-eye"></span> ' . Yii::t('app', "ดูรายละเอียด"), yii\helpers\Url::to(["bill-items/update?id={$model->id}&view=1"]), [                                    'title' => Yii::t('app', 'ดูรายละเอียด'),                                    'class' => '',                                    'data-action' => 'update',                                    'data-pjax' => 0                                ]);                            },                        ]                    ],                    // 'remark',                ],            ]);        ?>    <?php Pjax::end(); ?></div><?=    ModalForm::widget([        'id' => 'modal-bill-items',        'options' => ['tabindex' => false],        'size' => 'modal-lg',    //         'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]    ]);?><?php \richardfan\widget\JSRegister::begin()?><script>    $("#bill-items-grid-togdata-page").remove();    $("#form-search").on("submit", function (e) {        e.preventDefault();        let data = $(this).serialize();        let url = '<?= \yii\helpers\Url::to(['/report/index?'])?>'+data;        location.href = url;    });    $('#bill-items-grid-pjax').on('click', 'tbody tr td a', function () {        var url = $(this).attr('href');        var action = $(this).attr('data-action');        if (action === 'view' || action === 'update') {            modalBillItem(url);        } else if (action === 'delete') {            yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?') ?>', function () {                $.post(                    url                ).done(function (result) {                    if (result.status == 'success') {                        <?= SDNoty::show('result.message', 'result.status') ?>                        $.pjax.reload({container: '#bill-items-grid-pjax'});                    } else {                        <?= SDNoty::show('result.message', 'result.status') ?>                    }                }).fail(function () {                    <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"') ?>                    console.log('server error');                });            });        }        return false;    });    function modalBillItem(url) {        $('.modal').css('overflow', 'scroll');        $('#modal-bill-items .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');        $('#modal-bill-items').modal('show')            .find('.modal-content')            .load(url);    }</script><?php \richardfan\widget\JSRegister::end()?>