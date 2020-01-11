<?php 
    $this->title = Yii::t('appmenu', 'Home');
?>
<?php if (Yii::$app->user->can('edit_home')): ?>
    <a href="#" class="link btnEdit" data-url="<?= yii\helpers\Url::to(['/site/edit?params=home']) ?>"><i class="fa fa-pencil"></i></a>
<?php endif; ?>
<div class="text-muted" id="app">
    <?= isset(\Yii::$app->params['home']) ? \Yii::$app->params['home'] : '' ?> 
</div>
    
<?php if (Yii::$app->user->can('edit_home')): ?>    
    
<?=
\appxq\sdii\widgets\ModalForm::widget([
    'id' => 'modal-options',
    'size'=>'modal-lg',
    'options' => ['tabindex' => false],
]);
?>

<?php
\richardfan\widget\JSRegister::begin();
?>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            stbill:{
                allbill:10,//บิลทั้งหมด
                normalbill:0,//บิลปกติ
                damagedbill:0,//บิลชำรุด
                cancelbill:0,//ยกเลิกบิล
                closebill:0//ปิดบิล
            },
            dlystatus:{
                nopackagepro:0,//ยังไม่จัดสินค้า
                packagepro:0,//จัดสินค้าแล้ว
                shippingpro:0,//ส่งสินค้าแล้ว
                cancelpro:0,//ยกเลิก
            },
            billtype:{
                othor:0,//ไม่ระบุ
                cr:0,
                crv:0,
                jcr:0,
                jcrv:0
            }
        },
        methods:{

        },
        async mounted () {
            try{
                let result = await axios.get('<?= \yii\helpers\Url::to(['/api2'])?>');
                let {data} = result.data;
                this.stbill = data.stbill;
                this.dlystatus = data.dlystatus;
                this.billtype = data.billtype;
                console.log(data);
            }catch(error){

            }
        }
    })


// JS script
    $('.btnEdit').on('click', function () {
        let url = $(this).attr('data-url');
        modalOption(url);
        //alert(url);
        return false;
    });
    function modalOption(url) {
        $('#modal-options .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
        $('#modal-options').modal('show')
                .find('.modal-content')
                .load(url);
    }
</script>
<?php \richardfan\widget\JSRegister::end(); ?>
<?php endif; ?>