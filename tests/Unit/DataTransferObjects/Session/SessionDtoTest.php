<?php

namespace LaravelSqlSpy\Tests\Unit\DataTransferObjects\Session;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use LaravelSqlSpy\DataTransferObjects\Session\SessionDto;
use LaravelSqlSpy\Tests\TestCase;

class SessionDtoTest extends TestCase
{
    use WithFaker;

    public function testDtoGettersCaseHasData()
    {
        $pageName = $this->faker->lexify();
        $reports = $this->faker->randomElements();
        $spiedAt = Carbon::now();

        $dto = new SessionDto(
            $pageName,
            $reports,
            $spiedAt,
        );

        $this->assertSame($pageName, $dto->getPageName());
        $this->assertSame($reports, $dto->getReports());
        $this->assertSame($spiedAt, $dto->getSpiedAt());
        $this->assertSame(true, $dto->hasData());
    }

    public function testDtoGettersCaseNoData()
    {
        $pageName = '';
        $reports = [];
        $spiedAt = null;
        $hasData = false;

        $dto = new SessionDto(
            '',
            [],
            null,
            false,
        );

        $this->assertSame(false, $dto->hasData());
    }
}
