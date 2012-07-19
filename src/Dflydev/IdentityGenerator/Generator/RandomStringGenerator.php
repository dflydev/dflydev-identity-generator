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
 * Random String Generator
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class RandomStringGenerator implements GeneratorInterface
{
    /**
     * Letters and numbers
     *
     * @var array
     */
    public static $lettersAndNumbers = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Base32 Crockford allowable characters
     *
     * @var array
     */
    public static $base32Crockford = '0123456789ABCDEFGHJKMNPQRSTVWXYZ';

    /**
     * Length of generated string
     *
     * @var int
     */
    protected $length;

    /**
     * Allowed characters
     *
     * @var string
     */
    protected $allowedCharacters;

    /**
     * Constructor
     *
     * @param int    $length            Length of generated string
     * @param string $allowedCharacters Allowed characters in generated string
     */
    public function __construct($length, $allowedCharacters = null)
    {
        $this->length = $length;
        $this->allowedCharacters = null !== $allowedCharacters
            ? $allowedCharacters
            : static::$lettersAndNumbers;
    }

    /**
     * Set the allowed characters
     *
     * @param array $allowedCharacters Allowed characters
     *
     * @return RandomStringGenerator
     */
    public function setAllowedCharacters(array $allowedCharacters = null)
    {
        $this->allowedCharacters = $allowedCharacters;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function generateIdentity()
    {
        $out = '';
        $allowedMax = strlen($this->allowedCharacters) - 1;

        if ($allowedMax < 0) {
            throw new \LogicException("No allowed characters were specified, cannot generate an identity");
        }

        while ( strlen($out) < $this->length ) {
            $out .= $this->allowedCharacters[rand(0, $allowedMax)];
        }

        return $out;
    }

    /**
     * Create a letters and numbers (mixed case) Random String Generator
     *
     * @param int $length Length of generated string
     *
     * @return RandomStringGenerator
     */
    public static function createLettersAndNumbers($length)
    {
        return new static($length, static::$lettersAndNumbers);
    }

    /**
     * Create a Base32 Crockford Random String Generator
     *
     * @param int $length Length of generated string
     *
     * @return RandomStringGenerator
     */
    public static function createBase32Crockford($length)
    {
        return new static($length, static::$base32Crockford);
    }
}
