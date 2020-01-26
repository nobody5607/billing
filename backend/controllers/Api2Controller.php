<?php
namespace backend\controllers;
use backend\models\BillItems;
use cpn\chanpan\classes\CNMessage;
use Yii;
use yii\web\Controller;

class Api2Controller extends Controller
{

    public function actionIndex()
    {
        $output = [];
        $sqlStatusBill = "
            SELECT 
             (select count(*) FROM bill_items WHERE rstat not in(3) AND billref not like '%POS%') as allbill,
             (select count(*) FROM bill_items WHERE  status=1 and rstat not in(0,3) AND billref not like '%POS%') as normalbill,
             (select count(*) FROM bill_items WHERE  (status=2 or status=5) and rstat not in(0,3) AND billref not like '%POS%') as damagedbill,
             (select count(*) FROM bill_items WHERE  (status=3 or status=4) and rstat not in(0,3) AND billref not like '%POS%') as cancelbill,
             (select count(*) FROM bill_items WHERE  rstat in(0)) as closebill
            FROM bill_items WHERE rstat not in(3)
        ";
        $statusBill = Yii::$app->db->createCommand($sqlStatusBill)->queryOne();
        $output['stbill'] = $statusBill;


        $sqlStatusShippingSql = "
            SELECT 
             (select count(*) FROM bill_items WHERE  (shiping=1) and rstat not in(0,2,3) AND billref not like '%POS%') as nopackagepro,
             (select count(*) FROM bill_items WHERE  (shiping=2) and rstat not in(0,2,3) AND billref not like '%POS%') as packagepro,
             (select count(*) FROM bill_items WHERE  (shiping=3) and rstat not in(0,2,3) AND billref not like '%POS%') as shippingpro,
             (select count(*) FROM bill_items WHERE  (shiping=7) and rstat not in(0,2,3) AND billref not like '%POS%') as cancelpro             
             FROM bill_items WHERE rstat not in(0,2,3)
        ";
        $statusShipping = Yii::$app->db->createCommand($sqlStatusShippingSql)->queryOne();
        $output['dlystatus'] = $statusShipping;


        $billTypeSql = "
            SELECT 
             (select count(*) FROM bill_items WHERE  (bill_type=15) and rstat not in(0,2,3)  AND billref not like '%POS%') as othor,
             (select count(*) FROM bill_items WHERE  (bill_type=1) and rstat not in(0,2,3)  AND billref not like '%POS%') as cr,
             (select count(*) FROM bill_items WHERE  (bill_type=11) and rstat not in(0,2,3)  AND billref not like '%POS%') as crv,
             (select count(*) FROM bill_items WHERE  (bill_type=12) and rstat not in(0,2,3)  AND billref not like '%POS%') as jcr,
             (select count(*) FROM bill_items WHERE  (bill_type=13) and rstat not in(0,2,3)  AND billref not like '%POS%') as jcrv,     
             (select count(*) FROM bill_items WHERE   rstat not in(0,3)  AND billref like '%POS%') as pos 
             FROM bill_items WHERE rstat not in(0,2,3)
        ";
        $billType = Yii::$app->db->createCommand($billTypeSql)->queryOne();
        $output['billtype'] = $billType;


        return CNMessage::getSuccess("Success", $output);
    }

}
