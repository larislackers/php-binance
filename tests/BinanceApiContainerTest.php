<?php

namespace Larislackers\BinanceApi\Tests;

use PHPUnit\Framework\TestCase;
use Larislackers\BinanceApi\BinanceApiContainer;
use Larislackers\BinanceApi\Exception\BinanceApiException;

/**
 * Class BinanceApiContainerTest
 *
 * @package Larislackers\BinanceApi\Tests
 */
class BinanceApiContainerTest extends TestCase
{
    /**
     * A Guzzle client object.
     *
     * @var \Larislackers\BinanceApi\BinanceApiContainer
     */
    private $_http;

    /**
     * Sets up the fixture.
     */
    public function setUp()
    {
        $this->_http = new BinanceApiContainer('', '');
    }

    /**
     * Tears down the fixture.
     */
    public function tearDown()
    {
        $this->_http = null;
    }

    /**
     * Testing latest price of a symbol functionality.
     */
    public function testLatestSymbolPrice()
    {
        $response = $this->_http->getTwentyFourTickerPrice(['symbol' => 'ETHBTC']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Testing order book / depth functionality.
     */
    public function testSymbolDepth()
    {
        $response = $this->_http->getOrderBook(['symbol' => 'ETHBTC', 'limit' => 100]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Testing order functionality (LIMIT).
     */
    public function testPlaceLimitOrder()
    {
        $response = $this->_http->postOrderTest([
            'symbol' => 'ETHBTC', 'side' => 'BUY', 'type' => 'LIMIT',
            'timeInForce' => 'GTC', 'quantity' => 1, 'price' => 0.1,
            'timestamp' => time() * 1000
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Testing order functionality (MARKET).
     */
    public function testPlaceMarketOrder()
    {
        $response = $this->_http->postOrderTest([
            'symbol' => 'ETHBTC', 'side' => 'BUY', 'type' => 'MARKET',
            'quantity' => 1, 'timestamp' => time() * 1000
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Testing order status functionality.
     */
    public function testOrderStatus()
    {
        $this->expectException(BinanceApiException::class);
        $this->_http->getOrder(['symbol' => 'ETHBTC', 'orderId' => 1, 'timestamp' => time() * 1000]);
    }

    /**
     * Testing open orders functionality.
     */
    public function testOpenOrdersList()
    {
        $response = $this->_http->getOpenOrders(['symbol' => 'ETHBTC', 'timestamp' => time() * 1000]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Testing list of trades functionality.
     */
    public function testCurrentPosition()
    {
        $response = $this->_http->getTrades(['symbol' => 'ETHBTC', 'timestamp' => time() * 1000]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Testing cancel order functionality.
     */
    public function testCancelOrder()
    {
        $this->expectException(BinanceApiException::class);
        $this->_http->cancelOrder(['symbol' => 'ETHBTC', 'orderId' => 1, 'timestamp' => time() * 1000]);
    }
}
