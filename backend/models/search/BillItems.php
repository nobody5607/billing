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
        //VarDumper::dump($params);
        $query = BillItemsModel::find()
            ->where('rstat not in(0,3)')
            ->orderBy(['billno'=>SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'billno' => $this->billno,
            'shop_id' => $this->shop_id,
            'btype' => $this->btype,
            'status' => $this->status,
            'charge' => $this->charge,
            'bill_type'=>$this->bill_type,
            'bill_date'=>$this->bill_date
        ]);

        $query->andFilterWhere(['like', 'bookno', $this->bookno])
            ->andFilterWhere(['like', 'billref', $this->billref])
            ->andFilterWhere(['like', 'amount', $this->amount])
            ->andFilterWhere(['like', 'bill_upload', $this->bill_upload])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'shiping', $this->shiping]);

        return $dataProvider;
    }
}
