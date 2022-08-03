<?php

/**
 *
 * LobbyMirror
 *  - Created 2016 by Tobias Lindberg
 *  - verion 1.1.0
 *
 * Theme by https://bootswatch.com/cyborg/
 *
 */

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

// include composer framework
require_once( dirname( __FILE__ ).'/../vendor/autoload.php' );

// include config for lobbymirror project
require_once( dirname( __FILE__ ).'/../config.php' );



/* ---- do not place config below this line ---- */

$app = AppFactory::create();

$app->get( '/', function($request, $response, $args) use ($config)
{
    $response->withHeader('LobbyMirror-Version', $config['lobbymirror']['version'] );

    $profile = $config['profile'];
    if ( array_key_exists( 'uid', $_GET ) && array_key_exists( $_GET['uid'], $profile ) )
	$uid = $_GET['uid'];
    else
        $uid = 'default';

    ?><!DOCTYPE html>
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
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?php echo $config['lobbymirror']['analytics']; ?>');
        </script>

    </head>
    <body>
        <div class="container" style="width:100%;" >
            <div <?php /* class="page-header" */ ?> >
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
                                    <h6>Windspeed:&nbsp;<span id="lw-weather-now-windSpeed">-</span>&nbsp;m/s</h6>
                                </div>
                            </div>
                        </div><!-- #lw-weather-now -->

                        <div id="lw-weather-forcast" class="row">
                            <?php
                            for ( $i = 0; $i <= 5; $i++ )
                            {
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
                    <div class="col-xs-12 col-sm-6 col-md-1 col-lg-2"></div>
                    <div class="col-xs-12 col-sm-5 col-md-3 col-lg-3">
                        <div id="lw-sl-departures-2"></div>
                    </div>
                    <div class="col-xs-12 col-sm-5 col-md-3 col-lg-3">
                        <div id="lw-sl-departures-1"></div>
                    </div>
                </div>

                <?php
                if ( $config['profile'][$uid]['compliment'] !== false )
                {
                    ?>

                    <div class="row lw-topmargin">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div style="height: 50px;"></div>
                            <div class="lw-bf-compliment">
                                <h3 id="lw-bf-compliment" class="lw-bf-center" >You look gorgeous today !!</h3>
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
        <script src="js/lobby-clock.js" ></script>
        <script src="js/lobby-weather.js" ></script>
        <script src="js/lobby-sl.js" ></script>
        <script src="js/lobby-compliment.js" ></script>
    </body>
</html>
<?php
// make return
return $response;
} );


// get compliment information
$app->get( '/data/compliment', function($request, $response, $args) use ($config)
{
    $response->withHeader('LobbyMirror-Version', $config['lobbymirror']['version'] );

    $ret = array();
    header("Content-Type: application/json");

    // select correct compliment depending on time of day
    if ( date( "H" ) >= 3 && date( "H" ) < 12 )
        $compliments = $config['compliment']['morning'];
    elseif ( date( "H" ) >= 12 && date( "H" ) < 17 )
        $compliments = $config['compliment']['afternoon'];
    else
        $compliments = $config['compliment']['evening'];

    // pick random compliment of array
    $ret = $compliments[ array_rand( $compliments ) ];

    echo json_encode( $ret );
    exit;
} );

// get weather information
$app->get( '/data/weather/{uid}', function($request, $response, $args) use ($config)
{
    $response->withHeader('LobbyMirror-Version', $config['lobbymirror']['version'] );

    $uid = $request->getAttribute('uid');
    if ( ! ( $uid != '' ) )
        $uid = 'default';

    require_once( 'inc/forecast-io.php' );

    $forecast = new \Forecast\Forecast( $config['forecast']['apikey'] );
    $weather = $forecast->get(
        $config['profile'][$uid]['forecast']['latitude'],
        $config['profile'][$uid]['forecast']['longitude'],
        null,
        $config['forecast']['options']
    );

    $ret = array();
    header("Content-Type: application/json");

    $ret['lw-weather-now']['lw-weather-now'] = array(
        'lw-weather-now-summary'            => $weather->currently->summary,
        'lw-weather-now-icon'               => getWeatherIcon( $weather->currently->icon ),
        'lw-weather-now-temperature'        => ceil( $weather->currently->temperature ),
//        'lw-weather-now-humidity'           => ( $weather->currently->humidity * 100 ),
        'lw-weather-now-cloudcover'         => ( $weather->currently->cloudCover * 100 ),
        'lw-weather-now-windSpeed'          => ceil( $weather->currently->windSpeed )
    );

    foreach ( $weather->daily->data as $key => $value )
    {
        if ( $key == 0 )
        {
            $ret['lw-weather-now']['lw-weather-now']['lw-weather-now-sunriseTime'] = date( "H:i", $value->sunriseTime );
            $ret['lw-weather-now']['lw-weather-now']['lw-weather-now-sunsetTime']  = date( "H:i", $value->sunsetTime );
        }
        if ( $key == 7 )
        {}
        else
            $ret['lw-weather-forcast']['lw-weather-forcast-'.$key] = array(
                'lw-weather-forcast-'.$key.'-icon'              => getWeatherIcon( $value->icon ),
                'lw-weather-forcast-'.$key.'-temperatureMin'    => ceil( $value->temperatureMin ),
                'lw-weather-forcast-'.$key.'-temperatureMax'    => ceil( $value->temperatureMax ),
                'lw-weather-forcast-'.$key.'-time'              => date("D", $value->sunriseTime)
            );
    }

    echo json_encode( $ret );
    exit;
} );

// get SL information
$app->get( '/data/sl/{uid}/{column}', function(Request $request, Response $response, $args) use ($config)
{
    $column = $request->getAttribute('column');
    $response->withHeader('LobbyMirror-Version', $config['lobbymirror']['version'] );

    $uid = $request->getAttribute('uid');
    if ( ! ( $uid != '' ) )
        $uid = 'default';

    $ret = array();
    header("Content-Type: application/json");

    foreach ( $config['profile'][$uid]['commuter'][$column]['siteids'] as $siteid => $filters )
    {
        $sl = new \Curl\Curl();
        $sl->setOpt( CURLOPT_FOLLOWLOCATION, true );
        $SLrequest = array(
            'url'       => 'http://api.sl.se/api2/realtimedeparturesV4.json',
            'params'    => array(
                'key'           => $config['commuter']['apikey'],
                'siteid'        => $siteid,
                'TimeWindow'    => $config['profile'][$uid]['commuter'][$column]['siteids'][$siteid]['time'],
            ),
        );

        $sl->get( $SLrequest['url'], $SLrequest['params'] );
        if ( $sl->error )
        {
            error_log( 'Error on SL quest nr 1: '.$sl->errorCode.': '.$sl->errorMessage.' - '.$sl->response );
            // make new retry on curl request
            $sl->close();
            $sl = new \Curl\Curl();
            $sl->setOpt( CURLOPT_FOLLOWLOCATION, true );
            $sl->get( $SLrequest['url'], $SLrequest['params'] );
        }

        if ( ! $sl->error )
        {
            $filter_types = '';
            if ( strpos( $filters['filter'], ',') !== false || strlen( $filters['filter'] ) >= 1 )
                $filter_types = explode( ',', $filters['filter'] );

            foreach ( $sl->response->ResponseData as $key => $value )
            {
                if ( is_array( $value ) && $key != 'StopPointDeviations' && $key != 'LatestUpdates' && $key != 'DataAge' )
                {
                    if ( ! ( is_array( $filter_types ) ) || is_array( $filter_types ) && in_array( strtolower( $key ), $filter_types ) )
                    {
                        // creating array and saving siteid
                        $ret['lw-sl-departures'][$siteid]['lw-sl-departures-info']['lw-sl-departures-info-siteid'] = $siteid;

                        // check if the transportation has some departures
                        if ( array_key_exists( '0', $value ) )
                        {
                            foreach ( $value as $key2 => $value2 )
                            {
                                $grouptype = 'lw-sl-departures-data-'.strtolower( $key );
                                if ( $filters['direction'] == $value2->JourneyDirection || $filters['direction'] == '' )
                                {
                                    $ret['lw-sl-departures'][$siteid]['lw-sl-departures-data'][$grouptype][$grouptype.'-'.$key2] = array(
                                        $grouptype.'-'.$key2.'-LineNumber'        => $value2->LineNumber,
                                        $grouptype.'-'.$key2.'-Destination'       => $value2->Destination,
                                        $grouptype.'-'.$key2.'-DisplayTime'       => $value2->DisplayTime,
                                    );
                                }
                            }
                            $ret['lw-sl-departures'][$siteid]['lw-sl-departures-info']['lw-sl-departures-info-name'] = $value2->StopAreaName;
                            $ret['lw-sl-departures'][$siteid]['lw-sl-departures-data'][$grouptype][$grouptype.'-type'] = $key;
                        }
                    }
                    else
                    {
                        // filter is set to not include this travel type
                    }
                }
            }
        }

        $sl->close();
    }

    echo json_encode( $ret );
    exit;

} );


// execute the framework
$app->run();

?>
