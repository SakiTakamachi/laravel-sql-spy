<?php

namespace LaravelSqlSpy\Tests\Unit\DataTransferObjects\Report;

use Illuminate\Foundation\Testing\WithFaker;
use LaravelSqlSpy\DataTransferObjects\Report\QueryLogDto;
use LaravelSqlSpy\Tests\TestCase;

class QueryLogDtoTest extends TestCase
{
    use WithFaker;

    public function testDtoGetters()
    {
        $query = $this->faker->lexify();
        $bindings = $this->faker->randomElements();
        $time = $this->faker->randomFloat();
        $backtrace = $this->faker->randomElements();

        $dto = new QueryLogDto(
            $query,
            $bindings,
            $time,
            $backtrace,
        );

        $this->assertSame($query, $dto->getQuery());
        $this->assertSame($bindings, $dto->getBindings());
        $this->assertSame($time, $dto->getTime());
        $this->assertSame($backtrace, $dto->getBacktrace());
    }
}
