<?php

namespace Larislackers\BinanceApi\Exception;

/**
 * Class BinanceApiException
 *
 * @package \Larislackers\BinanceApi\Exception
 */
class BinanceApiException extends \Exception
{
    /**
     * Error code.
     *
     * @var int
     */
    protected $code;

    /**
     * Error message.
     *
     * @var string
     */
    protected $message;

    /**
     * BinanceApiException constructor.
     *
     * @param string          $message  The exception message.
     * @param int             $code     The exception code.
     * @param \Exception|null $previous The previous exceptions.
     */
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        $this->_decodeBinanceException($message);
        parent::__construct($this->message, $this->code, $previous);
    }

    /**
     * String representation of the exception.
     *
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . ': [' . $this->code . ']: ' . $this->message;
    }

    /**
     * Decodes received exception message.
     *
     * @param string $message The exception message.
     */
    private function _decodeBinanceException($message)
    {
        $msg = json_decode($message, true);
        $this->code = isset($msg['code']) ? $msg['code'] : 0;
        $this->message = isset($msg['msg']) ? $msg['msg'] : '';
    }
}
