# Larislackers-BinanceApi

**Larislackers-BinanceApi** is a [Binance.com](https://binance.com) API wrapper for PHP. Moreover, the API wrapper **supports all available functionality** given from Binance **along with sockets**.

**All requests are following the [HTTP/1.1 protocol](https://tools.ietf.org/html/rfc2616) and all responses are returned as a [PSR-7](http://docs.guzzlephp.org/en/stable/psr7.html) [ResponseInterface](http://www.php-fig.org/psr/psr-7/).**

Tests are available after providing your key and secret in the corresponding class.

## Install

```php
composer require larislackers/php-binance
```

## Usage

_Information on how to obtain your API key and secret from Binance can be found [here](https://support.binance.com/hc/en-us/articles/115000840592-Binance-API-Beta)._

First things first, in order to use the API wrapper you should initialize it with the aforementioned key and secret like this:  

```php
$bac = new BinanceApiContainer('<your_key>', '<your_secret>');
```

Then, use the initiated object/var like this:

```php
// Get all orders for a symbol (BNB/BTC pair).
$orders = $bac->getOrderBook(['symbol' => 'BNBBTC']);
var_dump($orders->getBody()->getContents());
```

You may find the rest of the supported commands inside the [BinanceApiContainer](https://github.com/larislackers/php-binance/blob/master/src/BinanceApiContainer.php).

## Notes

_All parameters required for each function must be in array format. More information can be found in the comments (phpdoc) and the links to the corresponding functions documented at Binance._

**Avoid to use hardcoded values**; enums are available (for intervals, types, sides, etc) for consistency and compliance with the Binance API.

**You should use your own logger (like [Sentry](https://sentry.io/welcome/))** and catch `BinanceApiException` for exceptions returned from Binance API and `LarislackersException` for exceptions returned from Websockets.

**Don't reinvent the wheel** by trying to cache results in a request lifecycle with static classes. Use a framework that supports caching (like [Laravel](https://laravel.com/docs/5.5/cache)), an extension (like [Memcached](https://memcached.org/)) or using files. Additional information can be found [here](http://www.php-cache.com/en/latest/).

**More information on how to use the library can be found [here](https://larislackers.github.io/php-binance/).**

*See the official [API documentation](https://www.binance.com/restapipub.html) for more information about the endpoints and responses.*

## License

Larislackers-BinanceApi is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

## Donations/Support

If you find this library to your liking and enjoy using it, please consider a donation to one of the following addresses:
* BTC: 13rSaL7ze89Pz28fNR9cNCnNVNvLWR3eFt
* ETH: 0x03d4566d13ca7c7b30c39666b1f21ff97bee3f97
* XMR: 49hxHRNwLSdQcXuCcac3ySMnAEuH4BhLWR8NddjHi6QBJHNvj1LqcSg2X8qpTQgsE1brzt37W6dLiiSN6uCj1CwyUPNr8R5
