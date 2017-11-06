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

### 1. Ping connectivity
```php
$bac->ping();
```

### 2. Get server time
```php
$bac->getServerTime();
```

### 3. All orders for a symbol
```php
$bac->getOrderBook(['symbol' => 'BNBBTC']);
```

### 4. Aggregate trades list
```php
$bac->getAggTrades(['symbol' => 'BNBBTC']);
```

### 5. Kline/candlestick bars for a symbol
```php
$bac->getKlines(['symbol' => 'BNBBTC']);
```

### 6. 24 hour price change statistics
```php
$bac->getTwentyFourTickerPrice(['symbol' => 'BNBBTC']);
```

### 7. Latest price for all symbols
```php
$bac->getTickers();
```

### 8. Symbols order book ticker
```php
$bac->getBookTickers();
```

### 9a. Place a LIMIT order
```php
$bac->postOrder(['symbol' => 'BNBBTC', 'timestamp' => time() * 1000, 'quantity' => $quantity, 'price' => $price, 'timeInForce' => BinanceApi::TIME_IN_FORCE_GOOD_TILL_CANCELLED]);
```

### 9b. Place a MARKET order
```php
$bac->postOrder(['symbol' => 'BNBBTC', 'timestamp' => time() * 1000, 'quantity' => $quantity, 'timeInForce' => $timeInForce]);
```

### 9c. Place a STOP LOSS order
```php
$bac->postOrder(['symbol' => 'BNBBTC', 'timestamp' => time() * 1000, 'quantity' => $quantity, 'price' => $price, 'stopPrice' => $stopPrice, 'timeInForce' => $timeInForce]);
```

### 9d. Place an ICEBERG order
```php
$bac->postOrder(['symbol' => 'BNBBTC', 'timestamp' => time() * 1000, 'quantity' => $quantity, 'price' => $price, 'icebergQty' => $icebergQty, 'timeInForce' => $timeInForce]);
```

### 10. Check an order's status
```php
$bac->getOrder(['symbol' => 'BNBBTC', 'orderId' => $orderId, 'timestamp' => time() * 1000]);
```

### 11. Cancel an active order
```php
$bac->cancelOrder(['symbol' => 'BNBBTC', 'orderId' => $orderId, 'timestamp' => time() * 1000]);
```

### 12. All open orders on a symbol
```php
$bac->getOpenOrders(['symbol' => 'BNBBTC', 'timestamp' => time() * 1000]);
```

### 13. All account orders; active, canceled, or filled
```php
$bac->getOrders(['symbol' => 'BNBBTC', 'timestamp' => time() * 1000])
```

### 14. Account information
```php
$bac->getAccount(['timestamp' => time() * 1000]);
```

### 15. Trades for a specific account and symbol
```php
$bac->getTrades(['symbol' => 'BNBBTC', 'timestamp' => time() * 1000]);
```

### 16. Start a new user data stream
```php
$bac->startUserDataStream();
```

### 17. PING a user data stream to prevent a time out
```php
$bac->keepaliveUserDataStream(['listenKey' => $listenKey]);
```

### 18. Close out a user data stream
```php
$bac->closeUserDataStream(['listenKey' => $listenKey]);
```

### 19. Websocket for depth
```php
$bac->depthWebsocket(['symbol' => 'BNBBTC']);
```

### 20. Websocket for kline
```php
$bac->klineWebsocket(['symbol' => 'BNBBTC', 'interval' => $interval]);
```

### 21. Websocket for trades
```php
$bac->tradesWebsocket(['symbol' => 'BNBBTC']);
```

### 22. Websocket for user data
```php
$bac->userWebsocket(['listenKey' => $listenKey]);
```

### 23. Submit a withdraw request
```php
$bac->withdraw(['asset' => '', 'address' => $address, 'amount' => $amount, 'timestamp' => time() * 1000]);
```

### 24. Fetch deposit history
```php
$bac->getDepositHistory(['timestamp' => time() * 1000]);
```

### 25. Fetch withdraw history
```php
$bac->getWithdrawHistory(['timestamp' => time() * 1000]);
```

## Notes

_All parameters in the examples are the minimum required for each function and must be in array format. More information can be found in the comments (phpdoc) and the links to the corresponding functions documented at Binance._

**Avoid to use hardcoded values**; enums are available (for intervals, types, sides, etc) for consistency and compliance with the Binance API.

**You should use your own logger (like [Sentry](https://sentry.io/welcome/))** and catch `BinanceApiException` for exceptions returned from Binance API and `LarislackersException` for exceptions returned from Websockets.

**Don't reinvent the wheel** by trying to cache results in a request lifecycle with static classes. Use a framework that supports caching (like [Laravel](https://laravel.com/docs/5.5/cache)), an extension (like [Memcached](https://memcached.org/)) or using files. Additional information can be found [here](http://www.php-cache.com/en/latest/).

**More information on how to use the library can be found [here](https://larislackers.github.io/php-binance/).**

*See the official [API documentation](https://www.binance.com/restapipub.html) for more information about the endpoints and responses.*

## License

Larislackers-BinanceApi is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
