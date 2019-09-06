<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BillPackagers */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Bill Packagers',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Packagers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-packagers-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
