<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Groups */

$this->title = Yii::t('app', 'Create Groups');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="groups-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
