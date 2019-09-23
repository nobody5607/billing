<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Difficultys */

$this->title = Yii::t('app', 'Create Difficultys');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Difficultys'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="difficultys-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modal' => $modal,
    ]) ?>

</div>
