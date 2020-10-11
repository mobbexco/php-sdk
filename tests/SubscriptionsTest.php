<?php


namespace Tests;


use Adue\Mobbex\MobbexResponse;
use Adue\Mobbex\Modules\Subscription;

//TODO change UID and use the model in tests
class SubscriptionsTest extends BaseTestCase
{

    public function test_subscription__object_creation()
    {
        $mobbex = $this->getDefaultObject();

        $subscription = $mobbex->subscription;

        $this->assertInstanceOf(Subscription::class, $subscription);
    }

    public function test_subscription_creation()
    {
        $response = $this->createSubscription();

        $this->assertTrue($response['result']);
    }

    public function test_subscriptions_lists()
    {
        $mobbex = $this->getDefaultObject();

        $response =  $mobbex->subscription->all();

        //TODO get all subscriptions
        $this->assertTrue($response['result']);
    }

    public function test_subscription_data()
    {
        $id = 'AFRYsSQZW';
        $mobbex = $this->getDefaultObject();

        $response =  $mobbex->subscription->get($id);

        //TODO test subscription data
        $this->assertTrue($response['result']);
    }

    public function test_subscription_activation()
    {
        $id = 'AFRYsSQZW';
        $mobbex = $this->getDefaultObject();

        $response =  $mobbex->subscription->activate($id);

        //TODO test subscription activation
        $this->assertTrue($response['result']);
    }

    public function test_subscription_delete()
    {
        $id = 'AFRYsSQZW';
        $mobbex = $this->getDefaultObject();

        $response = $mobbex->subscription->delete($id);

        //TODO test subscription activation
        $this->assertTrue($response['result']);
    }

    public function test_subscription_subscribers()
    {
        $id = 'AFRYsSQZW';
        $mobbex = $this->getDefaultObject();

        $response =  $mobbex->subscription->subscribers($id);

        //TODO test subscription subscribers
        $this->assertTrue($response['result']);
    }

    public function test_subscription_create_subscriber()
    {
        $subscription = $this->createSubscription();
        $response = $this->createSubscriber($subscription['data']['uid']);

        //TODO test create subscriber
        $this->assertTrue($response['result']);
    }

    public function test_subscription_edit_subscriber()
    {
        $subscription = $this->createSubscription();
        $subscriptionId = $subscription['data']['uid'];

        $subscriber = $this->createSubscriber($subscriptionId);
        $subscriberId = $subscriber['data']['uid'];

        $mobbex = $this->getDefaultObject();

        $response = $mobbex->subscription->editSubscriber(
            $subscriberId,
            $subscriptionId,
            [
                'total' => 15,
                'reference' => 'mi_referencia_2',
            ]
        );

        //TODO test create subscriber
        $this->assertTrue($response['result']);
    }

    public function test_subscription_suspend_subscriber()
    {
        $subscription = $this->createSubscription();
        $subscriptionId = $subscription['data']['uid'];

        $subscriber = $this->createSubscriber($subscriptionId);
        $subscriberId = $subscriber['data']['uid'];

        $mobbex = $this->getDefaultObject();

        $response = $mobbex->subscription->suspendSubscriber(
            $subscriberId,
            $subscriptionId
        );

        $this->assertTrue($response['result']);
    }

    public function test_subscription_move_subscriber()
    {
        $subscription1 = $this->createSubscription();
        $subscription1Id = $subscription1['data']['uid'];

        $subscription2 = $this->createSubscription();
        $subscription2Id = $subscription2['data']['uid'];

        $subscriber = $this->createSubscriber($subscription1Id);
        $subscriberId = $subscriber['data']['uid'];

        $mobbex = $this->getDefaultObject();

        $response = $mobbex->subscription->moveSubscriber(
            $subscriberId,
            $subscription1Id,
            $subscription2Id
        );

        //TODO test move subscriber
        $this->assertTrue($response['result']);
    }

    /**
     * Private functions
    */
    /**
     * @return mixed
     */
    private function createSubscription()
    {
        $mobbex = $this->getDefaultObject();

        $mobbex->subscription->total = 100;
        $mobbex->subscription->currency = 'ARS';
        $mobbex->subscription->type = 'dynamic';
        $mobbex->subscription->name = 'Suscription name';
        $mobbex->subscription->description = 'Suscription description';
        $mobbex->subscription->interval = '1m';
        $mobbex->subscription->trial = 0;
        $mobbex->subscription->limit = 0;
        $mobbex->subscription->webhook = 'https://webhook.com';
        $mobbex->subscription->return_url = 'https://returnurl.com';

        $subscription = $mobbex->subscription->save();
        return $subscription;
    }

    private function createSubscriber($id)
    {
        $mobbex = $this->getDefaultObject();
        return $mobbex->subscription->createSubscriber([
            'customer' => [
                'email' => 'customer@email.com',
                'identification' => '36666666',
                'name' => 'Customer Test',
                'phone' => '12345678',
            ],
            'reference' => 'demo_user_321',
            'startDate' => [
                'day' => 1,
                'month' => 1,
            ]
        ], $id);
    }
}