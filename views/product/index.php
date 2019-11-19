<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Продукты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?
//            echo Html::a('Create Product', ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
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
            'price',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {link}',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
