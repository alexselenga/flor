<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class OrderSearch extends Order
{

    public $ordersCache = [];

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
            'orders.status' => $this->status,
            'orders.partner_id' => $this->partner_id,
            'orders.created_at' => $this->created_at,
            'orders.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'orders.client_email', $this->client_email]);
        $query->andFilterWhere(['like', 'partners.name', $this->partnerName]);

        $this->makeOrdersCache($dataProvider->models);
        return $dataProvider;
    }

    protected function makeOrdersCache($orderModels) {
        $orderIds = ArrayHelper::getColumn($orderModels, 'id');

        $this->ordersCache = Order::find()
            ->joinWith('orderProducts.product')
            ->where(['in', 'orders.id', $orderIds])
            ->indexBy('id')
            ->asArray()
            ->all();
    }
}
