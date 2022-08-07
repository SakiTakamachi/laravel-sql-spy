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
        $page_name = $this->faker->lexify();
        $reports = $this->faker->randomElements();
        $spied_at = Carbon::now();

        $dto = new SessionDto(
            $page_name,
            $reports,
            $spied_at,
        );

        $this->assertSame($page_name, $dto->getPageName());
        $this->assertSame($reports, $dto->getReports());
        $this->assertSame($spied_at, $dto->getSpiedAt());
        $this->assertSame(true, $dto->hasData());
    }

    public function testDtoGettersCaseNoData()
    {
        $page_name = '';
        $reports = [];
        $spied_at = null;
        $has_data = false;

        $dto = new SessionDto(
            '',
            [],
            null,
            false,
        );

        $this->assertSame(false, $dto->hasData());
    }
}
