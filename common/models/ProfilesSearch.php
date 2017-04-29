<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use webdoka\yiiecommerce\common\models\Profiles;

/**
 * ProfilesSearch represents the model behind the search form about `webdoka\yiiecommerce\common\models\Profiles`.
 */
class ProfilesSearch extends Profiles
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'default_account_id', 'status'], 'integer'],
            [['type', 'profile_name', 'name', 'last_name', 'ur_name', 'legal_adress', 'country', 'region', 'city', 'individual_adress', 'inn', 'phone'], 'safe'],
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
        $query = Profiles::find();

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
            'user_id' => $this->user_id,
            'default_account_id' => $this->default_account_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'profile_name', $this->name])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'ur_name', $this->ur_name])
            ->andFilterWhere(['like', 'legal_adress', $this->legal_adress])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'individual_adress', $this->individual_adress])
            ->andFilterWhere(['like', 'inn', $this->inn])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
