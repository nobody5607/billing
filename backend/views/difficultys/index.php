<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\Difficultys */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Difficultys');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box box-primary">
    <div class="box-header">
         <i class="fa fa-table"></i> <?=  Html::encode($this->title) ?> 
         <div class="pull-right">
             <?= Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['difficultys/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-difficultys']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['difficultys/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-difficultys', 'disabled'=>false]) 
             ?>
         </div>
    </div>
<div class="box-body">    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  Pjax::begin(['id'=>'difficultys-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'difficultys-grid',
/*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['difficultys/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-difficultys']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['difficultys/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-difficultys', 'disabled'=>true]),*/
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
        'columns' => [
	    [
		'class' => 'yii\grid\CheckboxColumn',
		'checkboxOptions' => [
		    'class' => 'selectionDifficultyIds'
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
            'percent',

	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:180px;text-align: center;'],
		'template' => '{update} {delete}',
                'buttons'=>[
                    'update'=>function($url, $model){
                        return Html::a('<span class="fa fa-edit"></span> '.Yii::t('app', 'Edit'), 
                                    yii\helpers\Url::to(['difficultys/update?id='.$model->id]), [
                                    'title' => Yii::t('app', 'Edit'),
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    },
                    'delete' => function ($url, $model) {                         
                        return Html::a('<span class="fa fa-trash"></span> '.Yii::t('app', 'Delete'), 
                                yii\helpers\Url::to(['difficultys/delete?id='.$model->id]), [
                                'title' => Yii::t('app', 'Delete'),
                                'class' => 'btn btn-danger btn-xs',
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
<?=  ModalForm::widget([
    'id' => 'modal-difficultys',
    //'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('#modal-addbtn-difficultys').on('click', function() {
    modalDifficulty($(this).attr('data-url'));
});

$('#modal-delbtn-difficultys').on('click', function() {
    selectionDifficultyGrid($(this).attr('data-url'));
});

$('#difficultys-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#difficultys-grid').yiiGridView('getSelectedRows');
	disabledDifficultyBtn(key.length);
    },100);
});

$('.selectionCoreOptionIds').on('click',function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledDifficultyBtn(key.length);
});

$('#difficultys-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalDifficulty('<?= Url::to(['difficultys/update', 'id'=>''])?>'+id);
});	

$('#difficultys-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalDifficulty(url);
    } else if(action === 'delete') {
	yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#difficultys-grid-pjax'});
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

function disabledDifficultyBtn(num) {
    if(num>0) {
	$('#modal-delbtn-difficultys').attr('disabled', false);
    } else {
	$('#modal-delbtn-difficultys').attr('disabled', true);
    }
}

function selectionDifficultyGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionDifficultyIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#difficultys-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalDifficulty(url) {
    $('#modal-difficultys .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-difficultys').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>