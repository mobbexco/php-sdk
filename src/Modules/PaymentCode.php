<?php


namespace Adue\Mobbex\Modules;


use Adue\Mobbex\Exceptions\InvalidDataException;
use Adue\Mobbex\MobbexResponse;
use GuzzleHttp\Client;

class PaymentCode extends BaseModule implements ModuleInterface
{

    protected $uri = 'payment_code/gen/HyPoGfFxf/';
    protected $method = 'GET';
    protected $validationRules = [
        'total' => 'required|numeric',
        'reference' => 'required',
        'expiration' => 'required|date:d-m-Y',

        'email' => 'email',
        'surchargeDays' => 'integer',
        'surchargeTotal' => 'numeric',
    ];

    public function save()
    {

        $this->validate();

        $response = $this->makeRequest([
            'method' => 'GET',
            'headers' => $this->getHeaders(),
            'body' => $this->getRequestBody(true),
            'uri' => $this->uri . '?' . http_build_query($this->getRequestBody())
        ]);

        return new MobbexResponse($response);

    }

}