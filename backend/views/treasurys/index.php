<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\Treasurys */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Treasurys');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box box-primary">
    <div class="box-header">
         <i class="fa fa-table"></i> <?=  Html::encode($this->title) ?> 
         <div class="pull-right">
             <?= Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['treasurys/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-treasurys']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['treasurys/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-treasurys', 'disabled'=>false]) 
             ?>
         </div>
    </div>
<div class="box-body">    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  Pjax::begin(['id'=>'treasurys-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'treasurys-grid',
/*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['treasurys/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-treasurys']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['treasurys/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-treasurys', 'disabled'=>true]),*/
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
        'columns' => [
	    [
		'class' => 'yii\grid\CheckboxColumn',
		'checkboxOptions' => [
		    'class' => 'selectionTreasuryIds'
		],
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:40px;text-align: center;'],
	    ],
	    [
		'class' => 'yii\grid\SerialColumn',
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:60px;text-align: center;'],
	    ],


            'name',
	    'factor',

	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:180px;text-align: center;'],
		'template' => '{update} {delete}',
                'buttons'=>[
                    'update'=>function($url, $model){
                        return Html::a('<span class="fa fa-pencil"></span> '.Yii::t('app', 'แก้ไข'),
                                    yii\helpers\Url::to(['treasurys/update?id='.$model->id]), [
                                    'title' => Yii::t('app', 'แก้ไข'),
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    },
                    'delete' => function ($url, $model) {                         
                        return Html::a('<span class="fa fa-trash"></span> '.Yii::t('app', 'ลบ'),
                                yii\helpers\Url::to(['treasurys/delete?id='.$model->id]), [
                                'title' => Yii::t('app', 'ลบ'),
                                'class' => 'btn btn-danger btn-xs',
                                'data-confirm' => Yii::t('app', 'คุณแน่ใจหรือว่าต้องการลบรายการนี้หรือไม่?'),
                                'data-method' => 'post',
                                'data-action' => 'delete',
                                'data-pjax'=>0
                        ]);
                            
                        
                    },
                ]
	    ],
        ],
    ]); ?>
    <?php  Pjax::end();?>

</div>
</div>
<?=  ModalForm::widget([
    'id' => 'modal-treasurys',
    //'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('#modal-addbtn-treasurys').on('click', function() {
    modalTreasury($(this).attr('data-url'));
});

$('#modal-delbtn-treasurys').on('click', function() {
    selectionTreasuryGrid($(this).attr('data-url'));
});

$('#treasurys-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#treasurys-grid').yiiGridView('getSelectedRows');
	disabledTreasuryBtn(key.length);
    },100);
});

$('.selectionCoreOptionIds').on('click',function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledTreasuryBtn(key.length);
});

$('#treasurys-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalTreasury('<?= Url::to(['treasurys/update', 'id'=>''])?>'+id);
});	

$('#treasurys-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalTreasury(url);
    } else if(action === 'delete') {
	yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#treasurys-grid-pjax'});
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

function disabledTreasuryBtn(num) {
    if(num>0) {
	$('#modal-delbtn-treasurys').attr('disabled', false);
    } else {
	$('#modal-delbtn-treasurys').attr('disabled', true);
    }
}

function selectionTreasuryGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionTreasuryIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#treasurys-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalTreasury(url) {
    $('#modal-treasurys .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-treasurys').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>