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

class NonUniqueIdentityException extends Exception
{
    protected $identity;
    protected $mob;

    public function __construct($identity, $mob = null)
    {
        $mobString = $mob ? ' (with mob '.$mob.')' : '';
        parent::__construct("Could not store generated identity as it is not unique: ".$identity.$mobString);
        $this->identity = $identity;
        $this->mob = $mob;
    }

    public function getIdentity()
    {
        return $this->identity;
    }

    public function getMob()
    {
        return $this->mob;
    }
}