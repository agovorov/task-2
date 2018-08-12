<?php

namespace app\controllers;


use app\models\WeatherDay;
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
        $weather = WeatherDay::find()->all();
        return $this->render('index', [
            'weather' => $weather
        ]);
    }
}
