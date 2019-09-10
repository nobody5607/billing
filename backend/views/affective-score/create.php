<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AffectiveScore */

$this->title = Yii::t('app', 'Create Affective Score');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Affective Scores'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="affective-score-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
