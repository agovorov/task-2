<?php

namespace app\components\parser;


/**
 * Interface Parser
 *
 * @package components\parser
 */
interface WeatherParser
{
    function parse($url);
}