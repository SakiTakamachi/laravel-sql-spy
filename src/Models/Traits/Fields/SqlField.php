<?php

namespace LaravelSqlSpy\Models\Traits\Fields;

trait SqlField
{
    protected string $sql;

    public function sql(string $sql = '') : string|self
    {
        if(func_num_args() < 1){
            return $this->sql;
        }

        $this->sql = $sql;

        return $this;
    }
}