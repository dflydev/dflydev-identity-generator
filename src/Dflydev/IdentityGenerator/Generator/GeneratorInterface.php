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

use Dflydev\IdentityGenerator\DataStore\DataStoreInterface;

interface GeneratorInterface
{
    /**
     * Generate a string suitable to represent an identity
     * 
     * @return string
     */
    public function generateIdentity();
}