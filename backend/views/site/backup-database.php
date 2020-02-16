<?php
$url_backup = isset(Yii::$app->params['url_backup'])?Yii::$app->params['url_backup']:'';
//\appxq\sdii\utils\VarDumper::dump($url_backup);
?>

<div id="app">
    <div class="panel panel-default">
        <div class="panel-heading">สำรองฐานข้อมูล</div>
        <div class="panel-body">

            <table class="table table-striped table-hover table-responsive">
                <thead>
                <tr>
                    <th>ชื่อไฟล์</th>
                    <th class="text-right">
                        <button @click="backupData()" class="btn btn-success">สำรองข้อมูล</button>
                    </th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="value in database">
                        <td>{{ value }}</td>
                        <td class="text-right">
                            <a @click="downloadData(value)"><i class="fa fa-download"></i> ดาวน์โหลด</a>
                            <a @click="deleteData(value)"><i class="fa fa-trash"></i> ลบ</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php \richardfan\widget\JSRegister::begin()?>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            url_backup:"<?= $url_backup; ?>",
            database:[],
            message: 'Hello Vue!'
        },
        created(){
            // console.log('ok')
            this.fetchData();
        },
        methods: {
            async backupData() {
                let url = '<?= \yii\helpers\Url::to(['/site/backup'])?>';
                let result = await axios.get(url);
                if(result.data.status === 'success'){
                    this.fetchData();
                }
            },
            async deleteData(value) {
                let url = '<?= \yii\helpers\Url::to(['/site/delete-database'])?>';
                let result = await axios.get(url);
                if(result.data.status === 'success'){
                    this.fetchData();
                }
            },
            async fetchData() {
                let url = '<?= \yii\helpers\Url::to(['/site/database'])?>';
                let result = await axios.get(url);
                //console.log(result)
                if(result.data.status === 'success'){
                    console.log('ok');
                    let {data} = result.data;
                    // data = ['xxx2.sql','sss3.sql','sss4.sql'];
                    this.database = data;
                    console.log(data)
                }

            },
            downloadData(value){
                let url = this.url_backup+value;
                window.open(url,'_blank');
            }
        }
    })
</script>
<?php \richardfan\widget\JSRegister::end();?>
