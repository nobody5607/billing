<?phpuse appxq\sdii\helpers\SDHtml;use yii\helpers\Html;use yii\helpers\Url;?><div class="col-md-12" id="navbars">    <div class="kt-section">        <div class="kt-section__info"><label><h3>อัปโหลดรายการสินค้า:</h3></label></div>        <div class="kt-section__content kt-section__content--solid kt-border-success kt-bg-light">            <form id="fupForm" enctype="multipart/form-data">                <div class="statusMsg"></div>                <div class="loadding text-center" style="display: none;">                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>                    <div style="margin-top:5px">กำลังโหลดข้อมูลกรุณารอสักครู่...</div>                </div>                <div class="row">                    <div class="col-md-12 text-right">                        <input id="exfile" name="exfile" type="file"                               accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">                        <div style="color: red;text-align: left;margin-top: 10px;">                            * หมายเหตุ อัปโหลดได้เฉพาะไฟล์ excel ถ้าไฟล์ใหญ่เกิน 2 MB อาจจะใช้เวลาในการโหลดข้อมูลนาน คำแนะนำน ั่งจิบกาแฟ หรือ ดูหนังรอครับ                        </div>                    </div>                    <div class="col-md-12" style="margin-top:10px;">                        <button class="btn btn-success" id="btnUploadFile"><i class="fa fa-upload"></i>                            อัปโหลดรายการสินค้า                        </button>                    </div>                </div>            </form>        </div>        <?php \richardfan\widget\JSRegister::begin(); ?>        <script>            var selectFile = 0;            $("#exfile").change(function () {                selectFile = 1;                var file = this.files[0];                var fileType = file.type;                var match = ['.csv', 'application/msword', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];                if (!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType == match[3]) || (fileType == match[4]) || (fileType == match[5]))) {                    alert('Sorry, only xlsx files are allowed to upload.');                    $("#file").val('');                    return false;                }            });            $('#fupForm').on('submit', function (e) {                if(selectFile == 0){                    alert('กรุณาเลือกไฟล์');return false;                }                $(".loadding").show();                let url = '<?= \yii\helpers\Url::to(['/product-list/upload']) ?>';                e.preventDefault();                $.ajax({                    type: 'POST',                    url: url,                    data: new FormData(this),                    dataType: 'json',                    contentType: false,                    cache: false,                    processData: false,                    beforeSend: function () {                        $('#btnUploadFile').attr("disabled",true);                        //$('#fupForm').css("opacity",".5");                    },                    success: function (response) {                        selectFile = 1;                        $(".loadding").hide();                        $('#btnUploadFile').attr("disabled",false);                        $('.statusMsg').html('');                        if (response.status == 'success') {                            $('#fupForm')[0].reset();                            $('.statusMsg').html('<p class="alert alert-success">' + response.message + '</p>');                            getProductList();                        } else {                            $('.statusMsg').html('<p class="alert alert-danger">' + response.message + '</p>');                        }                    },error: function (jqXHR, exception) {                        $(".loadding").hide();                        $('#btnUploadFile').attr("disabled",false);                        // Your error handling logic here..                    }                });            });        </script>        <?php \richardfan\widget\JSRegister::end(); ?>    </div></div>