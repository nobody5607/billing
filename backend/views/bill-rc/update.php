<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BillRc */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Bill Rc',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Rcs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-rc-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
