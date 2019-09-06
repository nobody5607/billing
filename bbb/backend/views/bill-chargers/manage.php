<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\BillChargers */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'เรียกเก็บเงิน');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
   <br>
<div class="col-md-12">
    <?= \backend\classes\BillManager::renderBillDetail()?>
<div>
    <div >
         <div>
             <?php if(\Yii::$app->user->can('chargers')) :?>
             <?= Html::button("เพิ่มรายการ ".SDHtml::getBtnAdd(), ['data-url'=>Url::to(['bill-chargers/create?bill_id='.$bill_id]), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-bill-chargers'])
             ?>
             <?php endif; ?>
         </div>
    </div>
<div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  Pjax::begin(['id'=>'bill-chargers-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'bill-chargers-grid',
/*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['bill-chargers/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-bill-chargers']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['bill-chargers/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-bill-chargers', 'disabled'=>true]),*/
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
		'template' => '{delete}',
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
	    if(\Yii::$app->user->can('chargers')) {
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
           // 'bill_id',
            [
                'attribute'=>'user_id',
                'value'=>function($model){
                    return isset($model->profiles->name)?$model->profiles->name:'';
                }
            ],  

            'amount',
            //'file_upload',
            //'remark',

        ],
    ]); ?>
    <div>
        <hr/>
        <h4>จำนวนเงินที่เก็บได้ทั้งหมด <?= number_format($totalPrice, 2)?> บาท   <?= $message?></h4>
    </div>
    <?php  Pjax::end();?>

</div>
</div>
<?=  ModalForm::widget([
    'id' => 'modal-bill-chargers','options'=>['tabindex' => false],
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
$('#modal-addbtn-bill-chargers').on('click', function() {
    modalBillCharger($(this).attr('data-url'));
});

$('#modal-delbtn-bill-chargers').on('click', function() {
    selectionBillChargerGrid($(this).attr('data-url'));
});

$('#bill-chargers-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#bill-chargers-grid').yiiGridView('getSelectedRows');
	disabledBillChargerBtn(key.length);
    },100);
});

$('.selectionCoreOptionIds').on('click',function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledBillChargerBtn(key.length);
});

//$('#bill-chargers-grid-pjax').on('dblclick', 'tbody tr', function() {
//    let data = $(this).attr('data-key');
//    let dataid = JSON.parse(data);
//    let id = dataid['bill_id'];
//    modalBillCharger('<?//= Url::to(['bill-chargers/update', 'id'=>''])?>//'+id);
//});

$('#bill-chargers-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalBillCharger(url);
    } else if(action === 'delete') {
        let bill_id = $(this).attr('bill_id');
	yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
            initBillPackage(bill_id)
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

function disabledBillChargerBtn(num) {
    if(num>0) {
	$('#modal-delbtn-bill-chargers').attr('disabled', false);
    } else {
	$('#modal-delbtn-bill-chargers').attr('disabled', true);
    }
}

function selectionBillChargerGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionBillChargerIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#bill-chargers-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalBillCharger(url) {
    $('#modal-bill-chargers .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-bill-chargers').modal('show')
    .find('.modal-content')
    .load(url);
}

$('#bill-chargers-grid table thead tr th a').on('click', function () {
    let url = $(this).attr('href');
    $.get(url,function (result) {
        $('#data-bill-chargers').html(result);
    })

    return false;
})
function initBillPackage(bill_id){
    let url = "<?= \yii\helpers\Url::to(['bill-chargers/manage'])?>";
    $.get(url,{bill_id:bill_id}, function (result) {
        $('#data-bill-chargers').html(result);
    });
    return false;
}

</script>
<?php  \richardfan\widget\JSRegister::end(); ?>