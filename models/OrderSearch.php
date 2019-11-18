<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'partner_id'], 'integer'],
            [['client_email', 'delivery_dt', 'created_at', 'updated_at', 'partnerName'], 'safe'],
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
        $query = Order::find()->joinWith('partner');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 40,
            ],
        ]);

        $dataProvider->sort->attributes['partnerName'] = [
            'asc' => ['partners.name' => SORT_ASC],
            'desc' => ['partners.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'orders.id' => $this->id,
            'status' => $this->status,
            'partner_id' => $this->partner_id,
        ]);

        $query->andFilterWhere(['like', 'client_email', $this->client_email]);
        $query->andFilterWhere(['like', 'partners.name', $this->partnerName]);
        return $dataProvider;
    }
}
