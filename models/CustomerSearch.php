<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Customer;
use PharIo\Manifest\Author;

/**
 * CustomerSearch represents the model behind the search form of `app\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch;
    public function rules()
    {
        return [
            [['id', 'city_id', 'status'], 'integer'],
            [['first_name', 'last_name', 'register_date', 'globalSearch', 'img_url'], 'safe'],
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
        $query = Customer::find()
            ->joinWith(['city', 'city.country', 'city.country.area']);

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
            'or',
            ['like', 'customer.first_name', $this->globalSearch],
            ['like', 'customer.last_name', $this->globalSearch],
            ['like', 'city.city_name', $this->globalSearch],
            ['like', 'country.name', $this->globalSearch],
            ['like', 'area.name', $this->globalSearch],


        ]);

        // echo "<pre>";
        // print_r($dataProvider->query->createCommand()->getRawSql());
        // exit;

        return $dataProvider;
    }
}
