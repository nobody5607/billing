<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Remarks */

$this->title = Yii::t('app', 'Create Remarks');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Remarks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="remarks-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
