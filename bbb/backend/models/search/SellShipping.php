<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SellShipping as SellShippingModel;

/**
 * SellShipping represents the model behind the search form about `backend\models\SellShipping`.
 */
class SellShipping extends SellShippingModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groupcond', 'groupname', 'percent'], 'safe'],
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
        $query = SellShippingModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'groupcond', $this->groupcond])
            ->andFilterWhere(['like', 'groupname', $this->groupname])
            ->andFilterWhere(['like', 'percent', $this->percent]);

        return $dataProvider;
    }
}
