<?php

namespace Sakiot\LaravelSqlSpy\Models\Traits\Fields;

trait QueryGroupField
{
    protected int $count = 0;
    protected float $total_time;

    public function count(int $count = 0) : int|self
    {
        if(func_num_args() < 1){
            return $this->count;
        }

        $this->count = $count;

        return $this;
    }

    public function totalTime(float $time = 0) : float|self
    {
        if(func_num_args() < 1){
            return $this->total_time;
        }

        $this->total_time = $time;

        return $this;
    }

    public function averageTime() : float
    {
        return $this->count() !== 0 ? $this->totalTime() / $this->count() : (float) 0;
    }
}