<?php


namespace Adue\Mobbex\Modules;


use Adue\Mobbex\Exceptions\InvalidDataException;
use Adue\Mobbex\Mobbex;
use Adue\Mobbex\MobbexResponse;
use Adue\Mobbex\Traits\DynamicAttributes;
use Adue\Mobbex\Traits\ValidationsTratit;
use GuzzleHttp\Client;
use Rakit\Validation\Validator;

class BaseModule
{

    use DynamicAttributes, ValidationsTratit;

    protected $baseUrl = 'https://api.mobbex.com/p/';
    protected $uri = '';
    protected $method = 'POST';

    protected $mobbex;

    protected $validationRules = [];

    protected $validator;

    public function __construct(Mobbex $mobbex)
    {
        $this->mobbex = $mobbex;
        $this->validator = new Validator;
    }

    public function getHeaders()
    {
        return [
            'cache-control' => 'no-cache',
            'Content-Type' => 'application/json',
            'x-lang' => 'es',
            'x-access-token' => $this->mobbex->getAccessToken(),
            'x-api-key' => $this->mobbex->getApiKey()
        ];
    }

    public function getRequestBody($json = false)
    {
        if($json)
            return json_encode($this->attributes);
        return $this->attributes;
    }

    public function validate()
    {
        $validation = $this->validator->validate($this->getRequestBody(), $this->validationRules);

        if($validation->fails()) {
            $errors = $validation->errors();
            throw new InvalidDataException(serialize($errors->all()));
        }

        return $validation;
    }

    public function all()
    {

        $response = $this->makeRequest([
            'method' => 'GET',
        ]);

        return new MobbexResponse($response);

    }

    public function get($id)
    {

        $response = $this->makeRequest([
            'method' => 'GET',
            'uri' => $this->uri . '/' . $id,
        ]);

        return new MobbexResponse($response);

    }

    public function save()
    {
        $this->validate();

        $response = $this->makeRequest([
            'method' => 'POST',
        ]);

        return new MobbexResponse($response);

    }

    /**
     * @param $data[
     *     'method',
     *     'baseUrl',
     *     'uri',
     *     'body',
     *     'headers',
     * ]
     */
    protected function makeRequest($data)
    {

        $requestData = [
            'baseUrl' => $data['baseUrl'] ?? $this->baseUrl,
            'method' => $data['method'] ?? $this->method,
            'uri' => $data['uri'] ?? $this->uri,
        ];

        $client = new Client([
            'base_uri' => $requestData['baseUrl'],
        ]);

        $extraParams = [];

        if(isset($data['headers'])) {
            if($data['headers'] !== false)
                $extraParams['headers'] = $data['headers'] ?? $this->getHeaders();
        } else {
            $extraParams['headers'] = $this->getHeaders();
        }

        if(isset($data['body'])) {
            if($data['body'] !== false)
                $extraParams['body'] = $data['body'] ?? $this->getRequestBody(true);
        } else {
            $extraParams['body'] = $this->getRequestBody(true);
        }

        foreach ($data as $key => $value) {
            if(!in_array($key, ['headers', 'body']))
                $extraParams[$key] = $value;
        }

        return $client->request(
            $requestData['method'],
            $requestData['uri'],
            $extraParams
        );
    }

}