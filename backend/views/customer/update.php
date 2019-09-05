<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Customers */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Customers',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customers-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
