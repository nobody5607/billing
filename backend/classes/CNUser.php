<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\classes;

use backend\models\Customers;
use backend\models\UserSippings;

/**
 * Description of CNUser
 *
 * @author chanpan
 */
class CNUser {
    /**
     * 
     * @return type user id current user login
     */
  public static function get_id(){
      return isset(\Yii::$app->user->id)?\Yii::$app->user->id:'1';
  }
  public static function get_name(){
      $id = self::get_id();
      $user = self::get_user_by_id($id);
//      \appxq\sdii\utils\VarDumper::dump($user['name']);
      if($user){
          return $user['name'];
      }
      
  }
  public static function get_branch(){
      return \Yii::$app->user->identity->branch;
  }
  /**
   * 
   * @param type $user_id | integer user id
   * @return data user
   */
  public static function get_user_by_id($user_id){
     try{
          $data = (new \yii\db\Query())->select('*')->from('user')->where(['id' => $user_id])->one();
          return $data;
        } catch (Exception $ex) {
            return false;
     }
  }

  public static function getUserShippingById($user_id){
      $userShipping = UserSippings::find()->where('bill_id = :bill_id AND type=99 AND rstat not in(0,3)',[
          ':bill_id' => $user_id
      ])->all();
  }


  
}
