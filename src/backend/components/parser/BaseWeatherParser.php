<?php

namespace app\components\parser;


use components\parser\WeatherParserException;
use yii\httpclient\Client;

/**
 * Базовый набор методов парсера
 *
 * @package components\parser
 */
abstract class BaseWeatherParser implements WeatherParser
{
    /**
     * Возвращаем содержимое страницы
     *
     * @param $url
     * @return string
     * @throws WeatherParserException
     */
    protected function getPageContent($url)
    {
        $client = new Client(['baseUrl' => $url]);
        $response = $client->createRequest()
            ->setFormat(Client::FORMAT_RAW_URLENCODED)
            ->send();
        if (!$response->isOk) {
            throw new WeatherParserException('Unable to parse url');
        }

        return $response->content;
    }
}