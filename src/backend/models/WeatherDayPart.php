<?php

namespace app\models;


use yii\db\ActiveRecord;

class WeatherDayPart extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'weather_day_part';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day_part', 'temp_min', 'temp_max', 'desc', 'pressure',
                'humidity', 'wind_speed', 'wind_direction',
                'fills_like_temp'], 'required'],
        ];
    }
}