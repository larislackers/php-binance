# Larislackers-BinanceApi

**Larislackers-BinanceApi** is a Binance.com API wrapper for PHP.

## Install

```php
composer require larislackers/php-binance
```

## Usage

_Information on how to obtain your API key and secret from Binance can be found [here](https://support.binance.com/hc/en-us/articles/115000840592-Binance-API-Beta)._

First things first, in order to use the API wrapper you should initialize it with the aforementioned key and secret like this:  

```php
$bac = new BinanceApiContainer('your_key', 'your_secret');
```

**More information on how to use the library can be found [here](https://larislackers.github.io/php-binance/).**

*See the official [API documentation](https://www.binance.com/restapipub.html) for more information about the endpoints and responses.*

## License

Larislackers-BinanceApi is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
