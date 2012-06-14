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

use Dflydev\Base32\Crockford\Crockford;
use Dflydev\IdentityGenerator\Generator\Base32CrockfordGenerator;
use Dflydev\IdentityGenerator\Generator\RandomNumberGenerator;

class IdentityGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!class_exists('Dflydev\Base32\Crockford\Crockford')) {
            $this->markTestSkipped('The Base32 Crockford library is not available');
        }
    }

    public function testGenerator()
    {
        for ($i = 0; $i < 1000; $i++) {
            $generator = new Base32CrockfordGenerator();

            $identity = $generator->generateIdentity();

            $this->assertEquals(Crockford::normalize($identity), $identity);
            $this->assertEquals(Crockford::decode($identity), $generator->getLastSeedValue());
        }
    }

    public function testGeneratorWithChecksum()
    {
        for ($i = 0; $i < 1000; $i++) {
            $generator = new Base32CrockfordGenerator();
            $generator->setWithChecksum(true);

            $identity = $generator->generateIdentity();

            $this->assertEquals(Crockford::normalize($identity), $identity);
            $this->assertEquals(Crockford::decodeWithChecksum($identity), $generator->getLastSeedValue());
        }
    }

    /**
     * @dataProvider provideKnownValues
     */
    public function testKnownValues($decodedValue, $encodedValue, $encodedValueWithChecksum)
    {
        $randomNumberGenerator = new RandomNumberGenerator($decodedValue, $decodedValue);
        $generator = new Base32CrockfordGenerator($randomNumberGenerator);

        $identity = $generator->generateIdentity();

        $this->assertEquals($decodedValue, $generator->getLastSeedValue());
        $this->assertEquals($encodedValue, $identity);

        $generator->setWithChecksum(true);

        $identity = $generator->generateIdentity();

        $this->assertEquals($decodedValue, $generator->getLastSeedValue());
        $this->assertEquals($encodedValueWithChecksum, $identity);
    }

    public function provideKnownValues()
    {
        return array(
            array(0, '0', '00', false),
            array(1, '1', '11', false),
            array(2, '2', '22', false),
            array(194, '62', '629', false),
            array(456789, 'DY2N', 'DY2NR', false),
            array(398373, 'C515', 'C515Z', false),
            array(519571, 'FVCK', 'FVCKH', false),
        );
    }
}
