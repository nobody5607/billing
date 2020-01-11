<?php

use appxq\sdii\widgets\ModalForm;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
 
// use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $model backend\models\BillItems */
/* @var $form yii\bootstrap\ActiveForm */
?>
<?php if(isset($modal)):?>
    <div class="modal-header kn-modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 id="itemModalLabel"> <?= Html::encode($this->title)?></h4>
    </div>
<?php endif;?>
<div class="bill-items-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
	'id'=>$model->formName(),
    ]); ?>



<?= $form->field($model, 'id')
    ->hiddenInput()->label(FALSE) ?>
    <?php if(isset($modal)):?>
    <div class="modal-body">
        <?php else:?>
    <div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-4 col-lg-4">
                <?php
                        $items = \backend\models\Groups::find()->all();
                        $items = yii\helpers\ArrayHelper::map($items, 'id', 'name');
                        echo $form->field($model, 'blog')->dropDownList($items,['prompt'=>'--เลือกกล่อง--'])
                ?>
            </div>
            <div class="col-md-6 col-sm-4 col-xs-4 col-lg-4"> 
                <?= $form->field($model, 'billno')
                    ->textInput(['maxlength' => true,'readonly'=> \Yii::$app->user->can('billmanager')?false:true]) ?>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4 col-lg-4">
                
                <?php
                    echo $form->field($model, 'bill_date')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'เลือกวันที่','readonly'=> \Yii::$app->user->can('billmanager')?false:true],
                        'value' => isset($model->create_date)?$model->create_date:date('Y-m-d'),
                        'pluginOptions' => [
                            'todayHighlight' => true,
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                ?>
            </div> 
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3">
            <?php 
                /* Select2 */
                $url = \yii\helpers\Url::to(['/select2/bill-type?type=1']);
                $init_data = isset($model->bill_type) ? backend\models\BillType::findOne($model->bill_type) : '';

                echo \cpn\chanpan\widgets\KNSelect2::widget([
                    'minimumInputLength'=>0,
                    'init_data'=>$init_data,
                    'model'=>$model,
                    'field'=>'bill_type',
                    'form'=>$form,
                    'options'=>['placeholder'=>'-- เลือกประเภทบิล --'],
                    'url'=>$url,
                    'addUrl'=>Url::to(['/bill-type/create?modal=modal-bill-items-child&type=1']),
                    'addId'=>'select-type1',
                    'modal'=>'modal-bill-items-child'
                ]);
                //echo \backend\classes\KNSelect2::renderSelect2Single($form, $model, 'bill_type', $init_data, $url, '-- เลือกประเภทบิล --', 0);
            ?>
            
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
            <?php 
                /* Select2 */

            echo $form->field($model, 'billref')
                ->textInput(['maxlength' => true, 'readonly' => \Yii::$app->user->can('billmanager') ? false : true])
 
            ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <?= $form->field($model, 'bookno')->textInput(['readonly'=> \Yii::$app->user->can('billmanager')?false:true]) ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <?= $form->field($model, 'amount')->textInput(['maxlength' => true,'readonly'=> \Yii::$app->user->can('billmanager')?false:true]) ?>
            </div>
        </div> 
            <?php
                /* Select2 */
                $url = \yii\helpers\Url::to(['/select2/bill-shop']);
                $init_data = isset($model->shop_id) ? backend\models\BillShop::findOne($model->shop_id) : '';
                //echo \backend\classes\KNSelect2::renderSelect2Single($form, $model, 'shop_id', $init_data, $url, '-- เลือก Bill Shop --', 0);
                 
            ?> 
        
        <div class="row">
            
            <div class="col-md-2 col-sm-3 col-xs-3">
                 <?php
                    if($model->status == '5' AND !Yii::$app->user->can('billmanager')){
                        echo "<label class='label label-success' style='font-size: 16px;display: block;padding: 10px;'><i class='fa fa-check'></i> ยืนยันชำรุด</label>";
                    }else if($model->status == '4' AND !Yii::$app->user->can('billmanager')){
                        echo "<label class='label label-success' style='font-size: 16px;display: block;padding: 10px;'><i class='fa fa-check'></i> ยืนยันยกเลิก</label>";
                    }else{
                        $items = \yii\helpers\ArrayHelper::map(\backend\models\BillStatus::find()->where('rstat not in(0,3)')->all(), 'id', 'name');
                        echo $form->field($model, 'status')
                            ->radioList($items,[]);
                    }

                ?>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-3">
                 <?php
                 if($model->shiping == '9' AND !Yii::$app->user->can('billmanager')){
                        echo "<label class='label label-success' style='font-size: 16px;display: block;padding: 10px;'><i class='fa fa-check'></i> ยืนยันจัดส่งสินค้า</label>";
                 }else if($model->shiping == '8' AND !Yii::$app->user->can('billmanager')){
                        echo "<label class='label label-success' style='font-size: 16px;display: block;padding: 10px;'><i class='fa fa-check'></i> ยืนยันยกเลิก</label>";
                 }else {
                     $items = \yii\helpers\ArrayHelper::map(\backend\models\BillStatusShipping::find()->where('rstat not in(0,3)')->all(), 'id', 'name');
                     echo $form->field($model, 'shiping')
                         ->radioList($items, []);
                 }
                ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
                 <?php
                    if($model->charge == '10' AND !Yii::$app->user->can('billmanager')){
                        echo "<label class='label label-success' style='font-size: 16px;display: block;padding: 10px;'><i class='fa fa-check'></i> ยืนยันตัดบัญชีแล้ว</label>";
                    }else {
                     $items = \yii\helpers\ArrayHelper::map(\backend\models\BillStatusCharge::find()->where('rstat not in(0,3)')->all(), 'id', 'name');
                     echo $form->field($model, 'charge')
                         ->radioList($items, []);
                    }
                ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
                <?php
                    if($model->charge == '10' AND !Yii::$app->user->can('billmanager')){
                        echo "<label class='label label-success'>ยืนยันตัดบัญชีแล้ว</label>";
                    }else {
                        $items = \backend\models\Difficultys::find()->all();
                        // \appxq\sdii\utils\VarDumper::dump($items);
                        $items = yii\helpers\ArrayHelper::map($items, 'id', 'name');
                        echo $form->field($model, 'difficulty')->radioList($items, []);
                    }
                ?>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-3">
                <?php
                if(!Yii::$app->user->can('billmanager')){
                    echo "";
                }else {
                    $items = \backend\models\AffectiveScore::find()->all();
                    $items = yii\helpers\ArrayHelper::map($items, 'id', 'name');
                    echo $form->field($model, 'affective_score')->radioList($items, []);
                }
                ?>
            </div>
            
        </div>  
        <div class="row">
            <div class="col-md-4">
                <?php 
                /* Select2 */
                $url = \yii\helpers\Url::to(['/select2/bill-type?type=3']);
                $init_data = isset($model->billtype) ? backend\models\BillType::findOne($model->billtype) : '';
                echo \cpn\chanpan\widgets\KNSelect2::widget([
                    'minimumInputLength'=>0,
                    'init_data'=>$init_data,
                    'model'=>$model,
                    'field'=>'billtype',
                    'form'=>$form,
                    'options'=>['placeholder'=>'-- เลือกประเภทบิล --'], 
                    'url'=>$url,
                    'addUrl'=>Url::to(['/bill-type/create?modal=modal-bill-items-child&type=3']),
                    'addId'=>'select-type3',
                    'modal'=>'modal-bill-items-child'
                ]);
            ?>
                
            </div>
            <div class="col-md-6">
                <?php 
                    echo $form->field($model, 'bill_upload')->widget(kartik\widgets\FileInput::classname(), [
                        'options' => ['multiple' => false,'disabled'=>\Yii::$app->user->can('billmanager')?false:true],
                        'pluginOptions' => [
                            'showPreview' => false,
                            'showCaption' => true,
                            'showRemove' => true,
                            'showUpload' => false
                        ]
                    ]);
                    //echo backend\classes\KNFileUpload::renderFileUploadSignle($form, $model, 'bill_upload', $model->bill_upload);
                ?>
            </div>
            <div class="col-md-2">
                <?php if(\Yii::$app->user->can('billmanager')):?>
                    <button class="btn btn-success" id="btnUploadFiles" type="button" style="margin-top: 25px;">อัปโหลด</button>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div id="preview-bill"></div>
        </div>
        <?php
//            echo $form->field($model, 'remark')->widget(\cpn\chanpan\widgets\CNFroalaEditorWidget::className(), [
//                'toolbar_size' => 'sm',
//                'options' => ['class' => 'eztemplate'],
//            ]); //->hint('Default Template <a class="btn btn-warning btn-xs btn-template" data-widget="{tab-widget}">Use Default</a>');
        ?>
<?php
echo $form->field($model, 'remark')->textarea(); //->hint('Default Template <a class="btn btn-warning btn-xs btn-template" data-widget="{tab-widget}">Use Default</a>');
?>

    </div>
    <div class="modal-footer" style="background: #f3f3f3;">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                 
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Submit'), ['class' => $model->isNewRecord ? 'btn btn-success btn-lg btn-block' : 'btn btn-primary btn-lg btn-block']) ?>	 
                 
            </div>
        </div>
	
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?=
ModalForm::widget([
    'id' => 'modal-bill-items-child',
    'options' => ['tabindex' => false],
    'size' => 'modal-sm',
]);

$billmanager = \Yii::$app->user->can('billmanager');
?>
<?php if($model->isNewRecord):?>
<?php richardfan\widget\JSRegister::begin();?>
    <script>
        $('#billitems-blog').on('change',function(){
        let blog = $(this).val();
        let url = '<?= Url::to(['/bill-items/get-billno'])?>';
        $.get(url,{id:blog}, function(res){
            $("#billitems-billno").val(res);
        });
        return false;
     }); 
    </script>
<?php richardfan\widget\JSRegister::end();?>    
<?php endif; ?>    
    
    
<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
$("#billitems-bill_type").on('change', function(){
	let billType = $(this).val();
        let url = "<?= \yii\helpers\Url::to(['/bill-items/generate-bill-type'])?>";
        $.get(url,{billType:billType}, function(data){
            let billno = $("#billitems-billno").val();
            $('#billitems-billref').val(data+billno);
        });
        return false;
        
    });
$("#btnUploadFiles").on('click',function(){
   let frm = $('#<?= $model->formName()?>');
   let formData = new FormData(frm[0]);
   let url = '<?= Url::to(['/bill-items/upload-files?id='.$model->id])?>';
   $.ajax({
        url:url,
        type:'POST',
        data:formData,
        processData: false,
        contentType: false,
        cache: false,         
        enctype: 'multipart/form-data',
        success:function(result){
          <?= SDNoty::show('result.message', 'result.status')?>
          if(result['status'] == 'success'){
            initPreview();  
          }        
        }
      }).fail(function( jqXHR, textStatus ) {
         <?= SDNoty::show('result.message', 'result.status')?>
      });
   return false;
});    
function initPreview(){
    console.warn('initPreview');
    let url = '<?= Url::to(['/bill-items/preview-image?id='.$model->id])?>';
    $.get(url, function(res){
        $("#preview-bill").html(res);
    });
    return false;
}
initPreview();  
    
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
                   $(document).find('#modal-bill-items').modal('hide');
                   // $.pjax.reload({container:'#bill-items-grid-pjax'});
                    setTimeout(function () {
                        location.reload();
                    },1000);
                }   
        }
      }).fail(function( jqXHR, textStatus ) {
         <?= SDNoty::show('result.message', 'result.status')?>
      });    
     
    return false;
});

if('<?= $billmanager?>' == 'false'){
    $(':radio, :checkbox').attr('disabled', true);
    $('input').attr('disabled', true);
}


</script>
<?php  \richardfan\widget\JSRegister::end(); ?>