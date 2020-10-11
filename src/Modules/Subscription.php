<?php


namespace Adue\Mobbex\Modules;


use Adue\Mobbex\MobbexResponse;

class Subscription extends BaseModule implements ModuleInterface
{

    protected $uri = 'subscriptions';
    protected $validationRules = [
    ];

    public function activate($id = false)
    {

        $id = !$id ? $this->uid : $id;

        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => false,
            'uri' => $this->uri . '/' . $id . '/action/activate'
        ]);

        return (new MobbexResponse($response))->getBody();

    }

    public function delete($id = false)
    {

        $id = !$id ? $this->uid : $id;

        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => false,
            'uri' => $this->uri . '/' . $id . '/action/delete'
        ]);

        $this->attributes = [];

        return (new MobbexResponse($response))->getBody();

    }

    public function subscribers($id)
    {
        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => false,
            'uri' => $this->uri . '/' . $id . '/subscriber'
        ]);

        return (new MobbexResponse($response))->getBody();
    }



}