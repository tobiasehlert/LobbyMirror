<?php

function getWeatherIcon( $data = '' )
{
    $mapping = array(
        'clear-day'              => 'wi-day-sunny',
        'clear-night'            => 'wi-night-clear',
        'rain'                   => 'wi-rain',
        'snow'                   => 'wi-snow',
        'sleet'                  => 'wi-sleet',
        'wind'                   => 'wi-strong-wind',
        'fog'                    => 'wi-fog',
        'cloudy'                 => 'wi-cloudy',
        'partly-cloudy-day'      => 'wi-day-cloudy',
        'partly-cloudy-night'    => 'wi-night-cloudy',
        'hail'                   => 'wi-hail',
        'thunderstorm'           => 'wi-thunderstorm',
        'tornado'                => 'wi-tornado',
    );
    return $mapping[$data];
}
