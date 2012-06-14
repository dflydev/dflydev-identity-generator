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

abstract class AbstractSeededGenerator implements GeneratorInterface
{
    private $lastNumericValue;
    private $seedGenerator;

    protected function setSeedGenerator(GeneratorInterface $seedGenerator = null)
    {
        $this->seedGenerator = $seedGenerator;

        return $this;
    }

    protected function generateSeed()
    {
        if (null === $this->seedGenerator) {
            $this->seedGenerator = new RandomNumberGenerator;
        }

        return $this->lastSeedValue = $this->seedGenerator->generateIdentity();
    }

    /**
     * Last seed value created by seed generator
     *
     * There are few reasons (outside of testing) that might require this
     * value to be exposed. Probably best to forget that it exists.
     *
     * @return int|null
     */
    public function getLastSeedValue()
    {
        return $this->lastSeedValue;
    }
}
