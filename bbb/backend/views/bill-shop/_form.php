<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $model backend\models\BillShop */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="bill-shop-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
	'id'=>$model->formName(),
    ]); ?>

    <div class="modal-header" >
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="itemModalLabel"><i class="fa fa-table"></i> Bill Shop</h4>
    </div>
    
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
               <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'lat')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'lng')->textInput(['maxlength' => true]) ?>
            </div>
        </div> 
   
        <?php
            echo $form->field($model, 'remark')->widget(\cpn\chanpan\widgets\CNFroalaEditorWidget::className(), [
                'toolbar_size' => 'sm',
                'options' => ['class' => 'eztemplate'],
            ]); //->hint('Default Template <a class="btn btn-warning btn-xs btn-template" data-widget="{tab-widget}">Use Default</a>'); 
        ?> 
        
    <div class="modal-footer" style="background: #f3f3f3;">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success btn-lg btn-block' : 'btn btn-primary btn-lg btn-block']) ?>	 
            </div>
        </div>
	
    </div>
        
    <?php ActiveForm::end(); ?>

</div>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
$('form#<?= $model->formName()?>').on('beforeSubmit', function(e) {  
    var $form = $(this);
    var formData = new FormData($(this)[0]);
    $.ajax({
        url:$form.attr('action'),
        type:'POST',
        data:formData,
        processData: false,
        contentType: false,
        cache: false,         
        enctype: 'multipart/form-data',
        success:function(result){
                <?= SDNoty::show('result.message', 'result.status')?>
                if(result.status == 'success') {
                $(document).find('#modal-bill-shop').modal('hide');
                $.pjax.reload({container:'#bill-shop-grid-pjax'});
                }   
        }
      }).fail(function( jqXHR, textStatus ) {
         <?= SDNoty::show('result.message', 'result.status')?>
      });    
     
    return false;
}); 

</script>
<?php  \richardfan\widget\JSRegister::end(); ?>