<?php

/*
 * This file is a part of dflydev/identity-generator.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Tests\IdentityGenerator\Generator;

use Dflydev\IdentityGenerator\Generator\RandomStringGenerator;

class RandomStringGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerator()
    {
        for ($i = 0; $i < 1000; $i++) {
            $generator = new RandomStringGenerator(10);

            $identity = $generator->generateIdentity();

            $this->assertEquals(10, strlen($identity));
        }
    }

    public function testGeneratorWithAllowedCharacters()
    {
        $generator = new RandomStringGenerator(10, 'a');

        $identity = $generator->generateIdentity();

        $this->assertEquals(10, strlen($identity));
        $this->assertEquals('aaaaaaaaaa', $identity);

        $generator = new RandomStringGenerator(10, 'abc');

        $identity = $generator->generateIdentity();

        $this->assertEquals(10, strlen($identity));
        $this->assertEquals(0, preg_match('/[^abc]/', $identity));
    }
}
