<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Remarks */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Remarks',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Remarks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="remarks-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
