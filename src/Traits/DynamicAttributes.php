<?php


namespace Adue\Mobbex\Traits;


trait DynamicAttributes
{
    protected $attributes = [];


    public function __get($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }
}