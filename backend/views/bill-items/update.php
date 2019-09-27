<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BillItems */

$this->title = "จัดการบิล ".$model->billno;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modal-header kn-modal-header">
    <button type="button" class="btn btn-danger pull-right btnModalMain"><i class="fa fa-power-off"></i></button>
    <h3 class="modal-title" id="itemModalLabel"> <?= Html::encode($this->title)?></h3>
</div>
<div class="modal-body">
    <div class="bill-items-update">

    <ul class="nav nav-tabs">
        <li class="active" style="font-size: 12pt;font-weight: bold;"><a data-toggle="tab" href="#bill-items"><i class="fa fa-files-o" aria-hidden="true"></i> รายละเอียดบิล</a></li>
        <li style="font-size: 12pt;font-weight: bold;"><a data-toggle="tab" href="#product-list"><i class="fa fa-th-list" aria-hidden="true"></i> รายการสินค้า</a></li>
<!--        <li><a data-toggle="tab" href="#bill-packagers">จัดสินค้า</a></li>
        <li><a data-toggle="tab" href="#bill-shippings">ส่งสินค้า</a></li>
        <li><a data-toggle="tab" href="#bill-chargers">เรียกเก็บเงิน</a></li>-->
    </ul>

    <div class="tab-content">

        <div id="bill-items" class="tab-pane fade in active">
            <?= $this->render('_form', [
                'model' => $model,
                'modal' => '',
            ]) ?>
        </div>
        <div id="product-list" class="tab-pane fade">
            <div id="product-list"></div>
        </div>
<!--        <div id="bill-packagers" class="tab-pane fade">
            <div id="data-bill-package"></div>
        </div>
        <div id="bill-shippings" class="tab-pane fade">
            <div id="data-bill-shippings"></div>
        </div>
        <div id="bill-chargers" class="tab-pane fade">
            <div id="data-bill-chargers"></div>
        </div>-->
    </div>




</div>
</div>
<?php \richardfan\widget\JSRegister::begin();?>
<script>
    
    $('.btnModalMain').on('click',function () {
       $('#modal-bill-items').modal('hide');
       return false;
    });
    function initBillPackage(){
        let url = "<?= \yii\helpers\Url::to(['bill-packagers/manage?bill_id='.$model->id])?>";
        $.get(url, function (result) {
            $('#data-bill-package').html(result);
        });
        return false;
    }
    function initBillShipping(){
        let url = "<?= \yii\helpers\Url::to(['bill-shippings/manage?bill_id='.$model->id])?>";
        $.get(url, function (result) {
            $('#data-bill-shippings').html(result);
        });
        return false;
    }
    function initBillChargers(){
        let url = "<?= \yii\helpers\Url::to(['/bill-chargers/manage?bill_id='.$model->id])?>";
        $.get(url, function (result) {
            $('#data-bill-chargers').html(result);
        });
        return false;
    }
    function initProductList() {
        let url = "<?= \yii\helpers\Url::to(['/product-list/index?bill_id='.$model->id])?>";
        $.get(url, function (result) {
            $('#product-list').html(result);
        });
        return false;
    }

    initProductList();
//    initBillPackage();
//    initBillShipping();
//    initBillChargers();
</script>
<?php \richardfan\widget\JSRegister::end();?>
