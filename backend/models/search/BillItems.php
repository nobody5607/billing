<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BillItems as BillItemsModel;

/**
 * BillItems represents the model behind the search form about `backend\models\BillItems`.
 */
class BillItems extends BillItemsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'billno', 'shop_id', 'btype', 'status', 'shiping', 'charge'], 'integer'],
            [['bookno', 'billref', 'amount', 'bill_upload', 'remark','bill_type'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = BillItemsModel::find()->where('rstat not in(0,3)')->orderBy(['id'=>SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'billno' => $this->billno,
            'shop_id' => $this->shop_id,
            'btype' => $this->btype,
            'status' => $this->status,
            //'shiping' => $this->shiping,
            'charge' => $this->charge,
            'bill_type'=>$this->bill_type
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
