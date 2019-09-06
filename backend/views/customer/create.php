<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Customers */

$this->title = Yii::t('app', 'Create Customers');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customers-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
