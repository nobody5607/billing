<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AffectiveScore */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Affective Score',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Affective Scores'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="affective-score-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
