<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BillPackagers */

$this->title = Yii::t('app', 'Create Bill Packagers');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Packagers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-packagers-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
