<?php

namespace backend\models\search;

use appxq\sdii\utils\VarDumper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BillItems as BillItemsModel;

/**
 * BillItems represents the model behind the search form about `backend\models\BillItems`.
 */
class BillItems extends BillItemsModel
{
    public function rules()
    {
        return [
            [['id', 'billno', 'shop_id', 'btype', 'status', 'shiping', 'charge'], 'integer'],
            [['bookno', 'billref', 'amount', 'bill_upload', 'remark','bill_type','bill_date'], 'safe'],
        ];
    }
    public function scenarios()
    {

        return Model::scenarios();
    }
    public function search($params)
    {
         //VarDumper::dump($params); 00239
        $schema = BillItemsModel::find();
        if(isset($params['rstat'])){
            $query = $schema->where('rstat=:rstat',[':rstat' => $params['rstat']]);
        }else{
            $query = $schema->where('rstat not in(0,3)');
        }
        $query=$query->andWhere("billref NOT LIKE '%POS%'")->orderBy(['bill_date'=>SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' =>100,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        if($this->billref != ''){
            $query->andWhere("billref like :billref OR customer_id like :customer_id OR customer_name LIKE :customer_name OR amount like :amount",[
                ':billref'=>"%{$this->billref}%",
                ':customer_id'=>"%{$this->billref}%",
                ':customer_name'=>"%{$this->billref}%",
                ':amount'=>"%{$this->billref}%"
            ]);
        }
        if($this->status != ''){
            $query->andWhere("status=:status",[
                ':status'=>$this->status
            ]);
        }


//        $query->andFilterWhere([
//            'id' => $this->id,
//            'billno' => $this->billno,
//            'shop_id' => $this->shop_id,
//            'btype' => $this->btype,
//            'status' => $this->status,
//            'charge' => $this->charge,
//            'bill_type'=>$this->bill_type,
//            'bill_date'=>$this->bill_date
//        ]);
       // VarDumper::dump($this->billref);

        //$query->andFilterWhere(['like', 'bookno', $this->billref]);
            //->orFilterWhere(['like', 'billref', $this->billref]);
//            ->andFilterWhere(['like', 'amount', $this->amount])
//            ->andFilterWhere(['like', 'bill_upload', $this->bill_upload])
//            ->andFilterWhere(['like', 'remark', $this->remark])
//            ->andFilterWhere(['like', 'shiping', $this->shiping]);

        return $dataProvider;
    }
}
