<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BillShippings */

$this->title = Yii::t('app', 'Create Bill Shippings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Shippings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-shippings-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
