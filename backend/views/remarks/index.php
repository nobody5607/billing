<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\Remarks */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Remarks');
$this->params['breadcrumbs'][] = $this->title;

?>
    <div class="box box-primary">
        <div class="box-header">
            <i class=""></i> <?= Html::encode($this->title) ?>
            <div class="pull-right">
                <?= Html::button(SDHtml::getBtnAdd(), ['data-url' => Url::to(['remarks/create']), 'class' => 'btn btn-success btn-sm', 'id' => 'modal-addbtn-remarks']) . ' ' .
                Html::button(SDHtml::getBtnDelete(), ['data-url' => Url::to(['remarks/deletes']), 'class' => 'btn btn-danger btn-sm', 'id' => 'modal-delbtn-remarks', 'disabled' => false])
                ?>
            </div>
        </div>
        <div class="box-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?php Pjax::begin(['id' => 'remarks-grid-pjax']); ?>
            <?= GridView::widget([
                'id' => 'remarks-grid',
                /*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['remarks/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-remarks']). ' ' .
                              Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['remarks/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-remarks', 'disabled'=>true]),*/
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => [
                            'class' => 'selectionRemarkIds'
                        ],
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'contentOptions' => ['style' => 'width:40px;text-align: center;'],
                    ],
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'contentOptions' => ['style' => 'width:60px;text-align: center;'],
                    ],

                    'id',
                    'name',
                    'create_by',
                    'create_date',
                    'update_by',
                    // 'update_date',
                    // 'rstat',

                    [
                        'class' => 'appxq\sdii\widgets\ActionColumn',
                        'contentOptions' => ['style' => 'width:180px;text-align: center;'],
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a('<span class="fa fa-pencil"></span> ' . Yii::t('app', 'Update'),
                                    yii\helpers\Url::to(['remarks/update?id=' . $model->id]), [
                                        'title' => Yii::t('app', 'Update'),
                                        'class' => 'btn btn-primary btn-xs',
                                        'data-action' => 'update',
                                        'data-pjax' => 0
                                    ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="fa fa-trash"></span> ' . Yii::t('app', 'Delete'),
                                    yii\helpers\Url::to(['remarks/delete?id=' . $model->id]), [
                                        'title' => Yii::t('app', 'Delete'),
                                        'class' => 'btn btn-danger btn-xs',
                                        'data-confirm' => Yii::t('chanpan', 'Are you sure you want to delete this item?'),
                                        'data-method' => 'post',
                                        'data-action' => 'delete',
                                        'data-pjax' => 0
                                    ]);


                            },
                        ]
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>

        </div>
    </div>
<?= ModalForm::widget([
    'id' => 'modal-remarks',
    //'size'=>'modal-lg',
]);
?>

<?php \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
    <script>
        // JS script
        $('#modal-addbtn-remarks').on('click', function () {
            modalRemark($(this).attr('data-url'));
        });

        $('#modal-delbtn-remarks').on('click', function () {
            selectionRemarkGrid($(this).attr('data-url'));
        });

        $('#remarks-grid-pjax').on('click', '.select-on-check-all', function () {
            window.setTimeout(function () {
                var key = $('#remarks-grid').yiiGridView('getSelectedRows');
                disabledRemarkBtn(key.length);
            }, 100);
        });

        $('.selectionCoreOptionIds').on('click', function () {
            var key = $('input:checked[class=\"' + $(this).attr('class') + '\"]');
            disabledRemarkBtn(key.length);
        });

        $('#remarks-grid-pjax').on('dblclick', 'tbody tr', function () {
            var id = $(this).attr('data-key');
            modalRemark('<?= Url::to(['remarks/update', 'id' => ''])?>' + id);
        });

        $('#remarks-grid-pjax').on('click', 'tbody tr td a', function () {
            var url = $(this).attr('href');
            var action = $(this).attr('data-action');

            if (action === 'update' || action === 'view') {
                modalRemark(url);
            } else if (action === 'delete') {
                yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?')?>', function () {
                    $.post(
                        url
                    ).done(function (result) {
                        if (result.status == 'success') {
                            <?= SDNoty::show('result.message', 'result.status')?>
                            $.pjax.reload({container: '#remarks-grid-pjax'});
                        } else {
                            swal({
                                title: result.message,
                                text: result.message,
                                type: result.status,
                                timer: 2000
                            });
                        }
                    }).fail(function () {
                        <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
                        console.log('server error');
                    });
                });
            }
            return false;
        });

        function disabledRemarkBtn(num) {
            if (num > 0) {
                $('#modal-delbtn-remarks').attr('disabled', false);
            } else {
                $('#modal-delbtn-remarks').attr('disabled', true);
            }
        }

        function selectionRemarkGrid(url) {
            yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function () {
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: $('.selectionRemarkIds:checked[name=\"selection[]\"]').serialize(),
                    dataType: 'JSON',
                    success: function (result, textStatus) {
                        if (result.status == 'success') {
                            <?= SDNoty::show('result.message', 'result.status')?>
                            $.pjax.reload({container: '#remarks-grid-pjax'});
                        } else {
                            <?= SDNoty::show('result.message', 'result.status')?>
                        }
                    }
                });
            });
        }

        function modalRemark(url) {
            $('#modal-remarks .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
            $('#modal-remarks').modal('show')
                .find('.modal-content')
                .load(url);
        }
    </script>
<?php \richardfan\widget\JSRegister::end(); ?>