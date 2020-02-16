<?php
//    \appxq\sdii\utils\VarDumper::dump($output);
    $url_backup = isset(Yii::$app->params['url_backup'])?Yii::$app->params['url_backup']:'';
    if($output){
        rsort($output);
    }
?>
<?php if($output):?>
<?php foreach($output as $k=>$v):?>
    <div>
        <a href="<?= "{$url_backup}{$v}"?>"><?= $v; ?></a>
    </div>
<?php endforeach;?>
<?php endif; ?>
