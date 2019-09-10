<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BillType */

$this->title = Yii::t('app', 'Create Bill Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-type-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modal' => $modal,
    ]) ?>

</div>
