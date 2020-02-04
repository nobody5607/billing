<?php 
    $this->title = Yii::t('appmenu', 'Home');
?>
<?php if (Yii::$app->user->can('edit_home')): ?>
    <a href="#" class="link btnEdit" data-url="<?= yii\helpers\Url::to(['/site/edit?params=home']) ?>"><i class="fa fa-pencil"></i></a>
<?php endif; ?>
<div class="text-muted" id="app">
    <?= isset(\Yii::$app->params['home']) ? \Yii::$app->params['home'] : '' ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <label for="">เลือกปีที่ต้องการแสดง</label>
                    <select name="" id=""   @change="getReport" class="btn btn-default">
                        <option value="">เลือกปี</option>
                        <?php
                            $year = date('Y')+543;
                            //\appxq\sdii\utils\VarDumper::dump($year);
                        ?>
                        <?php for($i=2556; $i<=$year; $i++):?>
                            <option value="<?= $i-543; ?>"><?= $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="panel-body">
                    <canvas id="myChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
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
            selectYear:'<?= date('Y');?>',
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
            getReport(event){
                this.selectYear = event.target.value;
                this.showChat();
            },
            async showChat(){

                var ctx = document.getElementById('myChart');
                let url = "<?= \yii\helpers\Url::to(['/site/report']);?>?year="+this.selectYear;
                let result = await axios.get(url);

                if(result.data.status == 'success'){
                    let {data} = result.data;
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: data.title,
                                data:data.data,
                                backgroundColor: data.backgroundColor,
                                borderColor: data.borderColor,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                }
            }
        },
        async mounted () {
            try{
                this.showChat();
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