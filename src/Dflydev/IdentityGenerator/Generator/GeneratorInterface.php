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
 * Defines the Generator interface
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
interface GeneratorInterface
{
    /**
     * Generate a string suitable to represent an identity
     *
     * @return string
     */
    public function generateIdentity();
}
