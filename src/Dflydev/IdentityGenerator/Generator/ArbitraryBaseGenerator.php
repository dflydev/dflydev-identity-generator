<?php

/*
 * This file is a part of dflydev/identity-generator.
 * 
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\IdentityGenerator\Generator;

class ArbitraryBaseGenerator implements GeneratorInterface
{
    public static $BASE32_CROCKFORD = array(
        '0', '1', '2', '3', '4',
        '5', '6', '7', '8', '9',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',
        'J', 'K', 'M', 'N', 'P', 'Q', 'R', 'S',
        'T', 'V', 'W', 'X', 'Y', 'Z',
    );

    protected $minValue;
    protected $maxValue;
    protected $lastNumericValue;

    /**
     * Encode number using only values from symbols
     * 
     * @param array $symbols
     * @param int $number
     * @return string
     * @throws \RuntimeException
     */
    static public function encode($symbols, $number)
    {
        if (!is_numeric($number)) {
            throw new \RuntimeException("Specified number '{$number}' is not numeric");
        }

        if (!$number) {
            return 0;
        }

        $base = count($symbols);

        $response = array();
        while ($number) {
            $remainder = $number % $base;
            $number = (int) ($number/$base);
            $response[] = $symbols[$remainder];
        }

        return implode('', array_reverse($response));

    }

    /**
     * Constructor
     * 
     * @param int $minValue
     * @param int|null $maxValue Defaults to mt_getrandmax()
     */
    public function __construct($minValue = 0, $maxValue = null)
    {
        $this->allowedChars = static::$BASE32_CROCKFORD;
        $this->minValue = $minValue;
        $this->maxValue = null === $maxValue ? mt_getrandmax() : $maxValue;
    }

    /**
     * {@inheritdocs}
     */
    public function generateIdentity()
    {
        $this->lastNumericValue = mt_rand($this->minValue, $this->maxValue);

        return static::encode($this->allowedChars, $this->lastNumericValue);
    }

    /**
     * Last numeric value created by generator
     * 
     * There are few reasons (outside of testing) that might require this
     * value to be exposed. Probably best to forget that it exists.
     * 
     * @return int|null
     */
    public function getLastNumericValue()
    {
        return $this->lastNumericValue;
    }

    /**
     * Set allowed chars
     * 
     * @param array $allowedChars
     * @return ArbitraryBaseGenerator
     */
    public function setAllowedChars(array $allowedChars)
    {
        $this->allowedChars = array();

        return $this;
    }
}