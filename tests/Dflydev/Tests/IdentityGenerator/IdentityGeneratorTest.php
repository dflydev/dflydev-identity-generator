<?php

/*
 * This file is a part of dflydev/identity-generator.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Tests\IdentityGenerator;

use Dflydev\IdentityGenerator\IdentityGenerator;
use Dflydev\IdentityGenerator\Exception\GenerateException;
use Dflydev\IdentityGenerator\Exception\NonUniqueIdentityException;

class IdentityGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideGenerateWithSuggestion
     */
    public function testGenerateWithSuggestion($suggestion, $mob = null)
    {
        $dataStore = $this->getMock('Dflydev\IdentityGenerator\DataStore\DataStoreInterface');
        $generator = $this->getMock('Dflydev\IdentityGenerator\Generator\GeneratorInterface');

        $dataStore
            ->expects($this->once())
            ->method('storeIdentity')
            ->with($this->equalTo($suggestion))
            ->will($this->returnValue($suggestion));

        $identityGenerator = new IdentityGenerator($dataStore, $generator);
        if (null !== $mob) {
            $identityGenerator->setMob($mob);
        }

        $this->assertEquals($suggestion, $identityGenerator->generate($suggestion));
    }

    /**
     * @dataProvider provideGenerateWithSuggestion
     */
    public function testGenerateWithSuggestionException($suggestion, $mob = null)
    {
        $dataStore = $this->getMock('Dflydev\IdentityGenerator\DataStore\DataStoreInterface');
        $generator = $this->getMock('Dflydev\IdentityGenerator\Generator\GeneratorInterface');

        $dataStore
            ->expects($this->any())
            ->method('storeIdentity')
            ->with($this->equalTo($suggestion))
            ->will($this->throwException(new GenerateException($suggestion, $mob)));

        $identityGenerator = new IdentityGenerator($dataStore, $generator);
        if (null !== $mob) {
            $identityGenerator->setMob($mob);
        }

        try {
            $identityGenerator->generate($suggestion);

            $this->fail("Should throw an exception");
        } catch (GenerateException $e) {
            $this->assertContains('new identity: '.$suggestion, $e->getMessage());
            $this->assertEquals($suggestion, $e->getIdentity());
            $this->assertEquals($mob, $e->getMob());
        }
    }

    public function testGenerateNoSuggestion()
    {
        foreach (array(null, 'MOB000') as $mob) {
            $dataStore = $this->getMock('Dflydev\IdentityGenerator\DataStore\DataStoreInterface');
            $generator = $this->getMock('Dflydev\IdentityGenerator\Generator\GeneratorInterface');

            $generator
                ->expects($this->any())
                ->method('generateIdentity')
                ->will($this->returnValue('AAA'));
            $dataStore
                ->expects($this->any())
                ->method('storeIdentity');

            $identityGenerator = new IdentityGenerator($dataStore, $generator);
            if (null !== $mob) {
                $identityGenerator->setMob($mob);
            }

            $this->assertEquals('AAA', $identityGenerator->generate());
        }
    }

    public function testGenerateMaxRetriesExhausted()
    {
        foreach (array(0, 5, 25) as $maxRetries) {
            foreach (array(null, 'MOB000') as $mob) {
                $dataStore = $this->getMock('Dflydev\IdentityGenerator\DataStore\DataStoreInterface');
                $generator = $this->getMock('Dflydev\IdentityGenerator\Generator\GeneratorInterface');

                $generator
                    ->expects($this->any())
                    ->method('generateIdentity')
                    ->will($this->returnValue('AAA'));
                $dataStore
                    ->expects($this->any())
                    ->method('storeIdentity')
                    ->will($this->throwException(new NonUniqueIdentityException('AAA', $mob)));

                $identityGenerator = new IdentityGenerator($dataStore, $generator);
                $identityGenerator->setMaxRetries($maxRetries);
                if (null !== $mob) {
                    $identityGenerator->setMob($mob);
                }

                try {
                    $identityGenerator->generate();
                } catch (GenerateException $e) {
                    $this->assertEquals($maxRetries + 1, count($e->getReasons()));
                    foreach ($e->getReasons() as $reason) {
                        $this->assertEquals('AAA', $reason->getIdentity());
                        $this->assertEquals($mob, $reason->getMob());
                    }
                }
            }
        }
    }

    public function testGenerateMaxRetriesException()
    {
        foreach (array(null, 'MOB000') as $mob) {
            $dataStore = $this->getMock('Dflydev\IdentityGenerator\DataStore\DataStoreInterface');
            $generator = $this->getMock('Dflydev\IdentityGenerator\Generator\GeneratorInterface');

            $generator
                ->expects($this->any())
                ->method('generateIdentity')
                ->will($this->returnValue('AAA'));
            $dataStore
                ->expects($this->any())
                ->method('storeIdentity')
                ->will($this->throwException(new \RuntimeException("Who Knows Why")));

            $identityGenerator = new IdentityGenerator($dataStore, $generator);
            if (null !== $mob) {
                $identityGenerator->setMob($mob);
            }

            try {
                $identityGenerator->generate();
            } catch (GenerateException $e) {
                $this->assertEquals('Who Knows Why', $e->getPrevious()->getMessage());
            }
        }
    }

    public function provideGenerateWithSuggestion()
    {
        return array(
            array('foo'),
            array('foo', 'bar'),
            array('hello'),
            array('hello', 'world'),
        );
    }
}
