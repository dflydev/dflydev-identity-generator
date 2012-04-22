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

class RandomNumberGenerator implements GeneratorInterface
{
    protected $minValue;
    protected $maxValue;

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
        return mt_rand($this->minValue, $this->maxValue);
    }
}