<?php

/*
 * This file is a part of dflydev/identity-generator.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\IdentityGenerator\Exception;

/**
 * Non Unique Identity Exception is thrown  when a requested identifier
 * and mob combination are not unique.
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class NonUniqueIdentityException extends Exception
{
    protected $identity;
    protected $mob;

    /**
     * Constructor
     *
     * @param string $identity Identifier
     * @param string $mob      Group identifier
     */
    public function __construct($identity, $mob = null)
    {
        $mobString = $mob ? ' (with mob '.$mob.')' : '';
        parent::__construct("Could not store generated identity as it is not unique: ".$identity.$mobString);
        $this->identity = $identity;
        $this->mob = $mob;
    }

    /**
     * Identity
     *
     * @return string
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Mob
     *
     * @return string
     */
    public function getMob()
    {
        return $this->mob;
    }
}
