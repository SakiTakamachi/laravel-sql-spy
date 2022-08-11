<?php

namespace LaravelSqlSpy\DataTransferObjects\Session;

use Carbon\Carbon;

class SessionDto
{
    public function __construct(
        protected string $pageName,
        protected array $reports,
        protected null|Carbon $spiedAt,
        protected bool $hasData = true,
    ) {
        //
    }

    public function getPageName(): string
    {
        return $this->pageName;
    }

    public function getReports(): array
    {
        return $this->reports;
    }

    public function getSpiedAt(): null|Carbon
    {
        return $this->spiedAt;
    }

    public function hasData(): bool
    {
        return $this->hasData;
    }
}
