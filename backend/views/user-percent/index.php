<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="kt-portlet ">
    
    <div class="kt-portlet__body">
        <div class="kt-widget4">
             <?php  Pjax::begin(['id'=>'user-percent-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'user-percent-grid',
/*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['user-percent/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-user-percent']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['user-percent/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-user-percent', 'disabled'=>true]),*/
	'dataProvider' => $dataProvider,
	'layout'=> "{items}",
        'summary' => "",
        'columns' => [



            'driver',
            'customer',
            'default',

	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:80px;text-align: center;'],
		'template' => '{update} {delete}',
                'buttons'=>[
                    
                    'update'=>function($url, $model){
                        if(!Yii::$app->user->can('manage_user_percent')){
                            return '';
                        }
                        return Html::a('<span class="fa fa-edit"></span> '.Yii::t('app', ''),
                                    yii\helpers\Url::to(['user-percent/update?id='.$model->id]), [
                                    'title' => Yii::t('app', 'Edit'),
                                    'class' => 'btn btn-primary btn-xs btn-user-percent-status',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    },
                    'delete' => function ($url, $model) {    
                        if(!Yii::$app->user->can('manage_user_percent')){
                            return '';
                        }
                        return Html::a('<span class="fa fa-trash"></span> '.Yii::t('app', ''),
                                yii\helpers\Url::to(['user-percent/delete?id='.$model->id]), [
                                'title' => Yii::t('app', 'Delete'),
                                'class' => 'btn btn-danger btn-xs btn-user-percent-status',
                                'data-confirm' => Yii::t('chanpan', 'Are you sure you want to delete this item?'),
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
</div>   


<?=  ModalForm::widget([
    'id' => 'modal-user-percent',
    //'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('#modal-addbtn-user-percent').on('click', function() {
    modalUserPercent($(this).attr('data-url'));
});

$('#modal-delbtn-user-percent').on('click', function() {
    selectionUserPercentGrid($(this).attr('data-url'));
});

$('#user-percent-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#user-percent-grid').yiiGridView('getSelectedRows');
	disabledUserPercentBtn(key.length);
    },100);
});

$('.selectionCoreOptionIds').on('click',function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledUserPercentBtn(key.length);
});

$('#user-percent-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalUserPercent('<?= Url::to(['user-percent/update', 'id'=>''])?>'+id);
});	

$('#user-percent-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalUserPercent(url);
    } else if(action === 'delete') {
	yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#user-percent-grid-pjax'});
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

function disabledUserPercentBtn(num) {
    if(num>0) {
	$('#modal-delbtn-user-percent').attr('disabled', false);
    } else {
	$('#modal-delbtn-user-percent').attr('disabled', true);
    }
}

function selectionUserPercentGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionUserPercentIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#user-percent-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalUserPercent(url) {
    $('#modal-user-percent .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-user-percent').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>