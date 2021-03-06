<?php

use app\models\Order;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    Pjax::begin();
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'id' => 'orderList',
            'layout' => '{pager}{summary}{items}{pager}',
            'columns' => [
                [
                    'attribute' => 'id',
                    'value' => function (Order $order) {
                        return Html::a($order->id, Url::to(['update', 'id' => $order->id]));
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'partnerName',
                    'value' => 'partner.name',
                ],
                [
                    'label' => 'Стоимость',
                    'value' => function (Order $order) use ($searchModel) {
                        return Order::getOrderCost($searchModel->ordersCache[$order->id]['orderProducts']);
                    },
                ],
                [
                    'label' => 'Состав заказа',
                    'value' => function (Order $order) use ($searchModel) {
                        return Order::getOrderContent($searchModel->ordersCache[$order->id]['orderProducts']);
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'status',
                    'value' => function (Order $order) {
                        return Order::STATUSES[$order->status];
                    },
                    'filter' => Order::STATUSES,
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update}',
                ],
            ]
        ]);
    Pjax::end();
    ?>
</div>
