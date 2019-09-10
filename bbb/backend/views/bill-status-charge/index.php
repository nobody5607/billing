<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\BillStatusCharge */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bill Status Charges');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box box-primary">
    <div class="box-header">
         <i class="fa fa-table"></i> <?=  Html::encode($this->title) ?> 
         <div class="pull-right">
             <?= Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['bill-status-charge/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-bill-status-charge']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['bill-status-charge/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-bill-status-charge', 'disabled'=>true]) 
             ?>
         </div>
    </div>
<div class="box-body">    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  Pjax::begin(['id'=>'bill-status-charge-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'bill-status-charge-grid',
/*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['bill-status-charge/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-bill-status-charge']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['bill-status-charge/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-bill-status-charge', 'disabled'=>true]),*/
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
        'columns' => [
	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:150px;text-align: center;'],
		'template' => '{view} {update} {delete}',
                'buttons'=>[
                    'view'=>function($url, $model){
                        return Html::a('<span class="fa fa-eye"></span> ', 
                                    yii\helpers\Url::to(['view?id='.$model->id]), [
                                    'title' => Yii::t('chanpan', 'View'),
                                    'class' => 'btn btn-default btn-xs',
                                    'data-action'=>'view',
                                    'data-pjax'=>0
                        ]);
                    },
                    'update'=>function($url, $model){
                        return Html::a('<span class="fa fa-pencil"></span> ', 
                                    yii\helpers\Url::to(['update?id='.$model->id]), [
                                    'title' => Yii::t('chanpan', 'Edit'),
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    },
                    'delete' => function ($url, $model) {                         
                        return Html::a('<span class="fa fa-trash"></span> ', 
                                yii\helpers\Url::to(['delete?id='.$model->id]), [
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
		'class' => 'yii\grid\CheckboxColumn',
		'checkboxOptions' => [
		    'class' => 'selectionBillStatusChargeIds'
		],
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:40px;text-align: center;'],
	    ],
	    [
		'class' => 'yii\grid\SerialColumn',
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:60px;text-align: center;'],
	    ],

            'id',
            'name',
            'rstat',
            'create_by',
            'create_date',
            // 'update_by',
            // 'update_date',

	    
        ],
    ]); ?>
    <?php  Pjax::end();?>

</div>
</div>
<?=  ModalForm::widget([
    'id' => 'modal-bill-status-charge',
    'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('#modal-addbtn-bill-status-charge').on('click', function() {
    modalBillStatusCharge($(this).attr('data-url'));
});

$('#modal-delbtn-bill-status-charge').on('click', function() {
    selectionBillStatusChargeGrid($(this).attr('data-url'));
});

$('#bill-status-charge-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#bill-status-charge-grid').yiiGridView('getSelectedRows');
	disabledBillStatusChargeBtn(key.length);
    },100);
});

$('.selectionCoreOptionIds').on('click',function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledBillStatusChargeBtn(key.length);
});

$('#bill-status-charge-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalBillStatusCharge('<?= Url::to(['bill-status-charge/update', 'id'=>''])?>'+id);
});	

$('#bill-status-charge-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalBillStatusCharge(url);
    } else if(action === 'delete') {
	yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#bill-status-charge-grid-pjax'});
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

function disabledBillStatusChargeBtn(num) {
    if(num>0) {
	$('#modal-delbtn-bill-status-charge').attr('disabled', false);
    } else {
	$('#modal-delbtn-bill-status-charge').attr('disabled', true);
    }
}

function selectionBillStatusChargeGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionBillStatusChargeIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#bill-status-charge-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalBillStatusCharge(url) {
    $('#modal-bill-status-charge .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-bill-status-charge').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>