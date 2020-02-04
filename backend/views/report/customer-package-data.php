<div style="background: #fff;padding:10px;">    <table class="table table-striped table-responsive table-hover">        <thead style="background: #4abdac;    color: #fff;">        <tr>            <th width="50">ลำดับ</th>            <th>ชื่อบิล</th>            <th>ชื่อพนักงาน</th>            <th>ตำแหน่ง</th>            <th>ที่เก็บ</th>            <th>Factor</th>            <th>Percent ที่ได้</th>            <th>มูลค่า/บาท</th>            <th>วันที</th>        </tr>        </thead>        <tbody>        <?php            $totalPrice=0;        ?>        <?php foreach($data as $k=>$v):?>            <tr>                <td class="text-center"><?= $k+1; ?></td>                <td>                    <?php                        $bill = \backend\models\BillItems::findOne($v['bill_id']);                    ?>                    <a class="bill-items" href="<?= \yii\helpers\Url::to(['/bill-items/update?id='.$bill->id]);?>"><?= $bill->billref;?></a>                </td>                <td><?= $v['driver']; ?></td>                <td><?= $v['position']; ?></td>                <td class="text-right"><?= $v['treasury']; ?></td>                <td class="text-right"><?= $v['factor']; ?></td>                <td class="text-right"><?= $v['percent_package'];?></td>                <td class="text-right"><?php $totalPrice+=$v['price']; echo number_format($v['price'], 2); ?></td>                <td><?= isset($v['create_date'])?\appxq\sdii\utils\SDdate::mysql2phpDate($v['create_date']):''?></td>            </tr>        <?php endforeach;?>        </tbody>        <tfoot style="background: #4abdac;    color: #fff;">            <tr style="font-size:18pt;">                <td></td>                <td></td>                <td></td>                <td></td>                <td></td>                <td></td>                <td>รวมมูลค่า</td>                <td > ฿<?= number_format($totalPrice,2)?></td>                <td></td>            </tr>        </tfoot>    </table></div><?=\appxq\sdii\widgets\ModalForm::widget([    'id' => 'modal-bill-items',    'options' => ['tabindex' => false],    'size' => 'modal-lg',//         'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]]);?><?php \richardfan\widget\JSRegister::begin();?><script>    TableExport(document.getElementsByTagName("table"), {        headers: true,                              // (Boolean), display table headers (th or td elements) in the <thead>, (default: true)        footers: true,                              // (Boolean), display table footers (th or td elements) in the <tfoot>, (default: false)        formats: ['xlsx'],             // (String[]), filetype(s) for the export, (default: ['xls', 'csv', 'txt'])        filename: 'id',                             // (id, String), filename for the downloaded file, (default: 'id')        bootstrap: true,                           // (Boolean), style buttons using bootstrap, (default: true)        exportButtons: true,                        // (Boolean), automatically generate the built-in export buttons for each of the specified formats (default: true)        position: 'bottom',                         // (top, bottom), position of the caption element relative to table, (default: 'bottom')        ignoreRows: null,                           // (Number, Number[]), row indices to exclude from the exported file(s) (default: null)        ignoreCols: null,                           // (Number, Number[]), column indices to exclude from the exported file(s) (default: null)        trimWhitespace: true                        // (Boolean), remove all leading/trailing newlines, spaces, and tabs from cell text in the exported file(s) (default: false)    });    $(".bill-items").on('click', function () {        let url = $(this).attr('href');        modalBillItem(url);        return false;    });    function modalBillItem(url) {        $('.modal').css('overflow', 'scroll');        $('#modal-bill-items .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');        $('#modal-bill-items').modal('show')            .find('.modal-content')            .load(url);    }</script><?php \richardfan\widget\JSRegister::end();?>