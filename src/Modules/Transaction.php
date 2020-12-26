<?php


namespace Adue\Mobbex\Modules;

use Adue\Mobbex\MobbexResponse;

class Transaction extends BaseModule implements ModuleInterface
{

    protected $baseUrl20 = 'https://api.mobbex.com/2.0/';
    protected $baseUrl10 = 'https://api.mobbex.com/p/';
    protected $uri20 = 'transactions/coupons/';
    protected $uri10 = 'operations/';
    protected $validationRules = [

    ];

    public function all()
    {
        $response = $this->makeRequest([
            'baseUrl' => $this->baseUrl20,
            'method' => 'GET',
            'uri' => $this->uri20 . $this->reference
        ]);

        $body = (new MobbexResponse($response))->getBody();

        if($body['result'])
            return $this->createArrayOfObjects($body);

        return $body['result'];

    }

    public function search($params)
    {
        $response = $this->makeRequest([
            'baseUrl' => 'https://api.mobbex.com/p/',
            'method' => 'GET',
            'uri' => $this->uri10 . '?page=' . $params['pagination']['page'] . '&limit=' . $params['pagination']['limit'],
            'body' => $params['body']
        ]);

        $body = (new MobbexResponse($response))->getBody();

        if($body['result'])
            return $this->createArrayOfObjects($body);

        return $body['result'];
    }

    public function refund($id)
    {
        $response = $this->makeRequest([
            'headers' => [
                'User-Agent' => 'testing/1.0',
                'cache-control' => 'no-cache',
                'content-type' => 'application/x-www-form-urlencoded',
                'x-access-token' => $this->mobbex->getAccessToken(),
                'x-api-key' => $this->mobbex->getApiKey()
            ],
            'method' => 'GET',
            'uri' => $this->uri10 . $id . '/refund'
        ]);

        return new MobbexResponse($response);

    }

    public function getStatus($id)
    {
        $response = $this->makeRequest([
            'headers' => [
                'User-Agent' => 'testing/1.0',
                'cache-control' => 'no-cache',
                'content-type' => 'application/x-www-form-urlencoded',
                'x-access-token' => $this->mobbex->getAccessToken(),
                'x-api-key' => $this->mobbex->getApiKey()
            ],
            'body' => false,
            'form_params' => [
                'id' => $id
            ],
            'method' => 'POST',
            'uri' => $this->baseUrl20 . 'transactions/status'
        ]);

        $response = (new MobbexResponse($response))->getBody();

        $this->selfAssignData($response['transactions'][0]);

    }
}