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

use Dflydev\IdentityGenerator\Generator\ArbitraryBaseGenerator;
use Dflydev\IdentityGenerator\Generator\RandomNumberGenerator;

class ArbitraryBaseGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideKnownBase32CrockfordValues
     */
    public function testEncodeBase32CrockfordValues($decodedValue, $encodedValue)
    {
        $this->assertEquals($encodedValue, ArbitraryBaseGenerator::encode(ArbitraryBaseGenerator::$BASE32_CROCKFORD, $decodedValue));
    }

    /**
     * @dataProvider provideKnownBase32CrockfordValues
     */
    public function testKnownBase32CrockfordValues($decodedValue, $encodedValue)
    {
        $randomNumberGenerator = new RandomNumberGenerator($decodedValue, $decodedValue);
        $generator = new ArbitraryBaseGenerator($randomNumberGenerator);

        $identity = $generator->generateIdentity();

        $this->assertEquals($decodedValue, $generator->getLastSeedValue());
        $this->assertEquals($encodedValue, $identity);
    }

    /**
     * @dataProvider provideKnownValues
     */
    public function testEncode($allowedChars, $decodedValue, $encodedValue)
    {
        $this->assertEquals($encodedValue, ArbitraryBaseGenerator::encode($allowedChars, $decodedValue));
    }

    /**
     * @dataProvider provideKnownValues
     */
    public function testKnownValues($allowedChars, $decodedValue, $encodedValue)
    {
        $randomNumberGenerator = new RandomNumberGenerator($decodedValue, $decodedValue);
        $generator = new ArbitraryBaseGenerator($randomNumberGenerator);

        $generator->setAllowedChars($allowedChars);

        $identity = $generator->generateIdentity();

        $this->assertEquals($decodedValue, $generator->getLastSeedValue());
        $this->assertEquals($encodedValue, $identity);
    }

    public function testEncodeException()
    {
        try {
            ArbitraryBaseGenerator::encode(ArbitraryBaseGenerator::$BASE32_CROCKFORD, 'hello');
        } catch (\RuntimeException $e) {
            $this->assertEquals('Specified number \'hello\' is not numeric', $e->getMessage());
        }
    }

    public function provideKnownBase32CrockfordValues()
    {
        return array(
            array(0, '0', false),
            array(1, '1', false),
            array(2, '2', false),
            array(194, '62', false),
            array(456789, 'DY2N', false),
            array(398373, 'C515', false),
            array(519571, 'FVCK', false),
        );
    }

    public function provideKnownValues()
    {
        return array(
            array(array('a', 'b', 'c'), 0, 'a'),
            array(array('a', 'b', 'c'), 1, 'b'),
            array(array('a', 'b', 'c'), 2, 'c'),
            array(array('a', 'b', 'c'), 3, 'ba'),
            array(array('a', 'b', 'c'), 4, 'bb'),
            array(array('a', 'b', 'c'), 5, 'bc'),
            array(array('a', 'b', 'c'), 6, 'ca'),
            array(array('a', 'b', 'c'), 7, 'cb'),
            array(array('a', 'b', 'c'), 8, 'cc'),
            array(array('a', 'b', 'c'), 9, 'baa'),
            array(array('a', 'b', 'c'), 10, 'bab'),
            array(array('a', 'b', 'c'), 11, 'bac'),
        );
    }
}
