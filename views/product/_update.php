<?php

use app\models\Product;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

$model = new Product();
?>

<div class="product-form">
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" id="updateModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="updateModalLabel">Изменение цены</h4>
                </div>
                <div class="modal-body">
                    <?php
                        $form = ActiveForm::begin();
                            echo $form->field($model, 'name')->textInput(['maxlength' => true]);
                            echo $form->field($model, 'price')->textInput();
                        ActiveForm::end();
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary" id="closeUpdateModal">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</div>
