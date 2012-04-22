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

class GenerateException extends Exception
{
    protected $reasons = array();
    public function __construct($identity = null, $mob = null, array $reasons = null, $previous = null)
    {
        $identityString = $identity ? ': '.$identity : '';
        $mobString = $mob ? ' (with mob '.$mob.')' : '';
        parent::__construct("Could not generate and store a new identity".$identityString.$mobString, 0, $previous);
        $this->identity = $identity;
        $this->mob = $mob;
        $this->reasons = $reasons;
    }

    public function getIdentity()
    {
        return $this->identity;
    }

    public function getMob()
    {
        return $this->mob;
    }

    public function getReasons()
    {
        return $this->reasons;
    }
}