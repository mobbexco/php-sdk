<?php


namespace Adue\Mobbex\Modules;


use Adue\Mobbex\Mobbex;

class Sources extends BaseModule implements ModuleInterface
{
    protected $method = 'GET';
    public function __construct(Mobbex $mobbex)
    {
        parent::__construct($mobbex);
        $this->uri = 'sources/list/'.$mobbex->getAccessToken();
    }



}