<?php

/**
 * LobbyMirror
 *  - Created 2016 by Tobias Lindberg
 *  - GitHub https://github.com/tobiasehlert/LobbyMirror
 * 
 * Credits
 *  - Theme by https://bootswatch.com/cyborg/
 *  - Train data by https://www.trafiklab.se/
 *  - Weather data by https://openweathermap.org/
 *  - Weather icons by https://erikflowers.github.io/weather-icons/
 */

$config = array(
    'lobbymirror' => array(
        'version'   => '1.1.0',
        'reload'    => 1800,
        'analytics' => 'UA-XXXXXXXX-X',
    ),
    'profile'   => array(
        'example'   => array(
            'weather'  => array(
                'latitude'  => '59.3613',
                'longitude' => '17.8315',
            ),
            'commuter'  => array(
                '1'         => array(
                    'siteids'   => array(
                        '5775'      => array(
                            'filter'    => '',
                            'direction' => '',
                            'time'      => 60,
                        ),
                        '5762'      => array(
                            'filter'    => '',
                            'direction' => 2,
                            'time'      => 60,
                        ),
                        '9701'      => array(
                            'filter'    => 'trains',
                            'direction' => 1,
                            'time'      => 60,
                        ),
                    ),
                ),
            ),
            'compliment' => true,
        ),
    ),
    'compliment' => array(
        'morning'   => array(
            'Good morning, handsome!',
            'Enjoy your day!',
            'How was your sleep?',
        ),
        'afternoon' => array(
            'Hello, beauty!',
            'You look sexy!',
            'Looking good today!',
        ),
        'evening'   => array(
            'Wow, you look hot!',
            'You look nice!',
            'Hi, sexy!',
        ),
    ),
    'weather'  => array(
        'apikey'    => 'abcdefghijklmnopqrstuvvxyz123456',
        'options'   => array(
            'units'     => 'si',
            'lang'      => 'en',
        ),
    ),
    'commuter'  => array(
        'apikey'    => 'abcdefghijklmnopqrstuvvxyz123456',
    ),
);
