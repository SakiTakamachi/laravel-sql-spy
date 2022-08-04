<?php

namespace LaravelSqlSpy\Models\Traits\Fields;

trait BindingField
{
    protected array $bindings = [];

    public function bindings(string|array $bindings = []) : array|self
    {
        if(func_num_args() < 1){
            return $this->bindings;
        }

        if(is_array($bindings)){
            $this->bindings = array_merge($this->bindings, $bindings);
        }else{
            $this->bindings[] = $bindings;
        }

        return $this;
    }
}