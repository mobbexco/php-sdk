<?php


namespace Adue\Mobbex\Traits;


trait DynamicAttributes
{
    protected $attributes = [];


    public function __get($name)
    {
        return $this->attributes[$name] ?? NULL;
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }
}