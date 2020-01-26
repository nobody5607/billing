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
             (select count(*) FROM bill_items WHERE not like '%POS%' AND rstat not in(3)) as allbill,
             (select count(*) FROM bill_items WHERE not like '%POS%' AND   status=1 and rstat not in(0,3)) as normalbill,
             (select count(*) FROM bill_items WHERE not like '%POS%' AND  (status=2 or status=5) and rstat not in(0,3)) as damagedbill,
             (select count(*) FROM bill_items WHERE not like '%POS%' AND   (status=3 or status=4) and rstat not in(0,3)) as cancelbill,
             (select count(*) FROM bill_items WHERE not like '%POS%' AND   rstat in(0)) as closebill
            FROM bill_items WHERE rstat not in(3)
        ";
        $statusBill = Yii::$app->db->createCommand($sqlStatusBill)->queryOne();
        $output['stbill'] = $statusBill;


        $sqlStatusShippingSql = "
            SELECT 
             (select count(*) FROM bill_items WHERE not like '%POS%' AND   (shiping=1) and rstat not in(0,2,3)) as nopackagepro,
             (select count(*) FROM bill_items WHERE not like '%POS%' AND   (shiping=2) and rstat not in(0,2,3)) as packagepro,
             (select count(*) FROM bill_items WHERE not like '%POS%' AND   (shiping=3) and rstat not in(0,2,3)) as shippingpro,
             (select count(*) FROM bill_items WHERE not like '%POS%' AND   (shiping=7) and rstat not in(0,2,3)) as cancelpro             
             FROM bill_items WHERE rstat not in(0,2,3)
        ";
        $statusShipping = Yii::$app->db->createCommand($sqlStatusShippingSql)->queryOne();
        $output['dlystatus'] = $statusShipping;


        $billTypeSql = "
            SELECT 
             (select count(*) FROM bill_items WHERE not like '%POS%' AND   (bill_type=15) and rstat not in(0,2,3)) as othor,
             (select count(*) FROM bill_items WHERE not like '%POS%' AND   (bill_type=1) and rstat not in(0,2,3)) as cr,
             (select count(*) FROM bill_items WHERE not like '%POS%' AND   (bill_type=11) and rstat not in(0,2,3)) as crv,
             (select count(*) FROM bill_items WHERE not like '%POS%' AND   (bill_type=12) and rstat not in(0,2,3)) as jcr,
             (select count(*) FROM bill_items WHERE not like '%POS%' AND   (bill_type=13) and rstat not in(0,2,3)) as jcrv                 
             FROM bill_items WHERE rstat not in(0,2,3)
        ";
        $billType = Yii::$app->db->createCommand($billTypeSql)->queryOne();
        $output['billtype'] = $billType;


        return CNMessage::getSuccess("Success", $output);
    }

}
