<?php

namespace app\commands;

use app\models\WeatherDay;
use app\models\WeatherDayPart;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Command for parsing
 *
 * @author Govorov Andrey
 */
class ParserController extends Controller
{
    const DEFAULT_URL = 'https://yandex.ru/pogoda/moscow/details';

    /**
     * Perform parsing
     *
     * @example
     * @param string $url settings url for parsing
     * @return int Exit code
     */
    public function actionParse($url = null)
    {
        if (!$url) {
            $url = self::DEFAULT_URL;
        }
        $parser = \Yii::$app->weatherParser;
        $parseResult = $parser->parse($url);

        // TODO Для простоты делаю приватный метод, в реальном проекте, будет отдельный
        $this->saveToDataBase($parseResult);
        return ExitCode::OK;
    }


    /**
     * Временный метод сохранения результата парсинга
     */
    private function saveToDataBase($data)
    {
        foreach ($data as $dayInfo) {
            // Ищем день
            $day = WeatherDay::findOne([
                'day' => $dayInfo->day,
                'month' => $dayInfo->month
            ]);

            if (!$day) {
                $day = new WeatherDay();
                $day->day = $dayInfo->day;
                $day->month = $dayInfo->month;
                if (!$day->save()) {
                    throw new \RuntimeException('Unable to save day');
                }
            }

            $infos = $dayInfo->dayParts;
            foreach ($infos as $info) {
                $i = WeatherDayPart::findOne([
                    'day_id' => $day->id,
                    'day_part' => $info->dayPart
                ]);

                if (!$i) {
                    //New record
                    $i = new WeatherDayPart();
                    $i->day_id = $day->id;
                    $i->day_part = $info->dayPart;
                }

                $i->temp_min = $info->tempMin;
                $i->temp_max = $info->tempMax;
                $i->desc = $info->desc;
                $i->pressure = $info->pressure;
                $i->humidity = $info->humidity;
                $i->wind_speed = $info->windSpeed;
                $i->wind_direction = $info->windDirection;
                $i->fills_like_temp = $info->fillsLikeTemp;
                if (!$i->save()) {
                    throw new \RuntimeException('Unable to save day');
                }
            }
        }
    }
}
