<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Treasurys */

$this->title = Yii::t('app', 'Create Treasurys');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Treasurys'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="treasurys-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
