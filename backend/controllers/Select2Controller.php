<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\controllers;

class Select2Controller extends \yii\web\Controller{
    public function beforeAction($action)
    {
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      return parent::beforeAction($action);
    }
    public function actionBillShop($q = '', $id = ''){
        try {
            $out = ['results' => ['id' => '', 'text' => '']];
            if ($id == null) {
                $data_all = \backend\models\BillShop::find()
                                ->select(['id', 'name'])
                                ->where('name LIKE :name', [":name" => "%{$q}%"])
                                ->limit(50)->all();
                $data = [];
                foreach ($data_all as $k => $c) {
                    $data[$k] = ['id' => $c['id'], 'text' => $c['name']];
                }
                $out['results'] = array_values($data);
            } else {
                $data_one = \backend\models\BillShop::findOne($id);
                $out = ['id' => $data_one['id'], 'text' => $data_one['name']];
            }
            return $out;
        } catch (\yii\db\Exception $ex) {
            return false;
        }
    }
    public function actionGetUser($q = '', $id = ''){
        try {
            $out = ['results' => ['id' => '', 'text' => '']];
            if ($id == null) {
                $sql="
                  SELECT u.id, u.username, p.name FROM user as u 
                  INNER JOIN profile as p ON u.id = p.user_id WHERE p.name LIKE :name  OR u.username LIKE :username
                ";
                $data_all = \Yii::$app->db->createCommand($sql,[':name'=>"%{$q}%", ':username'=>"%{$q}%"])->queryAll();
                 
                $data = [];
                foreach ($data_all as $k => $c) {
                    $data[$k] = ['id' => $c['id'], 'text' => ($c['name'] != '')?$c['name']:$c['username']];
                }
                $out['results'] = array_values($data);
            } else {
                $sql="
                  SELECT u.id, u.username, p.name FROM user as u 
                  INNER JOIN profile as p ON u.id = p.user_id WHERE u.id = :id
                ";
                $data_all = \Yii::$app->db->createCommand($sql,[':id'=>$id])->queryOne();
                $out = ['id' => $data_one['id'], 'text' => $data_one['name']];
            }
            return $out;
        } catch (\yii\db\Exception $ex) {
            return false;
        }
    }

    public function actionBillType($q = '', $id = ''){
        try {
            $type = \Yii::$app->request->get('type'); 
            $out = ['results' => ['id' => '', 'text' => '']];
            if ($id == null) {
                $data_all = \backend\models\BillType::find()
                                ->select(['id', 'name'])
                                ->where('name LIKE :name AND type=:type', [":name" => "%{$q}%", ':type'=>$type])
                                ->limit(50)->orderby(['id'=>SORT_DESC])->all();
                $data = [];
                foreach ($data_all as $k => $c) {
                    $data[$k] = ['id' => $c['id'], 'text' => $c['name']];
                }
                $out['results'] = array_values($data);
            } else {
                $data_one = \backend\models\BillType::findOne($id);
                $out = ['id' => $data_one['id'], 'text' => $data_one['name']];
            }
            return $out;
        } catch (\yii\db\Exception $ex) {
            return false;
        }
    }

}
