<?php

namespace backend\modules\commitment\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\commitment\models\CommitmentModel;

/**
 * CommitmentModelSearch represents the model behind the search form about `backend\modules\commitment\models\CommitmentModel`.
 */
class CommitmentModelSearch extends CommitmentModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['amount'], 'number'],
            [['payment_plan', 'date', 'due_date', 'details'], 'safe'],
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
        $query = CommitmentModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'amount' => $this->amount,
            'date' => $this->date,
            'due_date' => $this->due_date,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'payment_plan', $this->payment_plan])
            ->andFilterWhere(['like', 'details', $this->details]);

        return $dataProvider;
    }
}
