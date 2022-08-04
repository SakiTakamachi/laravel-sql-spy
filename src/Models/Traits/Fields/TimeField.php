<?php

namespace LaravelSqlSpy\Models\Traits\Fields;

trait TimeField
{
    protected float $time;

    public function time(float $time = 0) : float|self
    {
        if(func_num_args() < 1){
            return $this->time;
        }

        $this->time = $time;

        return $this;
    }
}