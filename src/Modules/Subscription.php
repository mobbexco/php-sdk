<?php


namespace Adue\Mobbex\Modules;


use Adue\Mobbex\MobbexResponse;

class Subscription extends BaseModule implements ModuleInterface
{

    protected $uri = 'subscriptions';
    protected $validationRules = [
    ];

    public function activate($id)
    {

        $this->validate();

        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => false,
            'uri' => $this->uri . '/' . $id . '/action/activate'
        ]);

        return new MobbexResponse($response);

    }

    public function delete($id)
    {

        $this->validate();

        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => false,
            'uri' => $this->uri . '/' . $id . '/action/delete'
        ]);

        return new MobbexResponse($response);

    }

    public function subscribers($id)
    {
        $this->validate();

        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => false,
            'uri' => $this->uri . '/' . $id . '/subscriber'
        ]);

        return new MobbexResponse($response);
    }

    public function createSubscriber($subscriber, $id)
    {

        $response = $this->makeRequest([
            'method' => 'POST',
            'body' => json_encode($subscriber),
            'uri' => $this->uri . '/' . $id . '/subscriber'
        ]);

        return new MobbexResponse($response);
    }

    public function editSubscriber($sid, $id, $data)
    {

        $response = $this->makeRequest([
            'method' => 'POST',
            'body' => json_encode($data),
            'uri' => $this->uri . '/' . $id . '/subscriber/' . $sid
        ]);

        return new MobbexResponse($response);
    }

    public function suspendSubscriber($sid, $id)
    {

        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => false,
            'uri' => $this->uri . '/' . $id . '/subscriber/' . $sid . '/action/suspend'
        ]);

        return new MobbexResponse($response);
    }

    public function moveSubscriber($sid, $fromId, $toId)
    {

        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => json_encode(['sid' => $toId]),
            'uri' => $this->uri . '/' . $fromId . '/subscriber/' . $sid . '/action/move'
        ]);

        return new MobbexResponse($response);
    }

}