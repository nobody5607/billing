<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Storages */

$this->title = Yii::t('app', 'Create Storages');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Storages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="storages-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
