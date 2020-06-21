<?php

/* @var $this yii\web\View */

use yii\widgets\DetailView;

$this->title = 'Погода в Брянске';

const conditions = [
    'clear' => 'ясно',
    'partly-cloudy' => 'малооблачно',
    'cloudy' => 'облачно с прояснениями',
    'overcast' => 'пасмурно',
    'partly-cloudy-and-light-rain' => 'небольшой дождь',
    'partly-cloudy-and-rain' => 'дождь',
    'overcast-and-rain' => 'сильный дождь',
    'overcast-thunderstorms-with-rain' => 'сильный дождь, гроза',
    'cloudy-and-light-rain' => 'небольшой дождь',
    'overcast-and-light-rain' => 'небольшой дождь',
    'cloudy-and-rain' => 'дождь',
    'overcast-and-wet-snow' => 'дождь со снегом',
    'partly-cloudy-and-light-snow' => 'небольшой снег',
    'partly-cloudy-and-snow' => 'снег',
    'overcast-and-snow' => 'снегопад',
    'cloudy-and-light-snow' => 'небольшой снег',
    'overcast-and-light-snow' => 'небольшой снег',
    'cloudy-and-snow' => 'снег'
];

const windDirs = [
    'nw' => 'северо-западное',
    'n' => 'северное',
    'ne' => 'северо-восточное',
    'e' => 'восточное',
    'se' => 'юго-восточное',
    's' => 'южное',
    'sw' => 'юго-западное',
    'w' => 'западное',
    'с' => 'штиль'
];

$lang = "ru_RU";
$latitude = '53.243562';
$longtitude = '34.363407';
$url = "https://api.weather.yandex.ru/v1/informers?lat=$latitude&lon=$longtitude&lang=$lang&hours=false";

$options = [
    'http' => [
        'header' => 'X-Yandex-API-Key: a523de0a-10a1-4a3e-9d86-802e5a3c16b3'
    ]
];

$context = stream_context_create($options);
$dataJSON = @file_get_contents($url, false, $context);

if ($dataJSON) {
    $data = json_decode($dataJSON);

    echo DetailView::widget([
        'model' => $data,
        'attributes' => [
            [
                'label' => 'Температура',
                'value' => $data->fact->temp,
            ],
            [
                'label' => 'Температура по ощущению',
                'value' => $data->fact->feels_like,
            ],
            [
                'label' => 'Облачность',
                'value' => conditions[$data->fact->condition],
            ],
            [
                'label' => 'Скорость ветра',
                'value' => $data->fact->wind_speed . ' м/с',
            ],
            [
                'label' => 'Направление ветра',
                'value' => windDirs[$data->fact->wind_dir],
            ],
            [
                'label' => 'Давление',
                'value' => $data->fact->pressure_mm . ' мм рт. ст.',
            ],
            [
                'label' => 'Влажность',
                'value' => $data->fact->humidity . ' %',
            ],
            [
                'label' => 'Подробнее',
                'value' => $data->info->url,
                'format' => 'url'
            ],
        ],
    ]);
} else {
    echo "Сервер не доступен!";
}
