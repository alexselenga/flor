<?php

/* @var $this yii\web\View */

use yii\widgets\DetailView;

$this->title = 'Погода в Брянске';

$lang = "ru_RU";
$latitude = '53.243562';
$longtitude = '34.363407';
$url = "https://api.weather.yandex.ru/v1/forecast?lat=$latitude&lon=$longtitude&lang=$lang&hours=false";
$options = ['http' => ['header' => 'X-Yandex-API-Key: a523de0a-10a1-4a3e-9d86-802e5a3c16b3']];
$context = stream_context_create($options);
$data = @file_get_contents($url, false, $context);

if ($data) {
    $dataJson = json_decode($data);

    echo DetailView::widget([
        'model' => $dataJson,
        'attributes' => [
            [
                'label' => 'Температура',
                'value' => $dataJson->fact->temp,
            ],
            [
                'label' => 'Температура по ощущению',
                'value' => $dataJson->fact->feels_like,
            ],
        ],
    ]);
} else {
    echo "Сервер не доступен!";
}
