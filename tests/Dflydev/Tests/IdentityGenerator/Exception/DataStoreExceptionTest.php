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

use Dflydev\IdentityGenerator\Exception\DataStoreException;

class DataStoreExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testThrowWithMob()
    {
        $previous = new \Exception('Previous Exception');
        try {
            throw new DataStoreException($previous, 'A', 'B');
            $this->fail('Expected exception was not thrown');
        } catch (DataStoreException $e) {
            $this->assertEquals('A', $e->getIdentity());
            $this->assertEquals('B', $e->getMob());
            $this->assertEquals('Could not store generated identity for an unexpected reason: A (with mob B)', $e->getMessage());
            $this->assertEquals('Previous Exception', $e->getPrevious()->getMessage());
        }
    }

    public function testThrowWithoutMob()
    {
        $previous = new \Exception('Previous Exception');
        try {
            throw new DataStoreException($previous, 'A');
            $this->fail('Expected exception was not thrown');
        } catch (DataStoreException $e) {
            $this->assertEquals('A', $e->getIdentity());
            $this->assertNull($e->getMob());
            $this->assertEquals('Could not store generated identity for an unexpected reason: A', $e->getMessage());
            $this->assertEquals('Previous Exception', $e->getPrevious()->getMessage());
        }
    }
}
