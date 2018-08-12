<?php

namespace app\components\parser;


use app\components\parser\entity\WeatherDayPart;
use app\components\parser\entity\WeatherInfo;

/**
 * Парсер яндекса
 *
 * @package app\components\parser
 */
class YandexWeatherParser extends BaseWeatherParser
{
    public function parse($url)
    {
        $content = $this->getPageContent($url);
        $result = $this->parseContent($content);
        return $result;
    }

    /**
     * Парсим страницу
     *
     * @param $content
     * @return array
     */
    private function parseContent($content): array
    {
        $days = [];
        $document = \phpQuery::newDocumentHTML($content);
        $weather = $document->find(".forecast-details__day");
        foreach ($weather as $day) {
            $dayInfo = new WeatherInfo();
            $pq = pq($day);

            // TODO На странице нет года, лучше хранить в виде даты. Пока оставляю так.
            $dayInfo->day = $pq->attr('data-anchor');
            $dayInfo->month = $pq->find('.forecast-details__day-month')->text();

            // Находим блок с информацией о погоде, а в ней таблица по дню
            $dayRows = $pq->next('.forecast-details__day-info')->find('.weather-table__row');
            foreach ($dayRows as $index => $row) {
                $info = new WeatherDayPart();
                $info->dayPart = $index;

                // Temp
                $td = pq($row)->find('td:first');
                $info->tempMin = pq($td)->find('.temp__value:first')->text();
                $info->tempMax = pq($td)->find('.temp__value:last')->text();

                // Текстовое описание
                $info->desc = pq($row)->find('td:eq(2)')->text();

                // Давление
                $info->pressure = pq($row)->find('td:eq(3)')->text();

                // Влажность
                $info->humidity = pq($row)->find('td:eq(4)')->text();

                // Скорость ветра
                $td = pq($row)->find('td:eq(5)');
                $info->windSpeed = pq($td)->find('.weather-table__wind')->text();
                $info->windDirection = pq($td)->find('.weather-table__wind-direction')->text();

                // Ощущается как
                $td = pq($row)->find('td:eq(6)');
                $info->fillsLikeTemp = pq($td)->find('.temp__value')->text();

                $dayInfo->dayParts[$info->dayPart] = $info;
            }
            $days[] = $dayInfo;
        }
        return $days;
    }
}