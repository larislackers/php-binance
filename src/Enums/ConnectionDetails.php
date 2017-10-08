<?php

namespace Larislackers\BinanceApi\Enums;

/**
 * Enum constants for Binance API connection.
 *
 * @package Larislackers\BinanceApi\Enums
 */
final class ConnectionDetails extends BasicEnum
{
    const API_URL = 'https://www.binance.com/';
    const API_VERSION = 'api/v1/';
    const API_VERSION_SIGNED = 'api/v3/';
    const WEBSOCKET_URL = 'wss://stream.binance.com:9443/ws/';
}
