<?php

namespace Larislackers\BinanceApi\Enums;

/**
 * A class to contain all ENUMS as specified by the official Binance API.
 *
 * @package Larislackers\BinanceApi\Enums
 *
 * @see     https://www.binance.com/restapipub.html#user-content-enum-definitions
 */
final class BinanceApi extends BasicEnum
{
    const SYMBOL_TYPE_SPOT = 'SPOT';

    const ORDER_STATUS_NEW = 'NEW';
    const ORDER_STATUS_PARTIALLY_FILLED = 'PARTIALLY_FILLED';
    const ORDER_STATUS_FILLED = 'FILLED';
    const ORDER_STATUS_CANCELED = 'CANCELED';
    const ORDER_STATUS_PENDING_CANCEL = 'PENDING_CANCEL';
    const ORDER_STATUS_REJECTED = 'REJECTED';
    const ORDER_STATUS_EXPIRED = 'EXPIRED';

    const ORDER_TYPE_LIMIT = 'LIMIT';
    const ORDER_TYPE_MARKET = 'MARKET';

    const SIDE_ORDER_BUY = 'BUY';
    const SIDE_ORDER_SELL = 'SELL';

    const TIME_IN_FORCE_GOOD_TILL_CANCELLED = 'GTC';
    const TIME_IN_FORCE_IMMEDIATE_OR_CANCEL = 'IOC';

    const KLINE_INTERVAL_ONE_MINUTE = '1m';
    const KLINE_INTERVAL_THREE_MINUTES = '3m';
    const KLINE_INTERVAL_FIVE_MINUTES = '5m';
    const KLINE_INTERVAL_FIFTEEN_MINUTES = '15m';
    const KLINE_INTERVAL_THIRTY_MINUTES = '30m';
    const KLINE_INTERVAL_ONE_HOUR = '1h';
    const KLINE_INTERVAL_TWO_HOURS = '2h';
    const KLINE_INTERVAL_FOUR_HOURS = '4h';
    const KLINE_INTERVAL_SIX_HOURS = '6h';
    const KLINE_INTERVAL_EIGHT_HOURS = '8h';
    const KLINE_INTERVAL_TWELVE_HOURS = '12h';
    const KLINE_INTERVAL_ONE_DAY = '1d';
    const KLINE_INTERVAL_THREE_DAYS = '3d';
    const KLINE_INTERVAL_ONE_WEEK = '1w';
    const KLINE_INTERVAL_ONE_MONTH = '1M';

    const WAPI_DEPOSIT_STATUS_PENDING = 0;
    const WAPI_DEPOSIT_STATUS_SUCCESS = 1;

    const WAPI_WITHDRAW_STATUS_EMAIL_SENT = 0;
    const WAPI_WITHDRAW_STATUS_CANCELLED = 1;
    const WAPI_WITHDRAW_STATUS_AWAITING_APPROVAL = 2;
    const WAPI_WITHDRAW_STATUS_REJECTED = 3;
    const WAPI_WITHDRAW_STATUS_PROCESSING = 4;
    const WAPI_WITHDRAW_STATUS_FAILURE = 5;
    const WAPI_WITHDRAW_STATUS_COMPLETED = 6;
}
