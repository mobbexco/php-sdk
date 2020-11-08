<?php


namespace Adue\Mobbex\Modules;


use Adue\Mobbex\MobbexResponse;

//TODO validate that self uid is not null
class Subscription extends BaseModule implements ModuleInterface
{

    protected $uri = 'subscriptions';
    protected $validationRules = [
    ];

    private $shared = [];

    public function __get($name)
    {
        if($name != 'subscribers')
            return parent::__get($name);

        if(!is_null($this->uid)) {
            if (!isset($this->shared['subscribers']))
                $this->shared['subscribers'] = $this->subscribers();
            return $this->shared['subscribers'];
        }

        return null;
    }

    public function activate($id = false)
    {

        $id = !$id ? $this->uid : $id;

        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => false,
            'uri' => $this->uri . '/' . $id . '/action/activate'
        ]);

        $this->get($this->uid);

        return (new MobbexResponse($response))->getBody();

    }

    public function delete($id = false)
    {

        $id = !$id ? $this->uid : $id;

        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => false,
            'uri' => $this->uri . '/' . $id . '/action/delete'
        ]);

        $this->attributes = [];

        return (new MobbexResponse($response))->getBody();

    }

    public function subscribers($id = false)
    {
        $id = !$id ? $this->uid : $id;

        return new Subscriber($this->mobbex, $id);
    }



}