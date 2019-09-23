<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Difficultys */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Difficultys',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Difficultys'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="difficultys-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modal'=>'modal-difficultys'
    ]) ?>

</div>
