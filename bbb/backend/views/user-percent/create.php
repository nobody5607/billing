<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UserPercent */

$this->title = Yii::t('app', 'Create User Percent');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Percents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-percent-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
