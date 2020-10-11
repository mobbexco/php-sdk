<?php


namespace Adue\Mobbex\Modules;


use Adue\Mobbex\MobbexResponse;

class Subscriber
{
    public function createSubscriber($subscriber, $id)
    {

        $response = $this->makeRequest([
            'method' => 'POST',
            'body' => json_encode($subscriber),
            'uri' => $this->uri . '/' . $id . '/subscriber'
        ]);

        return (new MobbexResponse($response))->getBody();
    }

    public function editSubscriber($sid, $id, $data)
    {

        $response = $this->makeRequest([
            'method' => 'POST',
            'body' => json_encode($data),
            'uri' => $this->uri . '/' . $id . '/subscriber/' . $sid
        ]);

        return (new MobbexResponse($response))->getBody();
    }

    public function suspendSubscriber($sid, $id)
    {

        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => false,
            'uri' => $this->uri . '/' . $id . '/subscriber/' . $sid . '/action/suspend'
        ]);

        return (new MobbexResponse($response))->getBody();
    }

    public function moveSubscriber($sid, $fromId, $toId)
    {

        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => json_encode(['sid' => $toId]),
            'uri' => $this->uri . '/' . $fromId . '/subscriber/' . $sid . '/action/move'
        ]);

        return (new MobbexResponse($response))->getBody();
    }
}