<?php

namespace LaravelSqlSpy\DataTransferObjects\Session;

use Carbon\Carbon;

class SessionDto
{
    public function __construct(
        protected string $page_name,
        protected array $reports,
        protected null|Carbon $spied_at,
        protected bool $has_data = true,
    ) {
        //
    }

    public function getPageName(): string
    {
        return $this->page_name;
    }

    public function getReports(): array
    {
        return $this->reports;
    }

    public function spiedAt(): null|Carbon
    {
        return $this->spied_at;
    }

    public function hasData(): bool
    {
        return $this->has_data;
    }
}
