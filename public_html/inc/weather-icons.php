<?php

# https://github.com/erikflowers/weather-icons#api-usage
function getWeatherIcon($id = 0, $icon = "")
{
    if (substr($icon, -1) == 'd') {
        return 'wi-owm-day-' . $id;
    } elseif (substr($icon, -1) == 'n') {
        return 'wi-owm-night-' . $id;
    } else {
        return 'wi-owm-' . $id;
    }
}
