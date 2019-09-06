<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\UserPercent */

$this->title = 'User Percent#'.$model->bill_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Percents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-percent-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body">
        <?= DetailView::widget([
	    'model' => $model,
	    'attributes' => [
		'bill_id',
		'driver',
		'customer',
		'default',
	    ],
	]) ?>
    </div>
</div>
