<?php    $this->title = 'รายงานบิล';use appxq\sdii\helpers\SDHtml;use appxq\sdii\helpers\SDNoty;use appxq\sdii\widgets\GridView;use appxq\sdii\widgets\ModalForm;use backend\models\BillType;use kartik\date\DatePicker;use kartik\select2\Select2;use yii\helpers\Html;use yii\helpers\Url;use yii\widgets\Pjax; ?><div>     <?= $this->render("_search2");?></div><div id="content" style="background: #fff;padding:10px;border-radius: 5px;">    <div>        <h3>จำนวนบิลทั้งหมด <b><?= $count; ?></b> รายการ</h3>    </div>    <?php Pjax::begin(['id' => 'bill-items-grid-pjax']); ?>        <?= \yii\grid\GridView::widget([                'id' => 'bill-items-grid',                'dataProvider' => $dataProvider,                'layout'=> "{summary}\n{items}\n{pager}",                'columns' => [                    [                        'class' => 'yii\grid\SerialColumn',                        'headerOptions' => ['style' => 'text-align: center;'],                        'contentOptions' => ['style' => 'width:60px;text-align: center;'],                    ],                    [                        'format' => 'raw',                        'attribute' => 'bill_date',                        'value' => function ($model) {                            if (isset($model->bill_date) && $model->bill_date != '') {                                return \appxq\sdii\utils\SDdate::mysql2phpDate($model->bill_date);                            }                        },                    ],                    'billno',                    'billref',                    [                        'contentOptions' => ['style'=>'width:100px'],                        'label' => 'ชื่อลูกค้า',                        'value' => function($model){                            $billType = BillType::find()->where('id=:bill_type',[                                    ':bill_type' => $model->bill_type                            ])->one();                            $bill_type =  isset($billType->name)?$billType->name:'';                            $billref = isset($model->billref)?$model->billref:'';                            $idbill = "{$bill_type}{$billref}";                            $sellBill = \backend\models\SellBill::find()->where('docno=:docno',[                                    ':docno' => $idbill                            ])->one();                            $customername = isset($sellBill->customername)?$sellBill->customername:'-';                            $customerno = isset($sellBill->customerno)?"({$sellBill->customerno})":'';                            $name = "{$customerno} {$customername}";                            return $name;                        }                    ],                    [                        'format' => 'raw',                        'attribute' => 'bill_type',                        'value' => function ($model) {                            $url = \yii\helpers\Url::to(['/select2/bill-type?type=1']);                            $data = isset($model->bill_type) ? backend\models\BillType::findOne($model->bill_type) : '';                            return isset($data['name']) ? $data['name'] : 'ไม่ได้ตั้ง';                        },                    ],                    [                        'format' => 'raw',                        'attribute' => 'status',                        'value' => function ($model) {                            if ($model->status) {                                return isset($model->statuss->name) ? $model->statuss->name : '';                            }                        },                    ],                    [                        'format' => 'raw',                        'attribute' => 'shiping',                        'value' => function ($model) {                            return isset($model->shippings->name) ? $model->shippings->name : 'ยังไม่จัดสินค้า';                        },                    ],                    [                        'format' => 'raw',                        'attribute' => 'charge',                        'value' => function ($model) {                            return isset($model->charge) ? $model->charges->name : '';                        },                    ],                    [                        'contentOptions' =>['style'=>'text-align:right'],                        'attribute'=>'amount',                        'value'=>function($model){                            return isset($model->amount)?$model->amount:0;                        }                    ],                    [                        'class' => 'appxq\sdii\widgets\ActionColumn',                        'contentOptions' => ['style' => 'width:150px;text-align: center;'],        //                                'template' => '{update-status} {update} {delete}',                        'template' => '{update}',                        'buttons' => [                            'update' => function ($url, $model) {                                return Html::a('<span class="fa fa-eye"></span> ' . Yii::t('app', "ดูรายละเอียด"), yii\helpers\Url::to(["bill-items/update?id={$model->id}&view=1"]), [                                    'title' => Yii::t('app', 'ดูรายละเอียด'),                                    'class' => '',                                    'data-action' => 'update',                                    'data-pjax' => 0                                ]);                            },                        ]                    ],                    // 'remark',                ],            ]);        ?>    <?php Pjax::end(); ?></div><?=    ModalForm::widget([        'id' => 'modal-bill-items',        'options' => ['tabindex' => false],        'size' => 'modal-lg',    //         'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]    ]);?><?php \richardfan\widget\JSRegister::begin()?><script>    $("#form-search").on("submit", function (e) {        e.preventDefault();        let data = $(this).serialize();        let url = '<?= \yii\helpers\Url::to(['/report/index?'])?>'+data;        location.href = url;    });    $('#bill-items-grid-pjax').on('click', 'tbody tr td a', function () {        var url = $(this).attr('href');        var action = $(this).attr('data-action');        if (action === 'view' || action === 'update') {            modalBillItem(url);        } else if (action === 'delete') {            yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?') ?>', function () {                $.post(                    url                ).done(function (result) {                    if (result.status == 'success') {                        <?= SDNoty::show('result.message', 'result.status') ?>                        $.pjax.reload({container: '#bill-items-grid-pjax'});                    } else {                        <?= SDNoty::show('result.message', 'result.status') ?>                    }                }).fail(function () {                    <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"') ?>                    console.log('server error');                });            });        }        return false;    });    function modalBillItem(url) {        $('.modal').css('overflow', 'scroll');        $('#modal-bill-items .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');        $('#modal-bill-items').modal('show')            .find('.modal-content')            .load(url);    }</script><?php \richardfan\widget\JSRegister::end()?>