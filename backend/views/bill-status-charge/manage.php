<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\BillShippings */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bill Shippings');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-md-2 col-xs-2">
        <?= $this->render('../site/_menu'); ?>
    </div>
    <div class="col-md-10 col-xs-10">
<div class="box box-primary">
    <div class="box-header">
         <i class="fa fa-table"></i> <?=  Html::encode($this->title) ?> 
         <div class="pull-right">
             <?=  Html::a('ย้อนกลับ <i class="fa fa-arrow-left" aria-hidden="true"></i> ',['/bill-shippings/'], ['class'=>'btn btn-default btn-sm']);?>
             <?= Html::button('เพิ่มรายการ '.SDHtml::getBtnAdd(), ['data-url'=>Url::to(['bill-shippings/create?bill_id='.$bill_id]), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-bill-shippings'])
             ?>
         </div>
    </div>
<div class="box-body">    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  Pjax::begin(['id'=>'bill-shippings-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'bill-shippings-grid',
/*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['bill-shippings/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-bill-shippings']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['bill-shippings/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-bill-shippings', 'disabled'=>true]),*/
	'dataProvider' => $dataProvider,
	//'filterModel' => $searchModel,
        'columns' => [
	    
	    [
		'class' => 'yii\grid\SerialColumn',
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:60px;text-align: center;'],
	    ],
            [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:180px;text-align: center;'],
		'template' => ' {update} {delete}',
                'buttons'=>[
                    'update'=>function($url, $model){
                        return Html::a('<span class="fa fa-edit"></span> '.Yii::t('chanpan', 'Edit'), 
                                    yii\helpers\Url::to(['bill-shippings/update?id='.$model->bill_id]), [
                                    'title' => Yii::t('chanpan', 'Edit'),
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    },
                    'delete' => function ($url, $model) {                         
                        return Html::a('<span class="fa fa-trash"></span> '.Yii::t('chanpan', 'Delete'), 
                                yii\helpers\Url::to(['bill-shippings/delete?id='.$model->bill_id]), [
                                'title' => Yii::t('chanpan', 'Delete'),
                                'class' => 'btn btn-danger btn-xs',
                                'data-confirm' => Yii::t('chanpan', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'data-action' => 'delete',
                                'data-pjax'=>0
                        ]);
                            
                        
                    },
                ]
	    ],
            [
                'format'=>'raw',
                //'attribute'=>'bill_upload',
                'value'=>function($model){
                    $storageUrl = \Yii::getAlias('@storageUrl');
                    $url = "{$storageUrl}/uploads/{$model->file_upload}";
                    $img = Html::img($url, ['style'=>'width:50px;']);
                    return "<a href='{$url}' target='_BLANK' class='showImage'>{$img}</a>";
                }
            ],
            'bill_id',
            [
                'attribute'=>'user_id',
                'value'=>function($model){
                    return isset($model->profiles->name)?$model->profiles->name:'';
                }
            ],  

            'file_upload',
            //'remark',

        ],
    ]); ?>
    <?php  Pjax::end();?>

</div>
</div>
<?=  ModalForm::widget([
    'id' => 'modal-bill-shippings',
    'options'=>['tabindex' => false],
    //'size'=>'modal-lg',
]);
?>
</div></div>
<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
$(".showImage").on('click', function(){
let url = $(this).attr('href');
window.open(url, '_BLANK');
return false;
});  
// JS script
$('#modal-addbtn-bill-shippings').on('click', function() {
    modalBillShipping($(this).attr('data-url'));
});

$('#modal-delbtn-bill-shippings').on('click', function() {
    selectionBillShippingGrid($(this).attr('data-url'));
});

$('#bill-shippings-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#bill-shippings-grid').yiiGridView('getSelectedRows');
	disabledBillShippingBtn(key.length);
    },100);
});

$('.selectionCoreOptionIds').on('click',function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledBillShippingBtn(key.length);
});

$('#bill-shippings-grid-pjax').on('dblclick', 'tbody tr', function() {
    let data = $(this).attr('data-key');
    let dataid = JSON.parse(data);
    let id = dataid['bill_id'];
    modalBillShipping('<?= Url::to(['bill-shippings/update', 'id'=>''])?>'+id);
});	

$('#bill-shippings-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalBillShipping(url);
    } else if(action === 'delete') {
	yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#bill-shippings-grid-pjax'});
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

function disabledBillShippingBtn(num) {
    if(num>0) {
	$('#modal-delbtn-bill-shippings').attr('disabled', false);
    } else {
	$('#modal-delbtn-bill-shippings').attr('disabled', true);
    }
}

function selectionBillShippingGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionBillShippingIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#bill-shippings-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalBillShipping(url) {
    $('#modal-bill-shippings .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-bill-shippings').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>