<?php

namespace app\models;


use yii\db\ActiveRecord;

class WeatherDay extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'weather_day';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day', 'month'], 'required'],
        ];
    }

    public function getParts()
    {
        return $this->hasMany(WeatherDayPart::class, ['day_id' => 'id']);
    }
}