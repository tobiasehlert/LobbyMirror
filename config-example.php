<?php

/**
 *
 * LobbyMirror
 *  - Created 2016 by Tobias Lindberg
 *
 * Theme by https://bootswatch.com/cyborg/
 *
 */

$config = array(
    'lobbymirror' => array(
        'version'   => '1.1.0',
        'reload'    => 1800,
        'analytics' => 'UA-XXXXXXXX-X',
    ),
    'profile'   => array(
        'example'   => array(
            'forecast'  => array(
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
    'forecast'  => array(
        'apikey'    => 'abcdefghijklmnopqrstuvvxyz123456',
        'options'   => array(
            'units'     => 'si',
            'lang'      => 'en',
            'exclude'   => 'flags,minutely,hourly',
        ),
    ),
    'commuter'  => array(
        'apikey'    => 'abcdefghijklmnopqrstuvvxyz123456',
    ),
);

?>