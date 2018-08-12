<?php

namespace app\components\parser\entity;


/**
 * Погода на часть суток (утро, день, вечер, ночь)
 *
 * @package components\parser\entity
 */
class WeatherDayPart {
    /** @var  integer Часть дня (Утро, день, вечер, ночь) */
    public $dayPart;
    public $tempMin;
    public $tempMax;
    public $desc;
    public $pressure;
    public $humidity;
    public $windSpeed;
    public $windDirection;
    public $fillsLikeTemp;
}