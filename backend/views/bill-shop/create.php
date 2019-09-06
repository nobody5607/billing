<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BillShop */

$this->title = Yii::t('app', 'Create Bill Shop');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Shops'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-shop-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
