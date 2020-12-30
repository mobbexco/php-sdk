<?php


namespace Adue\Mobbex\Modules;


use Adue\Mobbex\MobbexResponse;

class DevConnect extends BaseModule
{
    protected $uri = '/p/developer/connect';
    protected $validationRules = [
        'return_url' => 'required|url'
    ];

    public function all() {}
    public function get($id) {}
    public function save() {}
    //public function selfAssignData($body) {}
    public function createArrayOfObjects($body) {}

    public function connect()
    {
        $this->validate();

        $response = $this->makeRequest([]);

        $body = (new MobbexResponse($response))->getBody();

        $this->selfAssignData($body);
    }

    public function getCredentials($connectId = false)
    {
        $id = $connectId ? $connectId : $this->id;
        $response = $this->makeRequest([
            'uri' => $this->uri . '/' . $id
        ]);

        $body = (new MobbexResponse($response))->getBody();

        $this->selfAssignData($body);

        $this->mobbex->setAccessToken($this->access_token);
    }
}