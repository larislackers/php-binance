<?php

namespace Larislackers\BinanceApi;

use GuzzleHttp\Client;
use Larislackers\BinanceApi\Enums\ConnectionDetails;
use Larislackers\BinanceApi\Exception\BinanceApiException;
use Larislackers\BinanceApi\Exception\LarislackersException;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;

/**
 * Wrapper container for Binance API.
 *
 * @package Larislackers\BinanceApi
 */
class BinanceApiContainer
{
    /**
     * API key.
     *
     * @var string
     */
    private $_apiKey;

    /**
     * API secret.
     *
     * @var string
     */
    private $_apiSecret;

    /**
     * BinanceApiContainer constructor.
     *
     * @param string $apiKey    The API key from Binance.
     * @param string $apiSecret The API secret from Binance.
     */
    public function __construct($apiKey, $apiSecret)
    {
        $this->_apiKey = $apiKey;
        $this->_apiSecret = $apiSecret;
    }

    /**
     * Gets the API key.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->_apiKey;
    }

    /**
     * Gets the API secret.
     *
     * @return string
     */
    public function getApiSecret()
    {
        return $this->_apiSecret;
    }

    /**
     * Returns list of products currently listed on Binance.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getProducts()
    {
        return $this->_makeApiRequest('GET', 'exchange/public/product', 'WEB');
    }

    /**
     * Test connectivity to the Rest API.
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @link https://www.binance.com/restapipub.html#test-connectivity
     */
    public function ping()
    {
        return $this->_makeApiRequest('GET', 'ping');
    }

    /**
     * Test connectivity to the Rest API and get the current server time.
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @link https://www.binance.com/restapipub.html#check-server-time
     */
    public function getServerTime()
    {
        return $this->_makeApiRequest('GET', 'time');
    }

    /**
     * Returns the order book for the market.
     *
     * @param array $params The data to send.
     *      @option string "symbol" The symbol to search for. (required)
     *      @option int    "limit"  The number of results returned from the query. (max value 100)
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @link https://www.binance.com/restapipub.html#order-book
     */
    public function getOrderBook($params)
    {
        return $this->_makeApiRequest('GET', 'depth', 'NONE', $params);
    }

    /**
     * Returns compressed, aggregate trades.
     * Trades that fill at the time, from the same order, with the same price will have the quantity aggregated.
     *
     * @param array $params The data to send.
     *      @option string "symbol"    The symbol to search for. (required)
     *      @option int    "fromId"    ID to get aggregate trades from INCLUSIVE.
     *      @option int    "startTime" Timestamp in ms to get aggregate trades from INCLUSIVE.
     *      @option int    "endTime"   Timestamp in ms to get aggregate trades until INCLUSIVE.
     *      @option int    "limit"     The number of results returned from the query. (max value 500)
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     *
     * @link https://www.binance.com/restapipub.html#compressedaggregate-trades-list
     */
    public function getAggTrades($params)
    {
        return $this->_makeApiRequest('GET', 'aggTrades', 'NONE', $params);
    }

    /**
     * Returns kline/candlesticks bars for a symbol.
     * Klines are uniquely identified by their open time.
     *
     * @param array $params The data to send.
     *      @option string "symbol"    The symbol to search for. (required)
     *      @option string "interval"  Kline intervals enum. (required)
     *      @option int    "startTime" Timestamp in ms to get aggregate trades from INCLUSIVE.
     *      @option int    "endTime"   Timestamp in ms to get aggregate trades until INCLUSIVE.
     *      @option int    "limit"     The number of results returned from the query. (max value 500)
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @link  https://www.binance.com/restapipub.html#klinecandlesticks
     */
    public function getKlines($params)
    {
        return $this->_makeApiRequest('GET', 'klines', 'NONE', $params);
    }

    /**
     * Returns 24 hour price change statistics.
     *
     * @param array $params The data to send.
     *      @option string "symbol" The symbol to search for. (required)
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @link https://www.binance.com/restapipub.html#24hr-ticker-price-change-statistics
     */
    public function getTwentyFourTickerPrice($params)
    {
        return $this->_makeApiRequest('GET', 'ticker/24hr', 'NONE', $params);
    }

    /**
     * Returns latest price for all symbols.
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @link https://www.binance.com/restapipub.html#symbols-price-ticker
     */
    public function getTickers()
    {
        return $this->_makeApiRequest('GET', 'ticker/allPrices');
    }

    /**
     * Returns price/qty on the order book for all symbols.
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @link https://www.binance.com/restapipub.html#symbols-order-book-ticker
     */
    public function getBookTickers()
    {
        return $this->_makeApiRequest('GET', 'ticker/allBookTickers');
    }

    /**
     * Send in a new order.
     *
     * @param array $params The data to send.
     *      @option string "symbol"           The symbol to search for. (required)
     *      @option string "side"             Order side enum. (required)
     *      @option string "type"             Order type enum. (required)
     *      @option string "timeInForce"      Time in force enum. (required)
     *      @option double "quantity"         Desired quantity. (required)
     *      @option double "price"            Asking price. (required)
     *      @option string "newClientOrderId" A unique id for the order. Automatically generated by default.
     *      @option double "stopPrice"        Used with STOP orders.
     *      @option double "icebergQty"       Used with icebergOrders.
     *      @option int    "timestamp"        A UNIX timestamp. (required)
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @link https://www.binance.com/restapipub.html#new-order--signed
     */
    public function postOrder($params)
    {
        return $this->_makeApiRequest('POST', 'order', 'SIGNED', $params);
    }

    /**
     * Test new order creation and signature/recvWindow long.
     * Creates and validates a new order but does not send it into the matching engine.
     *
     * @param array $params The data to send.
     *      @option string "symbol"           The symbol to search for. (required)
     *      @option string "side"             Order side enum. (required)
     *      @option string "type"             Order type enum. (required)
     *      @option string "timeInForce"      Time in force enum. (required)
     *      @option double "quantity"         Desired quantity. (required)
     *      @option double "price"            Asking price. (required)
     *      @option string "newClientOrderId" A unique id for the order. Automatically generated by default.
     *      @option double "stopPrice"        Used with STOP orders.
     *      @option double "icebergQty"       Used with icebergOrders.
     *      @option int    "timestamp"        A UNIX timestamp. (required)
     *      @option int    "recvWindow"       The number of milliseconds after timestamp the request is valid for.
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @link https://www.binance.com/restapipub.html#test-new-order-signed
     */
    public function postOrderTest($params)
    {
        return $this->_makeApiRequest('POST', 'order/test', 'SIGNED', $params);
    }

    /**
     * Check an order's status.
     *
     * @param array $params The data to send.
     *      @option string "symbol"            The symbol to search for. (required)
     *      @option int    "orderId"           The order ID.
     *      @option string "origClientOrderId" The original client order ID.
     *      @option int    "timestamp"         A UNIX timestamp. (required)
     *      @option int    "recvWindow"        The number of milliseconds after timestamp the request is valid for.
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     *
     * @link https://www.binance.com/restapipub.html#query-order-signed
     */
    public function getOrder($params)
    {
        return $this->_makeApiRequest('GET', 'order', 'SIGNED', $params);
    }

    /**
     * Cancel an active order.
     *
     * @param array $params The data to send.
     *      @option string "symbol"            The symbol to search for. (required)
     *      @option int    "orderId"           The order ID.
     *      @option string "origClientOrderId" The original client order ID.
     *      @option string "newClientOrderId"  Used to uniquely identify this cancel. Automatically generated by default.
     *      @option int    "timestamp"         A UNIX timestamp. (required)
     *      @option int    "recvWindow"        The number of milliseconds after timestamp the request is valid for.
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     *
     * @link https://www.binance.com/restapipub.html#cancel-order-signed
     */
    public function cancelOrder($params)
    {
        return $this->_makeApiRequest('DELETE', 'order', 'SIGNED', $params);
    }

    /**
     * Returns all open orders on a symbol.
     *
     * @param array $params The data to send.
     *      @option string "symbol"     The symbol to search for. (required)
     *      @option int    "timestamp"  A UNIX timestamp. (required)
     *      @option int    "recvWindow" The number of milliseconds after timestamp the request is valid for.
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @link https://www.binance.com/restapipub.html#current-open-orders-signed
     */
    public function getOpenOrders($params)
    {
        return $this->_makeApiRequest('GET', 'openOrders', 'SIGNED', $params);
    }

    /**
     * Returns all account orders; active, canceled, or filled.
     *
     * @param array $params The data to send.
     *      @option string "symbol"     The symbol to search for. (required)
     *      @option int    "orderId"    The order ID.
     *      @option int    "timestamp"  A UNIX timestamp. (required)
     *      @option int    "limit"      The request limit, max value 500, min value 1.
     *      @option int    "recvWindow" The number of milliseconds after timestamp the request is valid for.
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @link https://www.binance.com/restapipub.html#all-orders-signed
     */
    public function getOrders($params)
    {
        return $this->_makeApiRequest('GET', 'allOrders', 'SIGNED', $params);
    }

    /**
     * Returns current account information.
     *
     * @param array $params The data to send.
     *      @option int "timestamp"  A UNIX timestamp. (required)
     *      @option int "recvWindow" The number of milliseconds after timestamp the request is valid for.
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @link https://www.binance.com/restapipub.html#account-information-signed
     */
    public function getAccount($params)
    {
        return $this->_makeApiRequest('GET', 'account', 'SIGNED', $params);
    }

    /**
     * Returns trades for a specific account and symbol.
     *
     * @param array $params The data to send.
     *      @option string "symbol"     The symbol to search for. (required)
     *      @option int    "fromId"     The order ID.
     *      @option int    "timestamp"  A UNIX timestamp. (required)
     *      @option int    "limit"      The number of results returned from the query. (max value 500)
     *      @option int    "recvWindow" The number of milliseconds after timestamp the request is valid for.
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @link https://www.binance.com/restapipub.html#account-trade-list-signed
     */
    public function getTrades($params)
    {
        return $this->_makeApiRequest('GET', 'myTrades', 'SIGNED', $params);
    }

    /**
     * Start a new user data stream.
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @link https://www.binance.com/restapipub.html#start-user-data-stream-api-key
     */
    public function startUserDataStream()
    {
        return $this->_makeApiRequest('POST', 'userDataStream', 'API-KEY');
    }

    /**
     * PING a user data stream to prevent a time out.
     *
     * @param array $params The data to send.
     *      @option string "listenKey" The key for the user's data steam. (required)
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @link https://www.binance.com/restapipub.html#keepalive-user-data-stream-api-key
     */
    public function keepaliveUserDataStream($params)
    {
        return $this->_makeApiRequest('PUT', 'userDataStream', 'API-KEY', $params);
    }

    /**
     * Close out a user data stream.
     *
     * @param array $params The data to send.
     *      @option string "listenKey" The key for the user's data steam. (required)
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @link https://www.binance.com/restapipub.html#close-user-data-stream-api-key
     */
    public function closeUserDataStream($params)
    {
        return $this->_makeApiRequest('DELETE', 'userDataStream', 'API-KEY', $params);
    }

    /**
     * Websocket url for depth endpoint.
     *
     * @param array $params The data to send.
     *      @option string "symbol" The symbol to search for. (required)
     *
     * @link https://www.binance.com/restapipub.html#depth-wss-endpoint
     */
    public function depthWebsocket($params)
    {
        $this->_makeWebsocketRequest('DEPTH', $params);
    }

    /**
     * Websocket url for kline endpoint.
     *
     * @param array $params The data to send.
     *      @option string "symbol"   The symbol to search for. (required)
     *      @option string "interval" Kline intervals enum. (required)
     *
     * @link https://www.binance.com/restapipub.html#kline-wss-endpoint
     */
    public function klineWebsocket($params)
    {
        $this->_makeWebsocketRequest('KLINE', $params);
    }

    /**
     * Websocket url for trades endpoint.
     *
     * @param array $params The data to send.
     *      @option string "symbol" The symbol to search for. (required)
     *
     * @link https://www.binance.com/restapipub.html#trades-wss-endpoint
     */
    public function tradesWebsocket($params)
    {
        $this->_makeWebsocketRequest('TRADES', $params);
    }

    /**
     * Websocket url for user data endpoint.
     *
     * @param array $params The data to send.
     *      @option string "listenKey" The key for the user's data steam. (required)
     *
     * @link https://www.binance.com/restapipub.html#user-wss-endpoint
     */
    public function userWebsocket($params)
    {
        $this->_makeWebsocketRequest('USER', $params);
    }

    /**
     * Does an HTTP request to the given endpoint with the given parameters.
     *
     * @param string $type         The HTTP method.
     * @param string $endPoint     The API endpoint.
     * @param string $securityType Security type enum.
     * @param array  $params       Additional parameters.
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws BinanceApiException
     */
    private function _makeApiRequest($type, $endPoint, $securityType = 'NONE', $params = [])
    {
        $params = array_filter($params, 'strlen');

        switch (strtoupper($securityType)) {
            default:
            case 'NONE':
                $client = new Client(['http_errors' => false]);
                $url = ConnectionDetails::API_URL . ConnectionDetails::API_VERSION . $endPoint;
                break;
            case 'API-KEY':
                $client = new Client(['headers' => ['X-MBX-APIKEY' => $this->_apiKey], 'http_errors' => false]);
                $url = ConnectionDetails::API_URL . ConnectionDetails::API_VERSION . $endPoint;
                break;
            case 'SIGNED':
                $client = new Client(['headers' => ['X-MBX-APIKEY' => $this->_apiKey], 'http_errors' => false]);
                $url = ConnectionDetails::API_URL . ConnectionDetails::API_VERSION_SIGNED . $endPoint;
                $params['signature'] = hash_hmac('sha256', http_build_query($params), $this->_apiSecret);
                break;
            case 'WEB':
                $client = new Client(['http_errors' => false]);
                $url = ConnectionDetails::API_URL . $endPoint;
                break;
        }

        switch (strtoupper($type)) {
            default:
            case 'GET':
                $params['query'] = $params;
                break;
            case 'POST':
            case 'PUT':
            case 'DELETE':
                $params['form_params'] = $params;
                break;
        }

        $response = $client->request(strtoupper($type), $url, $params);

        if ($response->getStatusCode() < 200 || $response->getStatusCode() > 299) {
            throw new BinanceApiException($response->getBody()->getContents());
        }

        return $response;
    }

    /**
     * Opens a websocket connection and transmits received messages until closed.
     *
     * @param string $type   The websocket method.
     * @param array  $params The parameters to send.
     * @param bool   $once   If true, it will close the connection after the first successful message.
     *
     * @return void
     * @throws \LarislackersException
     */
    private function _makeWebsocketRequest($type, $params, $once = false)
    {
        switch (strtoupper($type)) {
            default:
            case 'DEPTH':
                $url = ConnectionDetails::WEBSOCKET_URL . strtolower($params['symbol']) . '@depth';
                break;
            case 'KLINE':
                $url = ConnectionDetails::WEBSOCKET_URL . strtolower($params['symbol']) . '@kline_' . $params['interval'];
                break;
            case 'TRADES':
                $url = ConnectionDetails::WEBSOCKET_URL . strtolower($params['symbol']) . '@aggTrade';
                break;
            case 'USER':
                $url = ConnectionDetails::WEBSOCKET_URL . strtolower($params['symbol']);
                break;
        }

        \Ratchet\Client\connect($url)->then(function (WebSocket $conn) use ($once) {
            $conn->on('message', function (MessageInterface $msg) use ($conn, $once) {
                echo $msg . "\n";
                if ($once) $conn->close();
            });

            $conn->on('close', function ($code = null, $reason = null) {
                echo 'Connection closed (' . $code . ' - ' . $reason . ')';
            });

            $conn->on('error', function () {
                throw new LarislackersException('[ERROR|Websocket] Could not establish a connection.');
            });
        });
    }
}
