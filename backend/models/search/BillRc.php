<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BillRc as BillRcModel;

/**
 * BillRc represents the model behind the search form about `backend\models\BillRc`.
 */
class BillRc extends BillRcModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'rstat', 'create_by', 'update_by'], 'integer'],
            [['billdate', 'billref', 'customer_id', 'customer_name', 'amount', 'balance', 'pamount', 'bill_date', 'doc_num', 'cashier', 'create_date', 'update_date'], 'safe'],
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
        $query = BillRcModel::find()->where('rstat not in(0,3)');

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
            'billdate' => $this->billdate,
            'bill_date' => $this->bill_date,
            'rstat' => $this->rstat,
            'create_by' => $this->create_by,
            'create_date' => $this->create_date,
            'update_by' => $this->update_by,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['like', 'billref', $this->billref])
            ->andFilterWhere(['like', 'customer_id', $this->customer_id])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'amount', $this->amount])
            ->andFilterWhere(['like', 'balance', $this->balance])
            ->andFilterWhere(['like', 'pamount', $this->pamount])
            ->andFilterWhere(['like', 'doc_num', $this->doc_num])
            ->andFilterWhere(['like', 'cashier', $this->cashier]);

        return $dataProvider;
    }
}
