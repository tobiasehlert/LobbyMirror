<?php

/**
 *
 * LobbyMirror
 *  - Created 2016 by Tobias Lindberg
 *  - verion 1.0.0
 *
 * Theme by https://bootswatch.com/cyborg/
 *
 */


// include composer framework
require_once( dirname( __FILE__ ).'/../vendor/autoload.php' );

// include config for lobbymirror project
require_once( dirname( __FILE__ ).'/../config.php' );


/* ---- do not place config below this line ---- */

$app = new \Slim\App;

$config['displayErrorDetails'] = true;
$app = new \Slim\App( ["settings" => $config] );

$app->get( '/', function() use ( $app )
{
    $this->response->withHeader('LobbyMirror-Version', $this->get('settings')->get('lobbymirror')['version'] );

    // try to capture right UID and set the cookie
    $profile = $this->get('settings')->get('profile');
    if ( array_key_exists( 'uid', $_GET ) && array_key_exists( $_GET['uid'], $profile ) )
    {
        $uid = $_GET['uid'];

        // creating cookie
        $this->response = Dflydev\FigCookies\FigResponseCookies::set( $this->response, Dflydev\FigCookies\SetCookie::create( 'uid' )
                                                                     ->withValue( $uid )
                                                                     ->withExpires( time() + 31536000 )
                                                                     ->withPath( '/' )
                                                                     ->withSecure( true )
                                                                     ->withHttpOnly( true )
                                                                    );
    }
    else
    {
        // getting cookie
        $uid = Dflydev\FigCookies\FigRequestCookies::get( $this->request, 'uid', 'default' )->getValue();

        // creating cookie
        $this->response = Dflydev\FigCookies\FigResponseCookies::set( $this->response, Dflydev\FigCookies\SetCookie::create( 'uid' )
                                                                     ->withValue( $uid )
                                                                     ->withExpires( time() + 31536000 )
                                                                     ->withPath( '/' )
                                                                     ->withSecure( true )
                                                                     ->withHttpOnly( true )
                                                                    );
    }

    ?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>LobbyMirror by Lindberg</title>
        <meta name="author" content="Tobias Lindberg">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="refresh" content="<?php echo $this->get('settings')->get('lobbymirror')['reload']; ?>" />
        <link rel="icon" type="image/x-icon" href="favicon.ico" />
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/weather-icons.min.css" media="screen">
        <link rel="stylesheet" href="css/lobby-custom.css?v=<?php echo $this->get('settings')->get('lobbymirror')['version']; ?>" media="screen">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="js/html5shiv.js"></script>
            <script src="js/respond.min.js"></script>
        <![endif]-->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            ga('create', '<?php echo $this->get('settings')->get('lobbymirror')['GoogleAnalytics']; ?>', 'auto');
            ga('send', 'pageview');

        </script>
    </head>
    <body>
        <?php
        if ( array_key_exists( 'show', $_GET ) && $_GET['show'] == 'toolbar' )
        {
            ?>

            <div class="navbar navbar-default navbar-fixed-top">
                <div class="container" style="width:100%;" >
                    <div class="navbar-header">
                        <a href="/" class="navbar-brand">LobbyMirror</a>
                        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="navbar-collapse collapse" id="navbar-main">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="/?uid=<?php echo $uid; ?>&show=dateandweather">Date and weather</a>
                            </li>
                            <li>
                                <a href="/?uid=<?php echo $uid; ?>&show=commuter">Commuter</a>
                            </li>
                        </ul>

                        <!--
                        <ul class="nav navbar-nav navbar-right">
                        <li><a href="https://thelindberg.com/" target="_blank">thelindberg.com</a></li>
                        </ul>
                        -->

                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        
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
                if ( $this->get('settings')->get('profile')[$uid]['compliment'] !== false )
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
// make return on response, else cookies don't work
return $this->response;
} );


// get compliment information
$app->get( '/data/compliment', function() use ( $app )
{
    $this->response->withHeader('LobbyMirror-Version', $this->get('settings')->get('lobbymirror')['version'] );

    $ret = '';
    header("Content-Type: application/json");

    // select correct compliment depending on time of day
    if ( date( "H" ) >= 3 && date( "H" ) < 12 )
        $compliments = $this->get('settings')->get('compliment')['morning'];
    elseif ( date( "H" ) >= 12 && date( "H" ) < 17 )
        $compliments = $this->get('settings')->get('compliment')['afternoon'];
    else
        $compliments = $this->get('settings')->get('compliment')['evening'];
    
    // pick random compliment of array
    $ret = $compliments[ array_rand( $compliments ) ];

    echo json_encode( $ret );
    exit;
} );

// get weather information
$app->get( '/data/weather', function() use ( $app )
{
    $this->response->withHeader('LobbyMirror-Version', $this->get('settings')->get('lobbymirror')['version'] );

    // getting cookie
    $uid = Dflydev\FigCookies\FigRequestCookies::get( $this->request, 'uid', 'default' )->getValue();
    if ( ! ( $uid != '' ) )
        $uid = 'default';

    require_once( 'inc/forecast-io.php' );

    $forecast = new \Forecast\Forecast( $this->get('settings')->get('forecast')['apikey'] );
    $weather = $forecast->get(
        $this->get('settings')->get('profile')[$uid]['forecast']['latitude'],
        $this->get('settings')->get('profile')[$uid]['forecast']['longitude'],
        null,
        $this->get('settings')->get('forecast')['options']
    );

    $ret = '';
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
$app->get( '/data/sl', function($request, $response, $args) use ( $app )
{
    return $response->withRedirect( '/data/sl/1', 301 );
});
$app->get( '/data/sl/{column}', function($request, $response, $args) use ( $app )
{
    $column = $request->getAttribute('column');
    $this->response->withHeader('LobbyMirror-Version', $this->get('settings')->get('lobbymirror')['version'] );

    // getting cookie
    $uid = Dflydev\FigCookies\FigRequestCookies::get( $this->request, 'uid', 'default' )->getValue();
    if ( ! ( $uid != '' ) )
        $uid = 'default';

    $ret = '';
    header("Content-Type: application/json");

    foreach ( $this->get('settings')->get('profile')[$uid]['commuter'][$column]['siteids'] as $siteid => $filters )
    {
        $sl = new \Curl\Curl();
        $sl->setOpt( CURLOPT_FOLLOWLOCATION, true );
        $SLrequest = array(
            'url'       => 'http://api.sl.se/api2/realtimedeparturesV4.json',
            'params'    => array(
                'key'           => $this->get('settings')->get('commuter')['apikey'],
                'siteid'        => $siteid,
                'TimeWindow'    => $this->get('settings')->get('profile')[$uid]['commuter'][$column]['siteids'][$siteid]['time'],
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
