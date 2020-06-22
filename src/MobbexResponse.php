<?php


namespace Adue\Mobbex;


use GuzzleHttp\Psr7\Response;

class MobbexResponse
{

    /**
     * @var Response
     */
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function getBody($json = true)
    {
        if(!$json)
            return $this->response->getBody()->getContents();

        return json_decode($this->response->getBody()->getContents(), true);
    }

}