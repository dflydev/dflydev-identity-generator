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

/**
 * Defines the data store interface
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
interface DataStoreInterface
{
    /**
     * Store an identity
     *
     * @param string      $identity Identity
     * @param string|null $mob      Group identifier
     */
    public function storeIdentity($identity, $mob = null);
}
