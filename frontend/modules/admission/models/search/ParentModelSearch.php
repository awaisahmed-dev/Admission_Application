<?php

namespace frontend\modules\admission\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\admission\models\ParentModel;

/**
 * ParentModelSearch represents the model behind the search form of `frontend\modules\admission\models\ParentModel`.
 */
class ParentModelSearch extends ParentModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['father_title', 'father_first_name', 'father_last_name', 'father_mobile', 'father_email', 'mother_title', 'mother_first_name', 'mother_last_name', 'mother_mobile', 'mother_email', 'address', 'home_phone', 'emergency_contact_name', 'emergency_contact_number', 'emergency_relationship'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = ParentModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'father_title', $this->father_title])
            ->andFilterWhere(['like', 'father_first_name', $this->father_first_name])
            ->andFilterWhere(['like', 'father_last_name', $this->father_last_name])
            ->andFilterWhere(['like', 'father_mobile', $this->father_mobile])
            ->andFilterWhere(['like', 'father_email', $this->father_email])
            ->andFilterWhere(['like', 'mother_title', $this->mother_title])
            ->andFilterWhere(['like', 'mother_first_name', $this->mother_first_name])
            ->andFilterWhere(['like', 'mother_last_name', $this->mother_last_name])
            ->andFilterWhere(['like', 'mother_mobile', $this->mother_mobile])
            ->andFilterWhere(['like', 'mother_email', $this->mother_email])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'home_phone', $this->home_phone])
            ->andFilterWhere(['like', 'emergency_contact_name', $this->emergency_contact_name])
            ->andFilterWhere(['like', 'emergency_contact_number', $this->emergency_contact_number])
            ->andFilterWhere(['like', 'emergency_relationship', $this->emergency_relationship]);

        return $dataProvider;
    }
}
