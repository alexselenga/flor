<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProductSearch represents the model behind the search form of `app\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'price', 'vendor_id'], 'integer'],
            [['name', 'created_at', 'updated_at', 'vendorName'], 'safe'],
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
        $query = Product::find()->joinWith('vendor');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 25,
            ],
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC],
            ],
        ]);

        $dataProvider->sort->attributes['vendorName'] = [
            'asc' => ['vendors.name' => SORT_ASC],
            'desc' => ['vendors.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'products.id' => $this->id,
            'products.price' => $this->price,
            'products.vendor_id' => $this->vendor_id,
            'products.created_at' => $this->created_at,
            'products.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'products.name', $this->name]);
        $query->andFilterWhere(['like', 'vendors.name', $this->vendorName]);

        return $dataProvider;
    }
}
