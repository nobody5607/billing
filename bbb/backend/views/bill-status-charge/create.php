<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BillStatusCharge */

$this->title = Yii::t('app', 'Create Bill Status Charge');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Status Charges'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-status-charge-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
