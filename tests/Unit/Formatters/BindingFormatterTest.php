<?php

namespace LaravelSqlSpy\Tests\Unit\Formatters;

use Carbon\Carbon;
use DateTime;
use Illuminate\Foundation\Testing\WithFaker;
use LaravelSqlSpy\Formatters\BindingFormatter;
use LaravelSqlSpy\Tests\TestCase;

class BindingFormatterTest extends TestCase
{
    use WithFaker;

    public function testFormat()
    {
        $bindings = [
            $this->faker->lexify(),
            $this->faker->boolean(),
            $this->faker->randomNumber(),
            null,
            Carbon::now(),
            new DateTime(),
            $this,
        ];

        $formated_bindings = BindingFormatter::format($bindings);

        foreach ($formated_bindings as $formated_binding) {
            $this->assertIsString($formated_binding);
        }

        $this->assertSame($formated_bindings[0], $bindings[0]);
        $this->assertSame($formated_bindings[1], $bindings[1] ? '1' : '0');
        $this->assertSame($formated_bindings[2], (string) $bindings[2]);
        $this->assertSame($formated_bindings[3], 'NULL');
        $this->assertSame($formated_bindings[4], $bindings[4]->toDateTimeString());
        $this->assertSame($formated_bindings[5], $bindings[5]->format('Y-m-d H:i:s'));
        $this->assertSame($formated_bindings[6], '?');
    }
}
