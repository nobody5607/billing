<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\BillPackagers */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'จัดสินค้า').' #'.$bill_id;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <br>
    <div>
<div class="col-md-12">
    <?= \backend\classes\BillManager::renderBillDetail()?>

        <div class="panel panel-primary">
            <div class="panel-heading"><?=  "<label>จัดสินค้า</label>";?></div>
            <div class="panel-body">
                <?php
                    $bill = \backend\models\BillItems::findOne($bill_id);
                    $shiping = isset($bill->shiping) ? $bill->shiping : null;
                    if(\Yii::$app->user->can('packager')) {

                        if ($shiping == '9') {
                            echo "<label class='label label-success'><i class='fa fa-check'></i> ยืนยันจัดส่งสินค้า</label>";
                        } else if ($shiping == '3') {
                            echo "<label class='label label-success'><i class='fa fa-check'></i> ส่งสินค้าแล้ว</label>";
                        } else {
                            $items = \yii\helpers\ArrayHelper::map(\backend\models\BillStatusShipping::find()->where('rstat not in(0,3) AND id in(1,2)')->all(), 'id', 'name');
                            echo Html::radioList('package', $shiping, $items, ['id' => 'radio-package']);

                        }
                    }else{
                        $shipping = \backend\models\BillStatusShipping::find()->where('rstat not in(0,3) AND id=:id',[
                          ':id'=>$shiping
                        ])->one();
                        if($shipping){
                            echo isset($shipping->name)?$shipping->name:'';
                        }
                    }
                ?>
                <?php \richardfan\widget\JSRegister::begin();?>
                    <script>
                        $(':radio[name="package"]').change(function() {
                            let shiping = $(this).filter(':checked').val();
                            let bill_id = '<?= $bill_id?>';
                            let status = 'package';
                            let url = '<?= Url::to(['/bill-items/update-shipping'])?>';
                            $.post(url,{shiping:shiping,bill_id:bill_id,status:status},function (result) {
                                <?= SDNoty::show('result.message', 'result.status')?>
                            })

                            return false;
                        });
                    </script>
                <?php \richardfan\widget\JSRegister::end();?>
            </div>
        </div>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-9 col-xs-9">
                <label>จัดสินค้า</label>
            </div>
            <div class="col-md-3 col-xs-3 text-right">
                <?php if(\Yii::$app->user->can('packager')):?>
                    <?= Html::button('เพิ่มรายการ '.SDHtml::getBtnAdd(), ['data-url'=>Url::to(['bill-packagers/create?bill_id='.$bill_id]), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-bill-packagers'])
                    ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php  Pjax::begin(['id'=>'bill-packagers-grid-pjax']);?>
        <?= GridView::widget([
            'id' => 'bill-packagers-grid',
            /*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['bill-packagers/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-bill-packagers']). ' ' .
                          Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['bill-packagers/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-bill-packagers', 'disabled'=>true]),*/
            'dataProvider' => $dataProvider,
            'columns' => [

                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['style'=>'text-align: center;'],
                    'contentOptions' => ['style'=>'width:60px;text-align: center;'],
                ],
                [
                    'class' => 'appxq\sdii\widgets\ActionColumn',
                    'contentOptions' => ['style'=>'width:180px;text-align: center;'],
                    'template' => ' {delete}',
                    'buttons'=>[
                        'update'=>function($url, $model){
                            return Html::a('<span class="fa fa-edit"></span> '.Yii::t('chanpan', 'Edit'),
                                yii\helpers\Url::to(['update?id='.$model->id]), [
                                    'title' => Yii::t('chanpan', 'Edit'),
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                                ]);
                        },
                        'delete' => function ($url, $model) {
                            if(\Yii::$app->user->can('packager')) {
                                return Html::a('<span class="fa fa-trash"></span> ' . Yii::t('chanpan', 'Delete'),
                                    yii\helpers\Url::to(['delete?id=' . $model->id]), [
                                        'title' => Yii::t('chanpan', 'Delete'),
                                        'class' => 'btn btn-danger btn-xs',
                                        'data-confirm' => Yii::t('chanpan', 'Are you sure you want to delete this item?'),
                                        'data-method' => 'post',
                                        'data-action' => 'delete',
                                        'data-pjax' => 0,
                                        'bill_id' => $model->bill_id
                                    ]);
                            }
                            return '';


                        },
                    ]
                ],

                //'bill_id',
                [
                    'attribute'=>'user_id',
                    'value'=>function($model){
                        //return $model->user_id;
                        return isset($model->profiles->name)?$model->profiles->name:'';
                    }
                ],
                //'file_upload',
                //'remark',
            ],
        ]);
        ?>
        <?php  Pjax::end();?>

    </div>
</div>
</div>
<?=  ModalForm::widget([
    'id' => 'modal-bill-packagers',
    //'size'=>'modal-lg',
]);
?>
</div></div>
<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('#modal-addbtn-bill-packagers').on('click', function() {
    modalBillPackager($(this).attr('data-url'));
});

$('#modal-delbtn-bill-packagers').on('click', function() {
    selectionBillPackagerGrid($(this).attr('data-url'));
});

$('#bill-packagers-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#bill-packagers-grid').yiiGridView('getSelectedRows');
	disabledBillPackagerBtn(key.length);
    },100);
});

$('.selectionCoreOptionIds').on('click',function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledBillPackagerBtn(key.length);
});

//$('#bill-packagers-grid-pjax').on('dblclick', 'tbody tr', function() {
//    let id = $(this).attr('data-key');
//
//    //id = id['id'];
//
//    modalBillPackager('<?//= Url::to(['/bill-packagers/update', 'id'=>''])?>//'+id);
//});

$('#bill-packagers-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalBillPackager(url);
    } else if(action === 'delete') {
        let bill_id = $(this).attr('bill_id');
	yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
            if(result.status == 'success') {
                <?= SDNoty::show('result.message', 'result.status')?>
                initBillPackage(bill_id)

                //$.pjax.reload({container:'#bill-packagers-grid-pjax'});
            } else {
                <?= SDNoty::show('result.message', 'result.status')?>
            }
	    }).fail(function() {
            <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
            console.log('server error');
	    });
	});
    }
    return false;
});

function disabledBillPackagerBtn(num) {
    if(num>0) {
	$('#modal-delbtn-bill-packagers').attr('disabled', false);
    } else {
	$('#modal-delbtn-bill-packagers').attr('disabled', true);
    }
}

function selectionBillPackagerGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionBillPackagerIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#bill-packagers-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalBillPackager(url) {
    $('#modal-bill-packagers .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-bill-packagers').modal('show')
    .find('.modal-content')
    .load(url);
}


$('#bill-packagers-grid table thead tr th a').on('click', function () {
    let url = $(this).attr('href');
    $.get(url,function (result) {
        $('#data-bill-package').html(result);
    })

    return false;
})
function initBillPackage(bill_id){
    let url = "<?= \yii\helpers\Url::to(['bill-packagers/manage'])?>";
    $.get(url,{bill_id:bill_id}, function (result) {
        $('#data-bill-package').html(result);
    });
    return false;
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>