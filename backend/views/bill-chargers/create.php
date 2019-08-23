<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BillChargers */

$this->title = Yii::t('app', 'Create Bill Chargers');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Chargers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-chargers-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
