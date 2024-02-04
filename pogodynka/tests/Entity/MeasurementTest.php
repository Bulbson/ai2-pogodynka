<?php

namespace App\Tests\Entity;

use App\Entity\Measurement;
use PHPUnit\Framework\TestCase;

class MeasurementTest extends TestCase
{
    public function dataGetFahrenheit(): array
    {
        return [
            ['0', 32],
            ['-100', -148],
            ['100', 212],
            ['41', 105.8],
            ['35', 95],
            ['14', 57.2],
            ['72', 161.6],
            ['89', 192.2],
            ['57', 134.6],
            ['11', 51.8],
            ['55', 131],
        ];
    }
    /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
        $measurement = new Measurement();

        #$measurement->setCelsius('0');
        #$this->assertEquals(32, $measurement->getFahrehneit());
        #$measurement->setCelsius('-100');
        #$this->assertEquals(-148, $measurement->getFahrehneit());
        #$measurement->setCelsius('100');
        #$this->assertEquals(212, $measurement->getFahrehneit());
        $measurement->setCelsius($celsius);
        $this->assertEquals($expectedFahrenheit, $measurement->getFahrehneit(), "Expected $expectedFahrenheit Fahrenheit for $celsius Celsius, got {$measurement->getFahrehneit()}");
    }
}
