<?php

use app\models\Order;
use app\models\Partner;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$orderProducts = $model->orderProducts;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?
            echo Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
//            echo Html::a('Удалить', ['delete', 'id' => $model->id], [
//                    'class' => 'btn btn-danger',
//                    'data' => [
//                        'confirm' => 'Вы действительно хотите удалить заказ?',
//                        'method' => 'post',
//                    ],
//                ])
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'partner_id',
                'value' => Partner::getList()[$model->partner_id],
            ],
            'client_email:email',
            [
                'attribute' => 'status',
                'value' => Order::STATUSES[$model->status]
            ],
            [
                'label' => 'Состав заказа',
                'value' => Order::getOrderContent($orderProducts, '<br>'),
                'format' => 'raw',
            ],
            [
                'label' => 'Стоимость заказа',
                'value' => Order::getOrderCost($orderProducts),
            ],
        ],
    ])
    ?>

</div>
