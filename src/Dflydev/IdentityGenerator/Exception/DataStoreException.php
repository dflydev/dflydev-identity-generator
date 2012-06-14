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
 * Data Store Exception is thrown when the underlying data store experiences
 * an unexpected exception. This might be connectivity issues, syntax issues,
 * etc.
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class DataStoreException extends Exception
{
    protected $identity;
    protected $mob;

    /**
     * Constructor
     *
     * @param \Exception $previous Previous exception
     * @param string     $identity Identifier
     * @param string     $mob      Group identifier
     */
    public function __construct(\Exception $previous, $identity, $mob = null)
    {
        $mobString = $mob ? ' (with mob '.$mob.')' : '';
        parent::__construct("Could not store generated identity for an unexpected reason: ".$identity.$mobString, $previous);
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
