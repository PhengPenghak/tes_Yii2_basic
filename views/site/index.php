<?php

use yii\grid\GridView;
use yii\widgets\ListView;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'first_name',
        'last_name',
    ],
]); ?>