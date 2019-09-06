<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\classes;

/**
 * Description of KNUser
 *
 * @author chanpan
 */
class KNUser {
    /**
     * 
     * @param type $id
     * @return boolean
     */
    public static function getUserByIdAsSelect2($id) {
        try {
            $sql = "
                      SELECT u.id, u.username, p.name FROM user as u 
                      INNER JOIN profile as p ON u.id = p.user_id WHERE u.id = :id
                    ";
            $init_data = \Yii::$app->db->createCommand($sql, [':id' => $id])->queryOne();
            return $init_data;
        } catch (\yii\db\Exception $ex) {
            return false;
        }
    }
    public static function getUserId() {
        return isset(\Yii::$app->user->id)?\Yii::$app->user->id:'';
    }

}
