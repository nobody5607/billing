<?php

namespace backend\components;

use Yii;
use yii\base\Component;
use yii\web\UnauthorizedHttpException;
use yii\base\Exception;

class AppComponent extends Component {
    
    public function init() {
        parent::init(); 
        $params = \backend\modules\core\classes\CoreQuery::getOptionsParams();
        \Yii::$app->params = \yii\helpers\ArrayHelper::merge(\Yii::$app->params, $params);
        Yii::setAlias('@storageUrl',  \Yii::$app->params['storageUrl']);
        //\appxq\sdii\utils\VarDumper::dump($params);
        
       if(isset(Yii::$app->params['commandUpdate']) && Yii::$app->params['commandUpdate'] == 1){
          self::commandUpdate();
       }//command update
      
    }
    //command update
    public static function commandUpdate(){
        try{
            $model = \backend\models\Dbupdate::find()
                    ->where('rstat not in(0,3) AND status = 0')->orderBy(['id'=>SORT_ASC])->all();
            if($model){
                foreach($model as $k=>$v){ 
                    $sql= $v['sql'];
                    try{
                        \Yii::$app->db->createCommand($sql)->execute();
                        $v->status = 1;
                        $v->update();
                    } catch (Exception $ex) {
                        \appxq\sdii\utils\VarDumper::dump($ex);
                        //Log
                    }
                }
            }
        } catch (Exception $ex) {
            //Log
        }
        
    }

    public static function navbarLeft() {
        $moduleId = (isset(Yii::$app->controller->module->id) && Yii::$app->controller->module->id != 'app-backend') ? Yii::$app->controller->module->id : '';
        $controllerId = isset(Yii::$app->controller->id) ? Yii::$app->controller->id : '';
        $actionId = isset(Yii::$app->controller->action->id) ? Yii::$app->controller->action->id : '';
        $viewId = \Yii::$app->request->get('id', '');
         
        $navbar = [

                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => \Yii::t('bill','Dashboard'), 'icon' => 'tachometer', 'url' => ['/site/index'] ],

//                    ['label' => \Yii::t('bill','จัดการบิล'), 'icon' => 'database', 'url' => ['/bill-items'],
//                    'visible' => (\Yii::$app->user->can('previewBill'))?true:false],
                    [
                        'label' => Yii::t('appmenu', 'จัดการบิล'),
                        'visible' => \Yii::$app->user->can('previewBill'),
                        'icon' => 'database',
                        'url' => '#',
                        'items' => [
                            ['label' => 'บิลทั้งหมด','icon' => ' ', 'url' => ['/bill-items'],'visible' => \Yii::$app->user->can('previewBill')],
                            ['label' => 'ห้ามแก้ไข','icon' => ' ', 'url' => ['/bill-items?rstat=2'],'visible' => \Yii::$app->user->can('previewBill')],
                            ['label' => 'ปิดบิล','icon' => ' ', 'url' => ['/bill-items?rstat=0'],'visible' => \Yii::$app->user->can('previewBill')],
                            ['label' => 'อัปโหลดสินค้า','icon' => ' ', 'url' => ['/bill-items/bill-upload'],'visible' => \Yii::$app->user->can('previewBill')],
                            ['label' => 'อัปโหลดบิลรับชำระ','icon' => ' ', 'url' => ['/bill-items/bill-upload-rc'],'visible' => \Yii::$app->user->can('previewBill')],
                            ['label' => 'บิลชำระ','icon' => ' ', 'url' => ['/bill-items/bill-rc'],'visible' => \Yii::$app->user->can('previewBill')],
                        ],
                    ],

                    [
                        'label' => Yii::t('appmenu', 'รายงาน'),
                        'visible' => \Yii::$app->user->can('report'),
                        'icon' => 'file',
                        'url' => '#',
                        'items' => [
                            ['label' => 'รายงาน',     'icon' => ' ', 'url' => ['/report/index'],'visible' => \Yii::$app->user->can('report')],
                            ['label' => 'อัปโหลดรายการสินค้า',     'icon' => ' ', 'url' => ['/report/bill-items'],'visible' => \Yii::$app->user->can('report')],
                            ['label' => 'อัปโหลดบิลตามสินค้า',     'icon' => ' ', 'url' => ['/report/sell-bill'],'visible' => \Yii::$app->user->can('report')],
                            ['label' => 'พนักงานส่งของ',     'icon' => ' ', 'url' => ['/report/customer-car'],'visible' => \Yii::$app->user->can('report')],
                            ['label' => 'พนักงานจัดของ',     'icon' => ' ', 'url' => ['/report/customer-package'],'visible' => \Yii::$app->user->can('report')],
                            ['label' => 'รายงานตามกล่อง',     'icon' => ' ', 'url' => ['/report/block'],'visible' => \Yii::$app->user->can('report')],

                        ],
                    ],
                    [
                        'label' => Yii::t('appmenu','จัดการพนักงาน'), 
                        'icon' => 'users', 'url' => ['/user/admin/index'],
                        'visible' => \Yii::$app->user->can('admin')
                    ],
//                    ['label' => \Yii::t('appmenu','Home'), 'icon' => 'home', 'url' => ['/']],
                    ['label' => \Yii::t('appmenu','About'), 'icon' => 'info-circle', 'url' => ['/site/about']],
                    ['label' => \Yii::t('appmenu','Contact'), 'icon' => 'phone-square', 'url' => ['/site/contact']],
                    ['label' => \Yii::t('bill','จัดการพนักงานขับรถ'), 'icon' => 'user', 'url' => ['/customer'],'visible' => \Yii::$app->user->can('sell_shipping')],//sell-shipping

                    [
                        'label' => Yii::t('appmenu', 'System Config'),
                        'visible' => \Yii::$app->user->can('admin'),
                        'icon' => 'cog',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => Yii::t('appmenu', 'ตั้งค่าทั่วไป'),
                                'active'=>($moduleId == 'admin'),
                                'icon' => ' ',
                                'url' => '#',
                                'items' => [
                                    //Assignments
                                    ['label' => Yii::t('appmenu', 'คะแนนจิตวิพิสัย'), 'icon' => ' ', 'url' => ['/affective-score/index']],
                                    ['label' => Yii::t('appmenu', 'จัดการความยาก'), 'icon' => ' ', 'url' => ['/difficultys/index']],
                                    ['label' => Yii::t('appmenu', 'Percent'), 'icon' => ' ', 'url' => ['/sell-shipping/index']],
                                    ['label' => Yii::t('appmenu', 'พนักงานขับรถ'), 'icon' => ' ', 'url' => ['/customer/index']],
                                    ['label' => Yii::t('appmenu', 'กลอง'), 'icon' => ' ', 'url' => ['/groups/index']],

                                    ['label' => Yii::t('appmenu', 'คลัง'), 'icon' => ' ', 'url' => ['/treasurys/index']],
                                    ['label' => Yii::t('appmenu', 'ที่เก็บ'), 'icon' => ' ', 'url' => ['/storages/index']],
                                    ['label' => Yii::t('appmenu', 'จัดการหมายเหตุ'), 'icon' => ' ', 'url' => ['/remarks/index']],
                                ],
                            ],
                            [
                                'label' => Yii::t('appmenu', 'Authentication'),
                                'active'=>($moduleId == 'admin'),
                                'icon' => ' ',
                                'url' => '#',
                                'items' => [
                                    //Assignments
                                    ['label' => Yii::t('appmenu', 'Assignments'), 'icon' => ' ', 'url' => ['/admin'],'active'=>($moduleId == 'admin' && $controllerId == 'assignment'),],
                                    ['label' => Yii::t('appmenu', 'Role'), 'icon' => ' ', 'url' => ['/admin/role'],'active'=>($moduleId == 'admin' && $controllerId == 'role')],
                                    ['label' => Yii::t('appmenu', 'Route'), 'icon' => ' ', 'url' => ['/admin/route'],'active'=>($moduleId == 'admin' && $controllerId == 'route')],
                                    ['label' => Yii::t('appmenu', 'Permission'), 'icon' => ' ', 'url' => ['/admin/permission'],'active'=>($moduleId == 'admin' && $controllerId == 'permission')],
                                ],
                            ],
                            [
                            'label' => Yii::t('appmenu', 'Tools'),
                            'icon' => ' ',
                            'url' => '#',
                            'items' => [
                                //options
                                ['label' => Yii::t('appmenu','Setting Config'),        'icon' => ' ', 'url' => ['/options'],],
                                ['label' => Yii::t('appmenu','System Log'),     'icon' => ' ', 'url' => ['/systemlog'],],
                                ['label' => Yii::t('appmenu','Skin'),           'icon' => ' ', 'url' => ['/skin'],],
                                ['label' => Yii::t('appmenu','Sql Update'),     'icon' => ' ', 'url' => ['/dbupdate'],],
                                ['label' => Yii::t('appmenu','Gii'),            'icon' => ' ', 'url' => ['/gii'],],
                                ['label' => Yii::t('appmenu','Debug'),          'icon' => ' ', 'url' => ['/debug'],]
                            ],
                        ],
                    ],
                    ],
                ],
            ];
        return $navbar;
    }
    public static function menuRight(){
        $fullName = \common\modules\user\classes\CNUserFunc::getFullName();
        $img = \common\modules\user\classes\CNUserFunc::getImagePath();
        $items = [            
            [
                'label' =>"<img src='{$img}' class='user-image'> ".$fullName,
                'visible' => !Yii::$app->user->isGuest,
                'items' => [
                     ['label' => '<i class="fa fa-user"></i> '.Yii::t('appmenu','User Profile'), 'url' => ['/user/settings/profile']],
                     '<li class="divider"></li>', 
                     ['label' => '<i class="fa fa-sign-out"></i> '.Yii::t('appmenu','Logout'), 'url' => ['/user/security/logout'], 'linkOptions' => ['data-method' => 'post']],
                ],
            ],
            ['label' => "<i class='fa fa-sign-in'></i> ".Yii::t('appmenu','Sign Up'), 'url' => ['/user/register'], 'visible' => Yii::$app->user->isGuest],
            ['label' => "<i class='fa fa-sign-in'></i> ".Yii::t('appmenu','Login'), 'url' => ['/user/login'], 'visible' => Yii::$app->user->isGuest],
        ];
        return $items;
    }
    public static function slideToggleLeft(){              
        return \yii\helpers\Html::a("", '#', [
            'class'=>'sidebar-toggle',
            'data-toggle'=>'push-menu',
            'role'=>'button',
            'id'=>'iconslideToggle'
        ]);
    }
    public static function slideToggleRight(){  
        return 
        
        \yii\helpers\Html::button("<i class='fa fa-th-large'></i>", [
            'class'=>'navbar-toggle',
            'data-toggle'=>'push-menu',
            'data-target'=>'#cnNavbar',
            
        ]);
         
    }
}
