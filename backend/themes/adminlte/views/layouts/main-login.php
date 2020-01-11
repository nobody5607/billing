<?php
use backend\assets\AppAsset;
use yii\helpers\Html;

$storageUrl = isset(Yii::$app->params['storageUrl'])?Yii::$app->params['storageUrl']:'';
$login = "{$storageUrl}/images/logo_bg.jfif";

    //

/* @var $this \yii\web\View */
/* @var $content string */

dmstr\web\AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="login-page" style="background: #fff;">
    <?php $this->beginBody() ?>
    <div>
        <a href="<?= \yii\helpers\Url::to(['/'])?>">
            <div id="logo" class="text-center">
                <img src="<?= $login?>" alt="logo" class="img img-responsive" style="width:150px;margin:0 auto;margin-top:20px;">
            </div>
            <h3 class="text-center" style="margin-top:0px;font-weight: bold;    color: #001de3;
    text-transform: uppercase;">
                Billing
            </h3>
        </a>
    </div>

        <?= $content ?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
