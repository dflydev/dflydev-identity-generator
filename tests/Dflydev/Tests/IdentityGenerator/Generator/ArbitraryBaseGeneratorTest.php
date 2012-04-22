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

class ArbitraryBaseGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideKnownBase32CrockfordValues
     */
    public function testEncode($decodedValue, $encodedValue)
    {
        $this->assertEquals($encodedValue, ArbitraryBaseGenerator::encode(ArbitraryBaseGenerator::$BASE32_CROCKFORD, $decodedValue));
    }

    /**
     * @dataProvider provideKnownBase32CrockfordValues
     */
    public function testKnownBase32CrockfordValues($decodedValue, $encodedValue)
    {
        $generator = new ArbitraryBaseGenerator($decodedValue, $decodedValue);

        $identity = $generator->generateIdentity();

        $this->assertEquals($decodedValue, $generator->getLastNumericValue());
        $this->assertEquals($encodedValue, $identity);
    }

    /**
     * @dataProvider provideKnownValues
     */
    public function testKnownValues($allowedChars, $decodedValue, $encodedValue)
    {
        //
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
            array(array('a', 'b', 'c'), 3, 'a'),
        );
    }
}