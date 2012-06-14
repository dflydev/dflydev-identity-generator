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
 * Generate Exception is thrown  when for whatever reason there is a problem
 * generating a new identity. This encompasses exceptions thrown from both
 * the Generator and the Data Store so this is a general all purpose exception.
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class GenerateException extends Exception
{
    protected $reasons = array();

    /**
     * Constructor
     *
     * @param string     $identity Identifier
     * @param string     $mob      Group identifier
     * @param array      $reasons  Array of reasons (exceptions) that the exception was thrown.
     * @param \Exception $previous Previous exception
     */
    public function __construct($identity = null, $mob = null, array $reasons = null, \Exception $previous = null)
    {
        $identityString = $identity ? ': '.$identity : '';
        $mobString = $mob ? ' (with mob '.$mob.')' : '';
        parent::__construct("Could not generate and store a new identity".$identityString.$mobString, 0, $previous);
        $this->identity = $identity;
        $this->mob = $mob;
        $this->reasons = $reasons;
    }

    /**
     * Identifier
     *
     * @return string
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Group identifier
     *
     * @return string
     */
    public function getMob()
    {
        return $this->mob;
    }

    /**
     * Array of reasons (exceptions) that the  exception was thrown.
     *
     * @return array
     */
    public function getReasons()
    {
        return $this->reasons;
    }
}
