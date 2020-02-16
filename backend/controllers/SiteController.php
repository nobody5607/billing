<?php
namespace backend\controllers;

use appxq\sdii\utils\SDdate;
use appxq\sdii\utils\VarDumper;
use appxq\sdii\widgets\SDExcel;
use backend\models\SellBill;
use backend\models\SellItems;
use cpn\chanpan\classes\CNMessage;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use kartik\mpdf\Pdf;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','about','contact','edit','report','backup-database'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
         //return $this->redirect(['/bill-items']);
         return $this->render('index');
 
    }
    public function actionAbout()
    {
        return $this->render('about');
 
    }
    public function actionContact()
    {
        return $this->render('contact');
 
    }
    
    public function actionEdit()
    {
       $params = \Yii::$app->request->get('params', '');
       $model = \common\models\Options::find()->where('label=:label',[
           ':label'=>$params
       ])->one();
       if($model->load(Yii::$app->request->post()) && $model->save()){
           return \cpn\chanpan\classes\CNMessage::getSuccess('Success');
       }
       return $this->renderAjax('edit',[
           'model'=>$model,
           'params'=>$params
       ]);
 
    } 
    public function actionReport()
    {
        $year = Yii::$app->request->get('year','');
        //VarDumper::dump($year);
        if($year == ''){
            $year = date('Y');
//            VarDumper::dump($year);
        }
        $stdate = "{$year}-01-01";
        $endate = "{$year}-12-31";

        $sql= "select 
                (SELECT count(*) FROM bill_items WHERE bill_date between '{$year}-01-01' AND '{$year}-01-31') as m1,
                (SELECT count(*) FROM bill_items WHERE bill_date between '{$year}-02-01' AND '{$year}-02-31') as m2,
                (SELECT count(*) FROM bill_items WHERE bill_date between '{$year}-03-01' AND '{$year}-03-31') as m3,
                (SELECT count(*) FROM bill_items WHERE bill_date between '{$year}-04-01' AND '{$year}-04-31') as m4,
                (SELECT count(*) FROM bill_items WHERE bill_date between '{$year}-05-01' AND '{$year}-05-31') as m5,
                (SELECT count(*) FROM bill_items WHERE bill_date between '{$year}-06-01' AND '{$year}-06-31') as m6,
                (SELECT count(*) FROM bill_items WHERE bill_date between '{$year}-07-01' AND '{$year}-07-31') as m7,
                (SELECT count(*) FROM bill_items WHERE bill_date between '{$year}-08-01' AND '{$year}-08-31') as m8,
                (SELECT count(*) FROM bill_items WHERE bill_date between '{$year}-09-01' AND '{$year}-09-31') as m9,
                (SELECT count(*) FROM bill_items WHERE bill_date between '{$year}-10-01' AND '{$year}-10-31') as m10,
                (SELECT count(*) FROM bill_items WHERE bill_date between '{$year}-11-01' AND '{$year}-11-31') as m11,
                (SELECT count(*) FROM bill_items WHERE bill_date between '{$year}-12-01' AND '{$year}-12-31') as m12
            from bill_items WHERE bill_date between :stdate AND :endate";
        $params=[':stdate'=>$stdate, ':endate'=>$endate];
        $data = Yii::$app->db->createCommand($sql, $params)->queryOne();

        $backgroundColor = ['rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)'
            ];
        $borderColor = [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
        ];
        $year = (int)$year+543;
        $output =[
            "title"=>" รายงานบิลปี {$year}",
            "labels"=>array_values(SDdate::$thaimonth),
            "data"=>($data)?array_values($data):[],
            "backgroundColor"=>$backgroundColor,
            "borderColor"=>$borderColor
        ];



        return CNMessage::getSuccess("success", $output);

    }


    public function actionBackupDatabase(){

        $filename='database_backup_'.date('dmY_His').'.sql';
        $sql = isset(Yii::$app->params['sql_backup'])?Yii::$app->params['sql_backup']:'';//"";
        exec($sql.$filename,$output);
        $backup_path = isset(Yii::$app->params['backup_path'])?Yii::$app->params['backup_path']:'';
//        VarDumper::dump($backup_path);
        exec($backup_path, $output2);
        return $this->render("backup-database",[
            'output'=>$output2
        ]);
    }

 
}
