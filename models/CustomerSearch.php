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
            [['first_name', 'last_name', 'register_date', 'globalSearch'], 'safe'],
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
        $query = Customer::find();
        $query->joinWith('city');
        //$query->joinWith('country');


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
            ['like', 'first_name', $this->globalSearch],
            ['like', 'last_name', $this->globalSearch],
            // ['like', 'city_id', $this->globalSearch],
            ['like', 'city_name', $this->globalSearch],
            ['like', 'name', $this->globalSearch],


        ]);

        return $dataProvider;
    }
}
