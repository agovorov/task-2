<div>
    <div class="jumbotron">
        <h2><?= \Yii::t('app', 'Прогноз погоды') ?></h2>
    </div>

    <div class="body-content container">
        <?php foreach ($weather as $day) { ?>
            <div class="row">
                <h3><?= $day->day ?> <?= $day->month ?></h3>
                <?php foreach ($day->parts as $part) { ?>

                    <div class="col-sm-3">
                        <?= $part->temp_min ?>° ... <?= $part->temp_max ?>°, <?= $part->desc ?>
                    </div>

                    <div class="col-sm-2">
                        <?= \Yii::t('app', 'Давление: {pressure} мм рт. ст.', [
                            'pressure' => $part->pressure
                        ]) ?>
                    </div>

                    <div class="col-sm-2">
                        <?= \Yii::t('app', 'Влажность: {humidity}', [
                            'humidity' => $part->humidity
                        ]) ?>
                    </div>

                    <div class="col-auto">
                        <?= \Yii::t('app', 'Ветер {speed} м.с, {dest}', [
                            'speed' => $part->wind_speed,
                            'dest' => $part->wind_direction
                        ]) ?>
                    </div>

                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
