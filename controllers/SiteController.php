<?php

namespace app\controllers;

use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        header("Access-Control-Allow-Origin: *");
        return $this->render('index');
    }
}
