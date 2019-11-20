<?php

use app\models\Product;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Продукты';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="product-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    Pjax::begin(['id' => 'pjaxProduct']);
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'id' => 'productList',
            'layout' => '{pager}{summary}{items}{pager}',
            'columns' => [
                'id',
                'name',
                [
                    'attribute' => 'vendorName',
                    'value' => 'vendor.name',
                ],
                [
                    'attribute' => 'price',
                    'value' => function (Product $product) {
                        return Html::a($product->price, '.product-form .modal', [
                            'title' => 'Редактировать',
                            'data-toggle' => 'modal',
                            'data-url' => Url::to(['product/update', 'id' => $product->id]),
                        ]);
                    },
                    'format' => 'raw',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'buttons' => [
                        'update' => function ($url, Product $product) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '.product-form .modal', [
                                'title' => 'Редактировать',
                                'data-toggle' => 'modal',
                                'data-url' => Url::to(['product/update', 'id' => $product->id]),
                            ]);
                        },
                    ],
                    'template' => '{update}'
                ],
            ],
        ]);
    Pjax::end();
    ?>
</div>

<?= $this->render('_form'); ?>
