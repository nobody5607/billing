<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BillStatus */

$this->title = Yii::t('app', 'Create Bill Status');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Statuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
