<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BillRc */

$this->title = Yii::t('app', 'Create Bill Rc');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Rcs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-rc-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
