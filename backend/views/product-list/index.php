<?php    //\appxq\sdii\utils\VarDumper::dump($output);use appxq\sdii\widgets\ModalForm; ?><div class="row">    <div class="col-md-12">        <br/>        <?= \backend\classes\BillManager::renderBillDetail()?>        <?=        ModalForm::widget([            'id' => 'modal-user-shipping',            'options' => ['tabindex' => false],        ]);        ?>        <div class="row">            <div class="col-md-12">                <h4 class="kt-portlet__head-title">                    <i class="fa fa-truck"></i> จัดการรถ                    <?php if (Yii::$app->user->can('manage_user_percent')): ?>                        <button class="btn btn-sm btn-outline-success btn-add-user-shipping">                            <i class="fa fa-plus"></i> เพิ่มคนขับ                        </button>                    <?php endif; ?>                </h4>                 <div id="preview-user-shipping"></div>                 <?php \richardfan\widget\JSRegister::begin(); ?>                 <script>                     $(".btn-add-user-shipping").on('click',function () {                         let url = '<?= \yii\helpers\Url::to(['/product-list/add-driver?type=1']); ?>';                         modalUserShipping(url);                         return false;                     });                     function modalUserShipping(url) {                         $('.modal').css('overflow', 'scroll');                         $('#modal-user-shipping .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');                         $('#modal-user-shipping').modal('show')                                 .find('.modal-content')                                 .load(url);                     }                     function initPreviewUserShipping() {                         let url = '<?= \yii\helpers\Url::to(['/product-list/init-preview-user-shipping']) ?>';                         $.get(url, function (result) {                             $("#preview-user-shipping").html(result);                         });                     }                     initPreviewUserShipping();                 </script>                 <?php \richardfan\widget\JSRegister::end(); ?>                </div>                         <div class="col-md-12">                <h4 class="kt-portlet__head-title"><i class="fa fa-money"></i> อัตราค่าตอบแทนของคนขับรถและลูกน้อง                    <?php if(Yii::$app->user->can('manage_user_percent')):?>                    <?= \yii\helpers\Html::button(\appxq\sdii\helpers\SDHtml::getBtnAdd(), ['data-url'=> \yii\helpers\Url::to(['user-percent/create']), 'class' => 'btn btn-sm btn-outline-success', 'id'=>'modal-addbtn-user-percent']). ' ';                    ?>                    <?php endif; ?>                </h4>                <div id="preview-user-percent"></div>                <?php \richardfan\widget\JSRegister::begin(); ?>                <script>                    function initUserPercent(){                        let url = '<?= \yii\helpers\Url::to(['/user-percent']) ?>';                        $.get(url, function (result) {                            $("#preview-user-percent").html(result);                        });                    }                    initUserPercent();                </script>                <?php \richardfan\widget\JSRegister::end(); ?>            </div>        </div>                <div class="row">            <div class="col-md-6 col-xs-6">                <div class="kt-section" >                    <div class="kt-section__primary"><label>ค่า Commission ที่จะได้รับ:</label></div>                    <div class="kt-section__content kt-section__content--solid kt-border-warning" style="background-color: #5cb85c;color:#fff;">                        <div id="preview-user-cal"></div>                        <?php \richardfan\widget\JSRegister::begin(); ?>                        <script>                            function initUserCal(){                                let url = '<?= \yii\helpers\Url::to(['/product-list/cal-percent']) ?>';                                $.get(url,function (result) {                                    $("#preview-user-cal").html(result);                                });                                return false;                            }                            initUserCal();                        </script>                        <?php \richardfan\widget\JSRegister::end(); ?>                    </div>                 </div>            </div>        </div>                     <div id="showProductList"></div>         <?php \richardfan\widget\JSRegister::begin(); ?>        <script>            function getProductList(){                $("#showProductList").html("<h3 class='text-center'>Loadding...</h3>");                let url = '<?= yii\helpers\Url::to(['/product-list/data'])?>';                let bill_id = '<?= $bill_id; ?>';                $.get(url, {bill_id:bill_id},function(res){                    $("#showProductList").html(res);                });                return false;            }            getProductList();        </script>         <?php \richardfan\widget\JSRegister::end(); ?>                     </div></div><?php \appxq\sdii\widgets\CSSRegister::begin()?><style>    table{        border-collapse: collapse;    }    table, th, td {        border: 1px solid black;    }</style><?php \appxq\sdii\widgets\CSSRegister::end()?>