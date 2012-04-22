<?php

/*
 * This file is a part of dflydev/identity-generator.
 * 
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\IdentityGenerator\DataStore;

interface DataStoreInterface
{
    /**
     * Store an identity
     * 
     * @param string $identity
     * @param string|null $mob
     */
    public function storeIdentity($identity, $mob = null);
}