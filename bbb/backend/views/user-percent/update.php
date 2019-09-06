<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserPercent */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'User Percent',
]) . ' ' . $model->bill_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Percents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bill_id, 'url' => ['view', 'id' => $model->bill_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-percent-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
