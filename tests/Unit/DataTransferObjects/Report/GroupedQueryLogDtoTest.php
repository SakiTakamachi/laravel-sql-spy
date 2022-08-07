<?php

namespace LaravelSqlSpy\Tests\Unit\DataTransferObjects\Report;

use Illuminate\Foundation\Testing\WithFaker;
use LaravelSqlSpy\DataTransferObjects\Report\GroupedQueryLogDto;
use LaravelSqlSpy\Tests\TestCase;

class GroupedQueryLogDtoTest extends TestCase
{
    use WithFaker;

    public function testDtoGetters()
    {
        $query = $this->faker->lexify();
        $count = $this->faker->randomNumber();
        $total_time = $this->faker->randomFloat();
        $average_time = $this->faker->randomFloat();
        $backtrace = $this->faker->randomElements();

        $dto = new GroupedQueryLogDto(
            $query,
            $count,
            $total_time,
            $average_time,
            $backtrace,
        );

        $this->assertSame($query, $dto->getQuery());
        $this->assertSame($count, $dto->getCount());
        $this->assertSame($total_time, $dto->getTotalTime());
        $this->assertSame($average_time, $dto->getAverageTime());
        $this->assertSame($backtrace, $dto->getBacktrace());
    }
}
