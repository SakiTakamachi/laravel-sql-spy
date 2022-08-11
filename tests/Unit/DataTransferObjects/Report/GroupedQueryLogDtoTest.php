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
        $totalTime = $this->faker->randomFloat();
        $averageTime = $this->faker->randomFloat();
        $backtrace = $this->faker->randomElements();

        $dto = new GroupedQueryLogDto(
            $query,
            $count,
            $totalTime,
            $averageTime,
            $backtrace,
        );

        $this->assertSame($query, $dto->getQuery());
        $this->assertSame($count, $dto->getCount());
        $this->assertSame($totalTime, $dto->getTotalTime());
        $this->assertSame($averageTime, $dto->getAverageTime());
        $this->assertSame($backtrace, $dto->getBacktrace());
    }
}
