<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $model backend\models\BillPackagers */
/* @var $form yii\bootstrap\ActiveForm */
$this->title ='จัดสินค้า';
?>

<div class="bill-packagers-form">

    <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
    ]); ?>

    <div class="modal-header">
	<button type="button" class="close">&times;</button>
        <h4 class="modal-title" id="itemModalLabel"><i class="fa fa-table"></i><?= $this->title; ?></h4>
    </div>

    <div class="modal-body">
	<div class="row">

                <?= $form->field($model, 'bill_id')->hiddenInput()->label(false)?>
            <div class="col-md-12">
                <?php
                /*ตัวอย่าง select2 get user*/
                    $init_data=[];
                    $userId=isset($model->user_id)?$model->user_id:'';
                    $url = \yii\helpers\Url::to(['/select2/get-user']);
                    if($userId != ''){
                        $init_data = \backend\classes\KNUser::getUserByIdAsSelect2($userId);
                    }
                    //\appxq\sdii\utils\VarDumper::dump($init_data);
                    echo \backend\classes\KNSelect2::renderSelect2Single($form, $model, 'user_id', $init_data, $url, '-- เลือก ผู้จัดสินค้า --', 0);

                ?>
            </div>
             
        </div>
        <div class="hidden">
            <?= $form->field($model, 'file_upload')->textInput(['maxlength' => true])->label(FALSE); ?>
        </div>
	 <?php
            echo $form->field($model, 'remark')->widget(\cpn\chanpan\widgets\CNFroalaEditorWidget::className(), [
                'toolbar_size' => 'sm',
                'options' => ['class' => 'eztemplate'],
            ]); //->hint('Default Template <a class="btn btn-warning btn-xs btn-template" data-widget="{tab-widget}">Use Default</a>'); 
        ?> 

    </div>
    <div class="modal-footer" style="background: #f3f3f3;">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?= Html::submitButton("Submit",['class'=>'btn btn-primary btn-block btn-lg']) ?>
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
// JS script
$('.close').on('click',function () {
    $('#modal-bill-packagers').modal('hide');
    return false;
});
$('form#<?= $model->formName()?>').on('beforeSubmit', function(e) {
    var $form = $(this);
    $.post(
        $form.attr('action'), //serialize Yii2 form
        $form.serialize()
    ).done(function(result) {
        if(result.status == 'success') {
            <?= SDNoty::show('result.message', 'result.status')?>
            if(result.action == 'create') {
                //$(\$form).trigger('reset');
                $(document).find('#modal-bill-packagers').modal('hide');
                initBillPackage();
            } else if(result.action == 'update') {
                $(document).find('#modal-bill-packagers').modal('hide');
                $.pjax.reload({container:'#bill-packagers-grid-pjax'});
            }
        } else {
            <?= SDNoty::show('result.message', 'result.status')?>
        } 
    }).fail(function() {
        <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
        console.log('server error');
    });
    return false;
});

function initBillPackage(){
    let url = "<?= \yii\helpers\Url::to(['bill-packagers/manage?bill_id='.$model->bill_id])?>";
    $.get(url, function (result) {
        $('#data-bill-package').html(result);
    });
    return false;
}

</script>
<?php  \richardfan\widget\JSRegister::end(); ?>