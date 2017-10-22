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

### 1. List of products (pairs) currently listed on Binance.
```php
$bac->getProducts();
```

### 2. Ping connectivity
```php
$bac->ping();
```

### 3. Get server time
```php
$bac->getServerTime();
```

### 4. All orders for a symbol
```php
$bac->getOrderBook(['symbol' => 'BNBBTC']);
```

### 5. Aggregate trades list
```php
$bac->getAggTrades(['symbol' => 'BNBBTC']);
```

### 6. Kline/candlestick bars for a symbol
```php
$bac->getKlines(['symbol' => 'BNBBTC']);
```

### 7. 24 hour price change statistics
```php
$bac->getTwentyFourTickerPrice(['symbol' => 'BNBBTC']);
```

### 8. Latest price for all symbols
```php
$bac->getTickers();
```

### 9. Symbols order book ticker
```php
$bac->getBookTickers();
```

### 10a. Place a LIMIT order
```php
$bac->postOrder(['symbol' => 'BNBBTC', 'timestamp' => time() * 1000, 'quantity' => $quantity, 'price' => $price, 'timeInForce' => BinanceApi::TIME_IN_FORCE_GOOD_TILL_CANCELLED]);
```

### 10b. Place a MARKET order
```php
$bac->postOrder(['symbol' => 'BNBBTC', 'timestamp' => time() * 1000, 'quantity' => $quantity, 'timeInForce' => $timeInForce]);
```

### 10c. Place a STOP LOSS order
```php
$bac->postOrder(['symbol' => 'BNBBTC', 'timestamp' => time() * 1000, 'quantity' => $quantity, 'price' => $price, 'stopPrice' => $stopPrice, 'timeInForce' => $timeInForce]);
```

### 10d. Place an ICEBERG order
```php
$bac->postOrder(['symbol' => 'BNBBTC', 'timestamp' => time() * 1000, 'quantity' => $quantity, 'price' => $price, 'icebergQty' => $icebergQty, 'timeInForce' => $timeInForce]);
```

### 11. Check an order's status
```php
$bac->getOrder(['symbol' => 'BNBBTC', 'orderId' => $orderId, 'timestamp' => time() * 1000]);
```

### 12. Cancel an active order
```php
$bac->cancelOrder(['symbol' => 'BNBBTC', 'orderId' => $orderId, 'timestamp' => time() * 1000]);
```

### 13. All open orders on a symbol
```php
$bac->getOpenOrders(['symbol' => 'BNBBTC', 'timestamp' => time() * 1000]);
```

### 14. All account orders; active, canceled, or filled
```php
$bac->getOrders(['symbol' => 'BNBBTC', 'timestamp' => time() * 1000])
```

### 15. Account information
```php
$bac->getAccount(['timestamp' => time() * 1000]);
```

### 16. Trades for a specific account and symbol
```php
$bac->getTrades(['symbol' => 'BNBBTC', 'timestamp' => time() * 1000]);
```

### 17. Start a new user data stream
```php
$bac->startUserDataStream();
```

### 18. PING a user data stream to prevent a time out
```php
$bac->keepaliveUserDataStream(['listenKey' => $listenKey]);
```

### 19. Close out a user data stream
```php
$bac->closeUserDataStream(['listenKey' => $listenKey]);
```

### 20. Websocket for depth
```php
$bac->depthWebsocket(['symbol' => 'BNBBTC']);
```

### 21. Websocket for kline
```php
$bac->klineWebsocket(['symbol' => 'BNBBTC', 'interval' => $interval]);
```

### 22. Websocket for trades
```php
$bac->tradesWebsocket(['symbol' => 'BNBBTC']);
```

### 23. Websocket for user data
```php
$bac->userWebsocket(['listenKey' => $listenKey]);
```


## Notes

_All parameters in the examples are the minimum required for each function and must be in array format. More information can be found in the comments (phpdoc) and the links to the corresponding functions documented at Binance._

**Avoid to use hardcoded values**; enums are available (for intervals, types, sides, etc) for consistency and compliance with the Binance API.

**You should use your own logger (like [Sentry](https://sentry.io/welcome/))** and catch `BinanceApiException` for exceptions returned from Binance API and `LarislackersException` for exceptions returned from Websockets.

**More information on how to use the library can be found [here](https://larislackers.github.io/php-binance/).**

*See the official [API documentation](https://www.binance.com/restapipub.html) for more information about the endpoints and responses.*

## License

Larislackers-BinanceApi is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
