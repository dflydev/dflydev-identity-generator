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

use Dflydev\Base32\Crockford\Crockford;

class Base32CrockfordGenerator implements GeneratorInterface
{
    protected $minValue;
    protected $maxValue;
    protected $withChecksum = false;
    protected $lastNumericValue;

    /**
     * Constructor
     * 
     * @param int $minValue
     * @param int|null $maxValue Defaults to mt_getrandmax()
     */
    public function __construct($minValue = 0, $maxValue = null)
    {
        $this->minValue = $minValue;
        $this->maxValue = null === $maxValue ? mt_getrandmax() : $maxValue;
    }

    /**
     * {@inheritdocs}
     */
    public function generateIdentity()
    {
        $this->lastNumericValue = mt_rand($this->minValue, $this->maxValue);

        return $this->withChecksum
            ? Crockford::encodeWithChecksum($this->lastNumericValue)
            : Crockford::encode($this->lastNumericValue)
        ;
    }

    /**
     * Generate strings with checksum?
     * 
     * @param bool $withChecksum
     */
    public function setWithChecksum($withChecksum)
    {
        $this->withChecksum = $withChecksum;
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
}