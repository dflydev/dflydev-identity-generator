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
 * Mobs Unsupported Exception is thrown when the underlying data store does
 * not support mobs or was not configured correctly to support them.
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class MobsUnsupportedException extends Exception
{
    protected $identity;
    protected $mob;

    /**
     * Constructor
     *
     * @param string $identity Identifier
     * @param string $mob      Group identifier
     * @param string $message  Message
     */
    public function __construct($identity, $mob, $message = null)
    {
        $mobString = $mob ? ' (with mob '.$mob.')' : '';
        $messageString = $message ? ' ' . $message : '';
        parent::__construct('Mobs are unsupported under current configuration.'.$messageString.' '.$identity.$mobString);
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
