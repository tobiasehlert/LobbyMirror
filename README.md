# LobbyMirror

Web project that shows both departures for commuter within Sweden (by [trafiklab.se](https://www.trafiklab.se)) and weather information (by [openweathermap.org](https://openweathermap.org)).

### Table of Contents

- [How to use](#how-to-use)
  - [Installation](#installation)
  - [Configuration](#configuration)
  - [API tokens](#api-tokens)
- [Screenshots](#screenshots)
- [Credits](#credits)

## How to use

Clone to repository to a server of your choice running eg. Nginx and PHP.

If you don't have any at home, you can always go for an instance at [DigitalOcean](https://m.do.co/c/452a006a298d).

### Installation

The [composer.json](./composer.json) contains the required packages for the project to work, so use [composer](https://getcomposer.org) to get the required packages in place.

### Configuration

You need to place a config.php file in the root with a config that looks similar to the one in [config-example.php](./config-example.php).

Make a copy of config-example.php and call it config.php and update your settings to your likings.

```shell
cp config-example.php config.php
```

### API tokens

For the dashboard to fully work, you need to supply two API tokens.

#### ResRobot Timetables (by [trafiklab.se](https://www.trafiklab.se))

Link: [trafiklab.se/api/trafiklab-apis/resrobot-v21/timetables](https://www.trafiklab.se/api/trafiklab-apis/resrobot-v21/timetables/)

Since the API check quite frequently for updates, you need to upgrade to a higher level or limit the dashboard.

By default you only get 30 000 requests per month, which is not sufficiently.

#### Weatherforcast with OpenWeather

Link: [openweathermap.org](https://openweathermap.org)

You need to register an account and get an API key.

By default you get 1 000 API calls per day for free, which should be sufficient.

## Screenshots

This is the view of LobbyMirror in a browser:

![LobbyMirror in a browser](./screenshots/lobbymirror.png)

This is how it's looking on a tablet:

![LobbyMirror on a tablet](./screenshots/lobbymirror-tablet.jpg)

## Credits

- Authors: Tobias Lindberg – [List of contributors](https://github.com/tobiasehlert/LobbyMirror/graphs/contributors)
- Distributed under MIT License
