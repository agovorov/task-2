<?php

use yii\db\Migration;

/**
 * Class m180812_144104_init
 */
class m180812_144104_init extends Migration
{
    public function up()
    {
        $this->createTable("weather_day", [
            "id" => $this->primaryKey(),
            "day" => $this->string(255),
            "month" => $this->string(255),
            "description" => $this->text(),
            "ts" => 'timestamptz NOT NULL DEFAULT NOW()'
        ]);

        $this->createTable("weather_day_part", [
            "id" => $this->primaryKey(),
            "day_id" => $this->integer()->notNull(),
            "day_part" => $this->smallInteger()->notNull(),
            "temp_min" => $this->string('5')->notNull(),
            "temp_max" => $this->string('5')->notNull(),
            "desc" => $this->string('1000'),
            "pressure" => $this->integer(),
            "humidity" => $this->string(),
            "wind_speed" => $this->string(),
            "wind_direction" => $this->string(),
            "fills_like_temp" => $this->string(),
            "ts" => 'timestamptz NOT NULL DEFAULT NOW()'
        ]);

        $this->addForeignKey("wday_fkey",
            "weather_day_part", "day_id",
            "weather_day", "id",
            "CASCADE", "CASCADE"
        );
    }

    public function down()
    {
        echo "m180812_144104_init cannot be reverted.\n";
        return false;
    }
}
