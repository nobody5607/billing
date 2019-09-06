<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\BillItems */

$this->title = 'Bill Items#'.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-items-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body">
        <?= DetailView::widget([
	    'model' => $model,
	    'attributes' => [
		'id',
		'bookno',
		'billno',
		'billref',
		'shop_id',
		'btype',
		'amount',
		'status',
		'shiping',
		'charge',
		'bill_upload',
		'remark',
	    ],
	]) ?>
    </div>
</div>
