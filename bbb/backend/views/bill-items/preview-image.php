<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= Yii::t('bill', 'Preview Image') ?></div>
        <div class="panel-body">
            <div class="row">
                <?php foreach ($files as $k => $v): ?>
                    <div class="col-md-2" style="margin-bottom:5px;" id="row-<?= $v['id']; ?>">
                        <div class="row"> 
                            
                            <div class="col-md-12">
                                <?php if (\Yii::$app->user->can('delete_bill_image')): ?>
                                    <a title="ลบรายการ" style="color:#F44336;float:right;font-weight: bold;" href="#" class="btnDelete" data-id="<?= $v['id']; ?>"><i class="fa fa-times"></i></a>
                                <?php endif; ?>
                                    <br>
                                <?php
                                    $storageUrl = \Yii::getAlias('@storageUrl');
                                    $url = "{$storageUrl}/uploads/{$v->filename}";
                                    $img = yii\helpers\Html::img($url, ['style' => 'width: 100%;height: 100px;']);
                                    echo "<a href='{$url}' target='_BLANK' class='showImage'>{$img}</a>";
                                ?>
                            </div>
                            <div class="col-md-12">
                                <?= $v->billType->name; ?> 
                            </div>
                        </div>  
                         
                    </div>

                <?php endforeach; ?>
            </div>
        </div></div>
</div>
<?php
\richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]);
?>
<script>
    $(".btnDelete").on('click', function () {
        let id = $(this).attr('data-id');
        bootbox.confirm({
            message: "Confirm Delete",
            buttons: {
                confirm: {
                    label: 'OK',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Cancel',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result) {
                    let url = '<?= \yii\helpers\Url::to(['/bill-items/delete-files']) ?>';
                    $.post(url, {id: id}, function (res) {
                        if (res['status'] == 'success') {
                            $(`#row-${id}`).remove();
                            initPreview();
                        }
                    });
                }
            }
        });
        return false;
    });
</script>
<?php \richardfan\widget\JSRegister::end(); ?>