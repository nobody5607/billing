<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BillShippings as BillShippingsModel;

/**
 * BillShippings represents the model behind the search form about `backend\models\BillShippings`.
 */
class BillShippings extends BillShippingsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bill_id',], 'integer'],
            [['file_upload', 'remark', 'user_id'], 'safe'],
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
        $query = BillShippingsModel::find();
        $query->joinWith(['users u']);
        $query->joinWith(['profiles p']);
        
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
            'bill_id' => $this->bill_id,
            //'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'file_upload', $this->file_upload])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'p.name', $this->user_id]);
        return $dataProvider;
    }
}
