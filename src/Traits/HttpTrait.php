<?php


namespace Adue\Mobbex\Traits;

use GuzzleHttp\Client;

trait HttpTrait
{
    public function getHeaders()
    {
        $headers = [
            //'cache-control' => 'no-cache',
            'Content-Type' => 'application/json',
            'x-lang' => 'es',
            'x-access-token' => $this->mobbex->getAccessToken(),
            'x-api-key' => $this->mobbex->getApiKey()
        ];

        if($this->mobbex->getAccessToken())
            $headers['x-access-token'] = $this->mobbex->getAccessToken();

        return $headers;
    }

    public function getRequestBody($json = false)
    {
        if($json)
            return json_encode($this->attributes);
        return $this->attributes;
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
            'defaults' => [
                'exceptions' => false
            ]
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