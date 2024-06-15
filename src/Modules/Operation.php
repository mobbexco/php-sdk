<?php


namespace Adue\Mobbex\Modules;

use Adue\Mobbex\MobbexResponse;

class Operation extends BaseModule implements ModuleInterface
{

    protected $uri = 'operations/';
    protected $validationRules = [

    ];

    public function filter($args = [])
    {

        $response = $this->makeRequest([
            'method' => 'GET',
            'uri' => $this->uri . '?' . http_build_query($args)
        ]);

        $body = (new MobbexResponse($response))->getBody();

        if($body['result'])
            return $this->createArrayOfObjects($body);

        return $body['result'];
    }

    public function release($uid)
    {

        $response = $this->makeRequest([
            'method' => 'GET',
            'uri' => $this->uri . $uid . '/release'
        ]);

        $body = (new MobbexResponse($response))->getBody();

        return $body['result'];
    }


    public function refund($id)
    {
        $response = $this->makeRequest([
            'headers' => [
                'cache-control' => 'no-cache',
                'content-type' => 'application/x-www-form-urlencoded',
                'x-access-token' => $this->mobbex->getAccessToken(),
                'x-api-key' => $this->mobbex->getApiKey()
            ],
            'body' => false,
            'method' => 'POST',
            'uri' => $this->uri . $id . '/refund'
        ]);

        return (new MobbexResponse($response))->getBody();
    }
}