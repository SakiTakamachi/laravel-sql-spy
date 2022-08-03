<?php

namespace Sakiot\LaravelSqlSpy\Models\Traits\Fields;

trait BacktraceField
{
    protected array $backtrace = [];

    public function backtrace(string|array $backtrace = []) : array|self
    {
        if(func_num_args() < 1){
            return $this->backtrace;
        }

        if(is_array($backtrace)){
            $this->backtrace = array_merge($this->backtrace, $backtrace);
        }else{
            $this->backtrace[] = $backtrace;
        }

        return $this;
    }
}