<?php

namespace Larislackers\BinanceApi\Enums;

use Larislackers\BinanceApi\Exception\LarislackersException;

/**
 * BasicEnum, used to contain the logic for validating keys/values against an enum.
 * Must be extended by all future enums.
 *
 * @package Larislackers\BinanceApi\Enums
 */
abstract class BasicEnum
{
    /**
     * Array of constants per called class, so far.
     *
     * @var array
     */
    private static $constCacheArray = NULL;

    /**
     * BasicEnum constructor.
     *
     * @throws \Exception
     */
    final private function __construct()
    {
        throw new LarislackersException('BasicEnum and subclasses cannot be instantiated.');
    }

    /**
     * Get an enum object's constants.
     * Uses reflection to determine called class and subsequently cache and return the results using the name as key.
     *
     * @return mixed
     */
    private static function getConstants()
    {
        if (self::$constCacheArray == NULL) self::$constCacheArray = [];

        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new \ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }

        return self::$constCacheArray[$calledClass];
    }

    /**
     * Validates the existence of a given attribute name against an enum.
     * Is not strict by default.
     *
     * @param string $name   The attribute to check.
     * @param bool   $strict Strict mode.
     *
     * @return bool
     */
    public static function isValidName($name, $strict = false)
    {
        $constants = self::getConstants();

        if ($strict) return array_key_exists($name, $constants);

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    /**
     * Validates the existence of a given value against an enum.
     * Is not strict by default, in case of strings.
     *
     * @param string $value  The value to check.
     * @param bool   $strict Strict mode.
     *
     * @return bool
     */
    public static function isValidValue($value, $strict = true)
    {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict);
    }
}
