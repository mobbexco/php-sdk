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

    public function execute($subscriberUid, $id = false)
    {
        $id = !$id ? $this->uid : $id;

        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => false,
            'uri' => $this->uri . '/' . $id . '/subscriber/'.$subscriberUid.'/execution'
        ]);

        return (new MobbexResponse($response))->getBody();
    }

    public function period($subscriberUid, $id = false)
    {
        $id = !$id ? $this->uid : $id;

        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => false,
            'uri' => $this->uri . '/' . $id . '/subscriber/'.$subscriberUid.'/action/period'
        ]);

        return (new MobbexResponse($response))->getBody();
    }

    public function retry($executionId, $subscriberUid, $id = false)
    {
        $id = !$id ? $this->uid : $id;

        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => false,
            'uri' => $this->uri . '/' . $id . '/subscriber/'.$subscriberUid.'/execution/'.$executionId.'/action/retry'
        ]);

        return (new MobbexResponse($response))->getBody();
    }

    public function reschedule($subscriberUid, $date, $id = false)
    {
        $id = !$id ? $this->uid : $id;

        $response = $this->makeRequest([
            'method' => 'POST',
            'body' => json_encode(['startDate' => $date]),
            'uri' => $this->uri . '/' . $id . '/subscriber/'.$subscriberUid.'/action/reschedule'
        ]);

        return (new MobbexResponse($response))->getBody();
    }

    public function search($text, $page = 0, $id = false)
    {
        $id = !$id ? $this->uid : $id;

        //var_dump($this->uri . '/' . $id . '/subscriber/');die;

        $response = $this->makeRequest([
            'method' => 'GET',
            //'body' => json_encode(['page' => $page, 'search' => $text]),
            'body' => false,
            'uri' => $this->uri . '/' . $id . '/subscriber/?page='.$page.'&search='.$text
        ]);

        return (new MobbexResponse($response))->getBody();
    }

    public function suspend($subscriberUid, $id = false)
    {
        $id = !$id ? $this->uid : $id;

        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => false,
            'uri' => $this->uri . '/' . $id . '/subscriber/'.$subscriberUid.'/action/suspend'
        ]);

        return (new MobbexResponse($response))->getBody();
    }

    public function move($subscriberId, $newSubscriptionId)
    {

        $response = $this->makeRequest([
            'method' => 'GET',
            'body' => json_encode(['sid' => $newSubscriptionId]),
            'uri' => $this->uri . '/' . $this->uid . '/subscriber/'. $subscriberId . '/action/move'
        ]);

        $this->attributes = [];

        return (new MobbexResponse($response))->getBody();
    }

    public function activateSubscriber($subscriberId)
    {
        $response = $this->makeRequest([
            'method' => 'POST',
            'body' => false,
            'uri' => $this->uri . '/' . $this->uid . '/subscriber/'.$subscriberId.'/action/activate'
        ]);

        return (new MobbexResponse($response))->getBody();
    }
}