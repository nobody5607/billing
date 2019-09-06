<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Customers as CustomersModel;

/**
 * Customers represents the model behind the search form about `backend\models\Customers`.
 */
class Customers extends CustomersModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['c_id', 'name', 'tel','type'], 'safe'],
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
        $query = CustomersModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'type'=>$this->type
        ]);

        $query->andFilterWhere(['like', 'c_id', $this->c_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'tel', $this->tel]);

        return $dataProvider;
    }
}
