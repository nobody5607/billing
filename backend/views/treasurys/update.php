<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Treasurys */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Treasurys',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Treasurys'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="treasurys-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
