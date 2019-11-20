<?php

use app\models\Order;
use app\models\Partner;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */

echo '<div class="order-form">';
    $form = ActiveForm::begin();
        echo $form->field($model, 'partner_id')->dropDownList(Partner::getList(), ['prompt' => 'Выберите партнера...']);
        echo $form->field($model, 'client_email')->textInput(['maxlength' => true]);
        echo $form->field($model, 'status')->dropDownList(Order::STATUSES, ['prompt' => 'Выберите статус...']);

        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'label' => 'Состав заказа',
                    'value' => Order::getOrderContent($model->orderProducts, '<br>'),
                    'format' => 'raw',
                ],
                [
                    'label' => 'Стоимость заказа',
                    'value' => Order::getOrderCost($model->orderProducts),
                ],
            ],
        ]);

        echo '<div class="form-group">';
            echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);
        echo '</div>';
    ActiveForm::end();
echo '</div>';
