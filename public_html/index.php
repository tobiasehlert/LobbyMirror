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

use Cmfcmf\OpenWeatherMap;
use Trafiklab\ResRobot\ResRobotWrapper;
use Trafiklab\Common\Model\Enum\TimeTableType;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Symfony\Component\Yaml\Parser as YamlParser;
use Slim\Factory\AppFactory;

// include composer framework
require_once(dirname(__FILE__) . '/../vendor/autoload.php');

// include weather icons
require_once(dirname(__FILE__) . '/inc/weather-icons.php');

// load config.yml
$array = new YamlParser();
$config = $array->parseFile(dirname(__FILE__) . '/../config.yml');

/* ---- do not place config below this line ---- */

$app = AppFactory::create();

$app->get('/', function ($request, $response, $args) use ($config) {
    $response->withHeader('LobbyMirror-Version', $config['lobbymirror']['version']);

    $profile = $config['profile'];
    if (array_key_exists('uid', $_GET) && array_key_exists($_GET['uid'], $profile))
        $uid = $_GET['uid'];
    else
        $uid = 'default';

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <title>LobbyMirror by Lindberg</title>
        <meta name="author" content="Tobias Lindberg">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="refresh" content="<?php echo $config['lobbymirror']['reload']; ?>" />
        <link rel="icon" type="image/x-icon" href="favicon.ico" />
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/weather-icons.min.css" media="screen">
        <link rel="stylesheet" href="css/lobby-custom.css?v=<?php echo $config['lobbymirror']['version']; ?>" media="screen">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="js/html5shiv.js"></script>
            <script src="js/respond.min.js"></script>
        <![endif]-->

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $config['lobbymirror']['analytics']; ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '<?php echo $config['lobbymirror']['analytics']; ?>');
        </script>

    </head>

    <body>
        <div class="container" style="width:100%;">
            <div <?php /* class="page-header" */ ?>>
                <div class="row lw-topmargin">
                    <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4">

                        <div class="lw-date">
                            <h3 id="lw-date-name">-</h3>
                            <h4 id="lw-date-date">-</h4>
                            <ul>
                                <h1 id="lw-date-hours">-</h1>
                                <h1 id="point">:</h1>
                                <h1 id="lw-date-min">-</h1>
                                <h1 id="point">:</h1>
                                <h1 id="lw-date-sec">-</h1>
                            </ul>
                        </div><!-- .lw-date -->

                        <div style="height: 75px;"></div>

                        <div id="lw-weather-now" class="row">
                            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                <div class="lw-weather-now-img">
                                    <i id="lw-weather-now-icon" class="wi"></i>
                                </div>
                            </div>
                            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                                <div class="lw-weather-now">
                                    <h1><span id="lw-weather-now-temperature">-</span>&nbsp;&deg;C</h1>
                                    <h4><span id="lw-weather-now-summary">-</span></h4>
                                    <h6>Sunrise:&nbsp;<span id="lw-weather-now-sunriseTime">-</span></h6>
                                    <h6>Sunset:&nbsp;<span id="lw-weather-now-sunsetTime">-</span></h6>
                                    <h6>Cloudcover:&nbsp;<span id="lw-weather-now-cloudcover">-</span>&nbsp;%</h6>
                                    <h6>Humidity:&nbsp;<span id="lw-weather-now-humidity">-</span>&nbsp;%</h6>
                                    <h6>Pressure:&nbsp;<span id="lw-weather-now-pressure">-</span>&nbsp;hPa</h6>
                                    <h6>Windspeed:&nbsp;<span id="lw-weather-now-windSpeed">-</span>&nbsp;m/s</h6>
                                </div>
                            </div>
                        </div><!-- #lw-weather-now -->

                        <div id="lw-weather-forcast" class="row">
                            <?php
                            for ($i = 0; $i <= 5; $i++) {
                            ?>

                                <div id="lw-weather-forcast-<?php echo $i; ?>" class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    <div id="lw-weather-forcast-<?php echo $i; ?>-img" class="lw-weather-forcast">
                                        <i id="lw-weather-forcast-<?php echo $i; ?>-icon" class="wi"></i>
                                        <h6><span id="lw-weather-forcast-<?php echo $i; ?>-time">-</span></h6>
                                        <h5><span id="lw-weather-forcast-<?php echo $i; ?>-temperatureMax">-</span>&nbsp;&deg;C</h5>
                                        <h6><span id="lw-weather-forcast-<?php echo $i; ?>-temperatureMin">-</span>&nbsp;&deg;C</h6>

                                    </div>
                                </div><!-- #lw-weather-forcast-<?php echo $i; ?> -->
                            <?php
                            }
                            ?>

                        </div><!-- #lw-weather-forcast -->

                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-5"></div>
                    <div class="col-xs-12 col-sm-5 col-md-3 col-lg-3">
                        <div id="lw-commuter-departures-1"></div>
                    </div>
                </div>

                <?php
                if ($config['profile'][$uid]['compliment'] !== false) {
                ?>

                    <div class="row lw-topmargin">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div style="height: 50px;"></div>
                            <div class="lw-bf-compliment">
                                <h3 id="lw-bf-compliment" class="lw-bf-center">You look gorgeous today !!</h3>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/lobby-clock.js"></script>
        <script src="js/lobby-weather.js"></script>
        <script src="js/lobby-commuter.js"></script>
        <script src="js/lobby-compliment.js"></script>
    </body>

    </html>
<?php
    // make return
    return $response;
});


// get compliment information
$app->get('/data/compliment', function ($request, $response, $args) use ($config) {
    $response->withHeader('LobbyMirror-Version', $config['lobbymirror']['version']);

    $ret = array();
    header("Content-Type: application/json");

    // select correct compliment depending on time of day
    if (date("H") >= 3 && date("H") < 12)
        $compliments = $config['compliment']['morning'];
    elseif (date("H") >= 12 && date("H") < 17)
        $compliments = $config['compliment']['afternoon'];
    else
        $compliments = $config['compliment']['evening'];

    // pick random compliment of array
    $ret = $compliments[array_rand($compliments)];

    echo json_encode($ret);
    exit;
});

// get weather information
$app->get('/data/weather/{uid}', function ($request, $response, $args) use ($config) {
    $uid = $request->getAttribute('uid', 'default');

    $httpClient = new \GuzzleHttp\Client();
    $httpRequestFactory = new \Nyholm\Psr7\Factory\Psr17Factory();
    $owm = new OpenWeatherMap($config['weather']['apikey'], $httpClient, $httpRequestFactory);

    $ret = array();
    header("Content-Type: application/json");

    $weather = $owm->getWeather(
        [
            'lat' => $config['profile'][$uid]['weather']['latitude'],
            'lon' => $config['profile'][$uid]['weather']['longitude'],
        ],
        $config['weather']['options']['units'],
        $config['weather']['options']['lang']
    );
    $ret['lw-weather-now']['lw-weather-now'] = array(
        'lw-weather-now-summary'        => $weather->weather->description,
        'lw-weather-now-icon'           => getWeatherIcon($weather->weather->id, $weather->weather->icon),
        'lw-weather-now-temperature'    => round($weather->temperature->now->getValue(), 1),
        'lw-weather-now-humidity'       => $weather->humidity->getValue(),
        'lw-weather-now-cloudcover'     => $weather->clouds->getValue(),
        'lw-weather-now-windSpeed'      => round($weather->wind->speed->getValue(), 1),
        'lw-weather-now-pressure'       => $weather->pressure->getValue(),
        'lw-weather-now-sunriseTime'    => $weather->sun->rise->setTimezone($weather->city->timezone)->format('H:i'),
        'lw-weather-now-sunsetTime'     => $weather->sun->set->setTimezone($weather->city->timezone)->format('H:i'),
    );

    $forecasts = $owm->getWeatherForecast(
        [
            'lat' => $config['profile'][$uid]['weather']['latitude'],
            'lon' => $config['profile'][$uid]['weather']['longitude'],
        ],
        $config['weather']['options']['units'],
        $config['weather']['options']['lang'],
        '',
        6
    );
    foreach ($forecasts as $id => $forecast) {
        $ret['lw-weather-forcast']['lw-weather-forcast-' . $id] = array(
            'lw-weather-forcast-' . $id . '-icon'           => getWeatherIcon($forecast->weather->id, $forecast->weather->icon),
            'lw-weather-forcast-' . $id . '-temperatureMin' => ceil($forecast->temperature->min->getValue()),
            'lw-weather-forcast-' . $id . '-temperatureMax' => ceil($forecast->temperature->max->getValue()),
            'lw-weather-forcast-' . $id . '-time'           => $forecast->time->day->setTimezone($weather->city->timezone)->format('D'),
        );
    }

    echo json_encode($ret);
    exit;
});

// get commuter information
$app->get('/data/commuter/{uid}', function (Request $request, Response $response, $args) use ($config) {
    $uid = $request->getAttribute('uid', 'default');

    $ret = array();
    header("Content-Type: application/json");

    foreach ($config['profile'][$uid]['commuter'] as $siteid => $filters) {
        # create array if null (when it's missing in config)
        if ($filters == null)
            $filters = array();

        $wrapper = new ResRobotWrapper();
        $wrapper->setUserAgent('LobbyMirror-Version', $config['lobbymirror']['version']);
        $wrapper->setTimeTablesApiKey($config['commuter']['apikey']);

        $wrapper2 = $wrapper->createTimeTableRequestObject();
        $wrapper2->setStopId($siteid);
        $wrapper2->setTimeTableType(TimeTableType::DEPARTURES);

        $response = $wrapper->getTimeTable($wrapper2);

        $i = 0;
        $ret['lw-commuter-departures'][$siteid]['lw-commuter-departures-info'] = array(
            "lw-commuter-departures-info-siteid" => $siteid,
        );

        # loop over all responses with $response->getTimetable()
        foreach ($response->getTimetable() as $timeTableEntry) {
            $allowed = false;
            $data = array();

            # set stop name
            if ($i == 0)
                $ret['lw-commuter-departures'][$siteid]['lw-commuter-departures-info']['lw-commuter-departures-info-name'] = preg_replace('/\s\(.*/', '', $timeTableEntry->getStopName());

            # get data from $timeTableEntry
            $data['transportType'] = strtolower($timeTableEntry->getTransportType());
            $data['stopName'] = $timeTableEntry->getStopName();
            $data['lineNumber'] = $timeTableEntry->getLineNumber();
            $data['direction'] = preg_replace('/\s\(.*/', '', $timeTableEntry->getDirection());

            # get minutes to departure
            $data['minutesToDeparture'] = $timeTableEntry->getScheduledStopTime()->diff(new DateTime())->format('%i');
            /*
            if ($timeTableEntry->getEstimatedStopTime() != null) {
                $data['minutesToDeparture'] = $timeTableEntry->getEstimatedStopTime()->diff(new DateTime())->format('%i');
            } else {
                $data['minutesToDeparture'] = $timeTableEntry->getScheduledStopTime()->diff(new DateTime())->format('%i');
            }
            */

            # check if time is set in filter and if it is less than the time to departure
            if (!array_key_exists('time', $filters) || $filters['time'] >= $data['minutesToDeparture']) {
                $allowed = true;
            }

            # manipulate minutes to departure
            if ($data['minutesToDeparture'] > 30) {
                # write time in H:i when more than 30 minutes
                $data['minutesToDeparture'] = $timeTableEntry->getScheduledStopTime()->format('H:i');
            } elseif ($data['minutesToDeparture'] == 0) {
                # write "Now" when 0 minutes
                $data['minutesToDeparture'] = 'Now';
            } else {
                # write minutes and add "min" when less than 30 minutes
                $data['minutesToDeparture'] = $data['minutesToDeparture'] . ' min';
            }

            # check if filter is set and if it is the same as the transport type
            if (array_key_exists('filter', $filters) && $filters['filter'] != "" && $allowed) {
                if ($filters['filter'] == $data['transportType']) {
                    $allowed = true;
                } else {
                    $allowed = false;
                }
            }

            # build array for return
            if ($allowed) {
                $ret['lw-commuter-departures'][$siteid]['lw-commuter-departures-data']["lw-commuter-departures-data-" . $data['transportType']]["lw-commuter-departures-data-" . $data['transportType'] . "-type"] = ucfirst($data['transportType']);
                $ret['lw-commuter-departures'][$siteid]['lw-commuter-departures-data']["lw-commuter-departures-data-" . $data['transportType']]["lw-commuter-departures-data-" . $data['transportType'] . "-" . $i] = array(
                    "lw-commuter-departures-data-" . $data['transportType'] . "-" . $i . "-LineNumber" => $data['lineNumber'],
                    "lw-commuter-departures-data-" . $data['transportType'] . "-" . $i . "-Destination" => $data['direction'],
                    "lw-commuter-departures-data-" . $data['transportType'] . "-" . $i . "-DisplayTime" => $data['minutesToDeparture'],
                );
            }

            # increas counter
            $i++;
        }
    }

    echo json_encode($ret);
    exit;
});

// execute the framework
$app->run();

?>