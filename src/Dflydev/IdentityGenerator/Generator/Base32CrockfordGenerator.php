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

/**
 * Base32 Crockford implementation of the Generator Interface.
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class Base32CrockfordGenerator extends AbstractSeededGenerator
{
    protected $withChecksum = false;

    /**
     * Constructor
     *
     * @param GeneratorInterface|null $seedGenerator
     */
    public function __construct(GeneratorInterface $seedGenerator = null)
    {
        $this->setSeedGenerator($seedGenerator);
    }

    /**
     * {@inheritdocs}
     */
    public function generateIdentity()
    {
        return $this->withChecksum
            ? Crockford::encodeWithChecksum($this->generateSeed())
            : Crockford::encode($this->generateSeed())
        ;
    }

    /**
     * Generate strings with checksum?
     *
     * @param bool $withChecksum
     *
     * @return Base32CrockfordGenerator
     */
    public function setWithChecksum($withChecksum)
    {
        $this->withChecksum = $withChecksum;

        return $this;
    }
}
