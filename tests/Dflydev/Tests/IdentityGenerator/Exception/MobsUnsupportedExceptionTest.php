<?php

/*
 * This file is a part of dflydev/identity-generator.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Tests\IdentityGenerator\Exception;

use Dflydev\IdentityGenerator\Exception\MobsUnsupportedException;

class MobsUnsupportedExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testThrowNoMessage()
    {
        try {
            throw new MobsUnsupportedException('A', 'B');
            $this->fail('Expected exception was not thrown');
        } catch (MobsUnsupportedException $e) {
            $this->assertEquals('A', $e->getIdentity());
            $this->assertEquals('B', $e->getMob());
            $this->assertEquals('Mobs are unsupported under current configuration. A (with mob B)', $e->getMessage());
        }
    }

    public function testThrowMessage()
    {
        try {
            throw new MobsUnsupportedException('A', 'B', 'Some Reason Here.');
            $this->fail('Expected exception was not thrown');
        } catch (MobsUnsupportedException $e) {
            $this->assertEquals('A', $e->getIdentity());
            $this->assertEquals('B', $e->getMob());
            $this->assertEquals('Mobs are unsupported under current configuration. Some Reason Here. A (with mob B)', $e->getMessage());
        }
    }
}
