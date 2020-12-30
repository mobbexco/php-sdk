<?php


namespace Adue\Mobbex\Modules;


use Adue\Mobbex\Exceptions\InvalidDataException;
use Adue\Mobbex\Mobbex;
use Adue\Mobbex\MobbexResponse;
use Adue\Mobbex\Traits\DynamicAttributes;
use Adue\Mobbex\Traits\HttpTrait;
use Adue\Mobbex\Traits\ValidationsTratit;
use GuzzleHttp\Client;
use Rakit\Validation\Validator;

class BaseModule
{
    use DynamicAttributes, ValidationsTratit, HttpTrait;

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

        $body = (new MobbexResponse($response))->getBody();

        if($body['result'])
            return $this->createArrayOfObjects($body);

        return $body['result'];

    }

    public function get($id)
    {

        $response = $this->makeRequest([
            'method' => 'GET',
            'uri' => $this->uri . '/' . $id,
        ]);

        $mbbxResponse = (new MobbexResponse($response))->getBody();

        $this->selfAssignData($mbbxResponse);

        return $this;

    }

    public function save()
    {
        $this->validate();

        $response = $this->makeRequest([
            'method' => 'POST',
        ]);

        $mbbxResponse = (new MobbexResponse($response))->getBody();

        $this->selfAssignData($mbbxResponse);

        return $mbbxResponse;
    }

    protected function selfAssignData($body)
    {

        if(!$body['result'])
            return false;

        foreach ($body['data'] as $key => $value) {
            $this->{$key} = $value;
        }
    }

    protected function createArrayOfObjects($body)
    {
        if(!isset($body['data']['docs']))
            return [];

        $className = \get_class($this);
        foreach ($body['data']['docs'] as $op) {
            $operation = new $className($this->mobbex);
            foreach ($op as $key => $value)
                $operation->{$key} = $value;
            $array[] = $operation;
        }
        return $array;
    }
}