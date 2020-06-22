<?php


namespace Adue\Mobbex\Modules;

use Adue\Mobbex\MobbexResponse;

class Transaction extends BaseModule implements ModuleInterface
{

    protected $baseUrl = 'https://api.mobbex.com/2.0/';
    protected $uri = 'transactions/coupons/';
    protected $validationRules = [
    ];

    public function all()
    {

        $response = $this->makeRequest([
            'method' => 'GET',
            'uri' => $this->uri . $this->reference
        ]);

        return new MobbexResponse($response);

    }

    public function getStatus($id)
    {
        $response = $this->makeRequest([
            'headers' => [
                'cache-control' => 'no-cache',
                'content-type' => 'application/x-www-form-urlencoded',
                'x-access-token' => $this->mobbex->getAccessToken(),
                'x-api-key' => $this->mobbex->getApiKey()
            ],
            'body' => false,
            'form_params' => [
                'id' => 'mi_referencia_123'
            ],
            'method' => 'GET',
            'uri' => 'transactions/coupon/status'
        ]);

        return new MobbexResponse($response);
    }
}