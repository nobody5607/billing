<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper">
    <section class="content-header">


    </section>

    <section class="content">
         <?= yii\widgets\Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <?= isset(Yii::$app->params['footer'])?Yii::$app->params['footer']:''; ?>
</footer>

<!-- Control Sidebar -->
<div class='control-sidebar-bg'></div>
<?php $this->registerCss("
    div.required label.control-label:after {
        content: \" *\";
        color: red;
    }
")?>