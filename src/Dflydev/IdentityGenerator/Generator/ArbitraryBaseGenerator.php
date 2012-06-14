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

/**
 * Simple Arbitrary Base implementation of the Generator interfacoe.
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ArbitraryBaseGenerator extends AbstractSeededGenerator
{
    public static $BASE32_CROCKFORD = array(
        '0', '1', '2', '3', '4',
        '5', '6', '7', '8', '9',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',
        'J', 'K', 'M', 'N', 'P', 'Q', 'R', 'S',
        'T', 'V', 'W', 'X', 'Y', 'Z',
    );

    /**
     * Encode number using only values from symbols
     *
     * @param array $symbols Symbols to choose from
     * @param int   $number  Number to encode
     *
     * @return string
     * @throws \RuntimeException
     */
    public static function encode($symbols, $number)
    {
        if (!is_numeric($number)) {
            throw new \RuntimeException("Specified number '{$number}' is not numeric");
        }

        if (!$number) {
            return $symbols[0];
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
     * @param GeneratorInterface|null $seedGenerator Underlying seed generator
     */
    public function __construct(GeneratorInterface $seedGenerator = null)
    {
        $this->setSeedGenerator($seedGenerator);
        $this->allowedChars = static::$BASE32_CROCKFORD;
    }

    /**
     * {@inheritdocs}
     */
    public function generateIdentity()
    {
        return static::encode($this->allowedChars, $this->generateSeed());
    }

    /**
     * Set allowed chars
     *
     * @param array $allowedChars
     *
     * @return ArbitraryBaseGenerator
     */
    public function setAllowedChars(array $allowedChars)
    {
        $this->allowedChars = $allowedChars;

        return $this;
    }
}
