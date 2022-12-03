<?php

use app\models\Country;
use app\models\Customer;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SearchCustomer $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

// $this->title = 'Customers';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'city_id',
                'value' => function ($model) {
                    $country = Country::findOne($model->city->country_id);
                    return $model->city->city_name . ', ' . $model->city->country->name . ', ' . $model->city->country->area->name;
                },
            ],
            'first_name',
            'last_name',

        ],
    ]); ?>


</div>