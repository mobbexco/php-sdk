<?php


namespace Adue\Mobbex\Modules;


use Adue\Mobbex\Mobbex;
use Adue\Mobbex\MobbexResponse;

class Subscriber extends BaseModule
{

    private $subscriptionId;
    protected $uri;

    public function __construct(Mobbex $mobbex, $subscriptionId = false)
    {
        $this->subscriptionId = $subscriptionId;
        $this->uri = 'subscriptions/'.$subscriptionId.'/subscriber';
        parent::__construct($mobbex);
    }

    public function create($data)
    {

        $response = $this->makeRequest([
            'method' => 'POST',
            'body' => json_encode($data),
            'uri' => $this->uri
        ]);

        return (new MobbexResponse($response))->getBody();
    }

    public function save()
    {
        $this->uri .= !is_null($this->uid) ? '/'.$this->uid : '';
        parent::save();
        $this->uri = 'subscriptions/'.$this->subscriptionId.'/subscriber';
        return $this;
    }

    public function execute()
    {

        $response = $this->makeRequest([
            'method' => 'GET',
            'uri' => $this->uri . '/' . $this->uid . '/execution'
        ]);

        $this->get($this->uid);

        return (new MobbexResponse($response))->getBody();
    }

    public function activate()
    {

        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => false,
            'uri' => $this->uri . '/' . $this->uid . '/action/activate'
        ]);

        $this->get($this->uid);

        return (new MobbexResponse($response))->getBody();
    }

    public function suspend()
    {

        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => false,
            'uri' => $this->uri . '/' . $this->uid . '/action/suspend'
        ]);

        $this->get($this->uid);

        return (new MobbexResponse($response))->getBody();
    }

    public function move($subscriberId, $newSubscriptionId)
    {

        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => json_encode(['sid' => $newSubscriptionId]),
            'uri' => $this->uri . '/' . $subscriberId . '/action/move'
        ]);

        $this->attributes = [];

        return (new MobbexResponse($response))->getBody();
    }

    public function reschedule($date)
    {
        $response = $this->makeRequest([
            'method' => 'POST',
            'body' => json_encode($date),
            'uri' => $this->uri . '/' . $this->uid . '/action/reschedule'
        ]);

        $this->get($this->uid);

        return (new MobbexResponse($response))->getBody();
    }

    public function search($s, $page = 0)
    {
        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => false,
            'uri' => 'subscriptions/subscriber?page='.$page.'&search='.$s
        ]);

        $this->attributes = [];

        return (new MobbexResponse($response))->getBody();
    }

    protected function createArrayOfObjects($body)
    {
        $className = \get_class($this);
        foreach ($body['data']['docs'] as $op) {
            $operation = new $className($this->mobbex, $this->subscriptionId);
            foreach ($op as $key => $value)
                $operation->{$key} = $value;
            $array[] = $operation;
        }
        return $array;
    }

}