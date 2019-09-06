<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BillItems */

$this->title = Yii::t('bill', 'Create Bill');
$this->params['breadcrumbs'][] = ['label' => Yii::t('bill', 'Bill'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-items-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modal'=>true
    ]) ?>

</div>
