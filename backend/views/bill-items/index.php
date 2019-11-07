<?php

use backend\models\BillType;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\BillItems */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('bill', 'Bill Manager');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="tab-content">
    <div class="row">
        <div class="col-md-12" id="navbars">
            <div class="kt-section">

                <div class="kt-section__content kt-section__content--solid kt-border-success kt-bg-light">
                    <form id="fupForm" enctype="multipart/form-data">
                        <div class="statusMsg"></div>
                        <div class="row">
                            <div class="col-md-8">
                                <?= $this->render('_search'); ?>
                            </div>
                            <div class="col-md-4 text-right">
                                <?php if (\Yii::$app->user->can('billmanager')) : ?>
                                    <?= Html::button(Yii::t('bill', 'Create Bill') . ' ' . SDHtml::getBtnAdd(), ['data-url' => Url::to(['bill-items/create']), 'class' => 'btn btn-success btn-lg btn-outline-success', 'id' => 'modal-addbtn-bill-items'])
                                    ?>
                                <?php endif; ?>

                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <div class="col-md-12">
            <div style="background: #fff;margin:0 0 0 1px">
                <div class="box-header">
                    <div class="pull-right">

                    </div>
                </div>
                <div class="box-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
                    <?php Pjax::begin(['id' => 'bill-items-grid-pjax']); ?>
                    <?=
                    GridView::widget([
                        'id' => 'bill-items-grid',
                        /* 	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['bill-items/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-bill-items']). ' ' .
                          Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['bill-items/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-bill-items', 'disabled'=>true]), */
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'headerOptions' => ['style' => 'text-align: center;'],
                                'contentOptions' => ['style' => 'width:60px;text-align: center;'],
                            ],
                            [
                                'format' => 'raw',
                                'attribute' => 'bill_date',
                                'value' => function ($model) {
                                    if (isset($model->bill_date) && $model->bill_date != '') {
                                        return \appxq\sdii\utils\SDdate::mysql2phpDate($model->bill_date);
                                    }
                                },
                                'filter' => DatePicker::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'bill_date',
                                    'type' => DatePicker::TYPE_INPUT,
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'yyyy-mm-dd'
                                    ]
                                ])
                            ],
                            [
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $storageUrl = \Yii::getAlias('@storageUrl');
                                    $url = "{$storageUrl}/uploads/{$model->bill_upload}";
                                    $img = Html::img($url, ['style' => 'width:50px;']);
                                    return "<a href='{$url}' target='_BLANK' class='showImage'>{$img}</a>";
                                }
                            ],
                            'billno',
                            [
                                'format' => 'raw',
                                'attribute' => 'bill_type',
                                'value' => function ($model) {
                                    $url = \yii\helpers\Url::to(['/select2/bill-type?type=1']);
                                    $data = isset($model->bill_type) ? backend\models\BillType::findOne($model->bill_type) : '';
                                    return isset($data['name']) ? $data['name'] : 'ไม่ได้ตั้ง';
                                },
                                'filter' => \yii\helpers\ArrayHelper::map(BillType::find()->where('type=1')->asArray()->all(), 'id', 'name'),
                            ],
                            'billref',
                            'amount',
                            [
                                'format' => 'raw',
                                'attribute' => 'status',
                                'value' => function ($model) {
                                    if ($model->status) {
                                        return isset($model->statuss->name) ? $model->statuss->name : '';
                                    }
                                },
                                'filter' => kartik\select2\Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'status',
                                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\search\BillStatus::find()->where('rstat not in(0,3)')->all(), 'id', 'name'),
                                    //'theme' => kartik\select2\Select2::THEME_BOOTSTRAP,
                                    'hideSearch' => false,
                                    'options' => [
                                        'placeholder' => 'เลือกสถานะบิล',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ]),
                            ],
                            [
                                'format' => 'raw',
                                'attribute' => 'shiping',
                                'value' => function ($model) {
                                    return isset($model->shippings->name) ? $model->shippings->name : 'ยังไม่จัดสินค้า';
                                },
                                'filter' => kartik\select2\Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'shiping',
                                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\search\BillStatusShipping::find()->where('rstat not in(0,3)')->all(), 'id', 'name'),

                                    'hideSearch' => false,
                                    'options' => [
                                        'placeholder' => 'สถานะการส่งสินค้า',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ]),
                            ],
                            [
                                'format' => 'raw',
                                'attribute' => 'charge',
                                'value' => function ($model) {
                                    return isset($model->charge) ? $model->charges->name : '';
                                },
                                'filter' => kartik\select2\Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'charge',
                                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\search\BillStatusCharge::find()->where('rstat not in(0,3)')->all(), 'id', 'name'),
                                    //'theme' => kartik\select2\Select2::THEME_BOOTSTRAP,
                                    'hideSearch' => false,
                                    'options' => [
                                        'placeholder' => 'สถานะเก็บเงิน',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ]),
                            ],
//                            [
//                                'headerOptions' => ['style' => 'width:100px'],
//                                'format'=>'raw',
//                                'label'=>'พนักงานจัดสินค้า',
//                                'value'=>function($model){
//                                    $html = "";
//                                    $package = \backend\models\BillPackagers::find()->where(['bill_id'=>$model->id])->andWhere('rstat not in(0,3)')->all();
//                                    foreach($package as $k=>$v){
//                                      $name = isset($v->profiles->name)?$v->profiles->name:'';
//                                      $html .= "<a href='#' title='{$name}'><i id='{$v['id']}' class='fa fa-user'></i></a> ";
//                                    }
//                                    return $html;
//                                }
//                            ],
                            [
                                'class' => 'appxq\sdii\widgets\ActionColumn',
                                'contentOptions' => ['style' => 'width:160px;text-align: center;'],
                                'template' => ' {update} {delete}',
                                'buttons' => [
                                    'update' => function ($url, $model) {

                                        $message = '';
                                        if (Yii::$app->user->can('billmanager')) {
                                            $message = 'จัดการบิล';
                                        } else if (Yii::$app->user->can('packager')) {
                                            $message = 'จัดสินค้า';
                                        } else if (Yii::$app->user->can('shipping')) {
                                            $message = 'ส่งสินค้า';
                                        } else if (Yii::$app->user->can('chargers')) {
                                            $message = 'จัดการการเงิน';
                                        }
                                        return Html::a('<span class="fa fa-pencil"></span> ' . Yii::t('chanpan', $message), yii\helpers\Url::to(['bill-items/update?id=' . $model->id]), [
                                            'title' => Yii::t('chanpan', 'Edit'),
                                            'class' => 'btn btn-info btn-sm',
                                            'data-action' => 'update',
                                            'data-pjax' => 0
                                        ]);
                                    },
                                    'delete' => function ($url, $model) {
                                        if (Yii::$app->user->can('billmanager')) {
                                            return Html::a('<span class="fa fa-trash"></span> ' . Yii::t('chanpan', 'ลบ'), yii\helpers\Url::to(['bill-items/delete?id=' . $model->id]), [
                                                'title' => Yii::t('chanpan', 'Delete'),
                                                'class' => 'btn btn-danger btn-sm',
                                                'data-confirm' => Yii::t('chanpan', 'Are you sure you want to delete this item?'),
                                                'data-method' => 'post',
                                                'data-action' => 'delete',
                                                'data-pjax' => 0
                                            ]);
                                        }
                                        return '';

                                    },
                                ]
                            ],
                            // 'remark',
                        ],
                    ]);
                    ?>
                    <?php Pjax::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>


<?=
ModalForm::widget([
    'id' => 'modal-bill-items',
    'options' => ['tabindex' => false],
    'size' => 'modal-lg',
//         'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]
]);
?>

<?php
//ModalForm::widget([
//    'id' => 'modal-bill-items',
//    'options' => ['tabindex' => false],
//    //'size'=>'modal-lg',
//]);
?>
<?php
\richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]);
?>
<script>
    $(".hasDatepicker").addClass('form-control');
    window.onscroll = function () {
        myFunction()
    };
    var navbar = document.getElementById("navbars");
    var sticky = navbar.offsetTop;

    function myFunction() {
        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky")
        } else {
            navbar.classList.remove("sticky");
        }
    }


    $(".showImage").on('click', function () {
        let url = $(this).attr('href');
        window.open(url, '_BLANK');
        return false;
    });

    // JS script
    $('#modal-addbtn-bill-items').on('click', function () {
        modalBillItem($(this).attr('data-url'));
    });

    $('#modal-delbtn-bill-items').on('click', function () {
        selectionBillItemGrid($(this).attr('data-url'));
    });

    $('#bill-items-grid-pjax').on('click', '.select-on-check-all', function () {
        window.setTimeout(function () {
            var key = $('#bill-items-grid').yiiGridView('getSelectedRows');
            disabledBillItemBtn(key.length);
        }, 100);
    });

    $('.selectionCoreOptionIds').on('click', function () {
        var key = $('input:checked[class=\"' + $(this).attr('class') + '\"]');
        disabledBillItemBtn(key.length);
    });

    $('#bill-items-grid-pjax').on('dblclick', 'tbody tr', function () {
        var id = $(this).attr('data-key');
        modalBillItem('<?= Url::to(['bill-items/update', 'id' => '']) ?>' + id);
    });

    $('#bill-items-grid-pjax').on('click', 'tbody tr td a', function () {
        var url = $(this).attr('href');
        var action = $(this).attr('data-action');

        if (action === 'view' || action === 'update') {
            modalBillItem(url);
        } else if (action === 'delete') {
            yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?') ?>', function () {
                $.post(
                    url
                ).done(function (result) {
                    if (result.status == 'success') {
                        <?= SDNoty::show('result.message', 'result.status') ?>
                        $.pjax.reload({container: '#bill-items-grid-pjax'});
                    } else {
                        <?= SDNoty::show('result.message', 'result.status') ?>
                    }
                }).fail(function () {
                    <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"') ?>
                    console.log('server error');
                });
            });
        }
        return false;
    });

    function disabledBillItemBtn(num) {
        if (num > 0) {
            $('#modal-delbtn-bill-items').attr('disabled', false);
        } else {
            $('#modal-delbtn-bill-items').attr('disabled', true);
        }
    }

    function selectionBillItemGrid(url) {
        yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?') ?>', function () {
            $.ajax({
                method: 'POST',
                url: url,
                data: $('.selectionBillItemIds:checked[name=\"selection[]\"]').serialize(),
                dataType: 'JSON',
                success: function (result, textStatus) {
                    if (result.status == 'success') {
                        <?= SDNoty::show('result.message', 'result.status') ?>
                        $.pjax.reload({container: '#bill-items-grid-pjax'});
                    } else {
                        <?= SDNoty::show('result.message', 'result.status') ?>
                    }
                }
            });
        });
    }

    function modalBillItem(url) {
        $('.modal').css('overflow', 'scroll');
        $('#modal-bill-items .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
        $('#modal-bill-items').modal('show')
            .find('.modal-content')
            .load(url);
    }
</script>
<?php \richardfan\widget\JSRegister::end(); ?>

<?php \appxq\sdii\widgets\CSSRegister::begin() ?>
<style>
    .sticky {
        position: fixed;
        top: 50px;
        width: 100%;
        background: #ffffff;
        left: 0;
        /* bottom: 70px; */
        padding-left: 65px;
        padding-right: 17px;
        z-index: 1;
        border-bottom: 1px solid #e9ecef;
        box-shadow: -11px 3px 6px #e9ecef;
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end() ?>
