<?php


namespace Tests;


use Adue\Mobbex\MobbexResponse;
use Adue\Mobbex\Modules\Subscriber;
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
        $subscription = $this->createSubscription();

        $this->assertInstanceOf(Subscription::class, $subscription);
        $this->assertNotNull($subscription->uid);
    }

    public function test_subscriptions_lists()
    {
        $mobbex = $this->getDefaultObject();

        $subscriptions =  $mobbex->subscription->all();

        $this->assertIsArray($subscriptions);

        foreach ($subscriptions as $subscription)
            $this->assertInstanceOf(Subscription::class, $subscription);
    }

    public function test_subscription_data()
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

        $mobbex->subscription->save();

        $response =  $mobbex->subscription->get($mobbex->subscription->uid);

        $this->assertInstanceOf(Subscription::class, $response);
        $this->assertTrue($response->uid == $mobbex->subscription->uid);
    }

    public function test_subscription_activation()
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

        $mobbex->subscription->save();

        $response =  $mobbex->subscription->activate();
        $this->assertTrue($response['result']);

        $this->assertTrue($mobbex->subscription->status == 'active');
    }

    public function test_subscription_delete()
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

        $mobbex->subscription->save();

        $id = $mobbex->subscription->uid;

        $response = $mobbex->subscription->delete();
        $this->assertTrue($response['result']);

        $subscription = $mobbex->subscription->get($id);
        $this->assertTrue($subscription->status == 'deleted');
    }

    public function test_subscription_subscribers_instance()
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

        $mobbex->subscription->save();

        $this->assertInstanceOf(Subscriber::class, $mobbex->subscription->subscribers);
    }

    public function test_subscription_create_subscriber()
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

        $mobbex->subscription->save();

        $mobbex->subscription->activate();

        $mobbex->subscription->subscribers->customer = [
                'email' => 'customer@email.com',
                'identification' => '36666666',
                'name' => 'Customer Test',
                'phone' => '12345678',
        ];
        $mobbex->subscription->subscribers->reference = 'demo_user_321';
        $mobbex->subscription->subscribers->startDate = [
            'day' => 1,
            'month' => 1,
        ];

        $mobbex->subscription->subscribers->save();

        $this->assertInstanceOf(Subscriber::class, $mobbex->subscription->subscribers);
        $this->assertNotNull($mobbex->subscription->subscribers->uid);

        $subscriberList = $mobbex->subscription->subscribers->all();

        $this->assertIsArray($subscriberList);
        $this->assertTrue($subscriberList[0]->reference == 'demo_user_321');
    }

    public function test_subscription_edit_subscriber()
    {
        $subscription = $this->createSubscription();

        $subscription->subscribers->customer = [
            'email' => 'customer@email.com',
            'identification' => '36666666',
            'name' => 'Customer Test',
            'phone' => '12345678',
        ];
        $subscription->subscribers->reference = 'demo_user_321';
        $subscription->subscribers->startDate = [
            'day' => 1,
            'month' => 1,
        ];

        $response = $subscription->subscribers->save();

        $id = $subscription->subscribers->uid;

        $subscriber = $subscription->subscribers->get($id);

        $subscriber->reference = 'new_reference';
        $subscriber->save();

        $subscriber = $subscription->subscribers->get($id);

        $this->assertTrue($subscriber->reference == 'new_reference');
    }

    public function test_subscription_suspend_subscriber()
    {
        $subscription = $this->createSubscription();

        $subscription->subscribers->customer = [
            'email' => 'customer@email.com',
            'identification' => '36666666',
            'name' => 'Customer Test',
            'phone' => '12345678',
        ];
        $subscription->subscribers->reference = 'demo_user_321';
        $subscription->subscribers->startDate = [
            'day' => 1,
            'month' => 1,
        ];

        $subscription->subscribers->save();

        $response = $subscription->subscribers->suspend();
        $this->assertTrue($response['result']);
        $this->assertTrue($subscription->subscribers->subscriber['status'] == 'suspended');
    }

    public function test_subscription_move_subscriber()
    {
        $subscription1 = $this->createSubscription();

        $subscription1->subscribers->customer = [
            'email' => 'customer@email.com',
            'identification' => '36666666',
            'name' => 'Customer Test',
            'phone' => '12345678',
        ];
        $subscription1->subscribers->reference = 'demo_user_321';
        $subscription1->subscribers->startDate = [
            'day' => 1,
            'month' => 1,
        ];

        $subscription1->subscribers->save();

        $sid = $subscription1->subscribers->uid;

        $subscription2 = $this->createSubscription();

        $response = $subscription1->subscribers->move($subscription2->uid);

        //TODO test move subscriber
        $this->assertTrue($response['result']);

        $subscription2->subscribers->get($sid);
        $this->assertTrue($subscription2->subscribers->subscription['uid'] == $subscription2->uid);
    }

    public function test_subscription_manually_execution() {
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

        $mobbex->subscription->save();

        $mobbex->subscription->activate();

        $mobbex->subscription->subscribers->customer = [
            'email' => 'customer@email.com',
            'identification' => '36666666',
            'name' => 'Customer Test',
            'phone' => '12345678',
        ];
        $mobbex->subscription->subscribers->reference = 'demo_user_321';
        $mobbex->subscription->subscribers->startDate = [
            'day' => 1,
            'month' => 1,
        ];

        $mobbex->subscription->subscribers->save();

        $response = $mobbex->subscription->execute($mobbex->subscription->subscribers->uid);
        $this->assertTrue($response['result']);
    }

    public function test_subscription_reschedule_subscriber() {
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

        $mobbex->subscription->save();

        $mobbex->subscription->activate();

        $mobbex->subscription->subscribers->customer = [
            'email' => 'customer@email.com',
            'identification' => '36666666',
            'name' => 'Customer Test',
            'phone' => '12345678',
        ];
        $mobbex->subscription->subscribers->reference = 'demo_user_321';
        $mobbex->subscription->subscribers->startDate = [
            'day' => 1,
            'month' => 1,
        ];

        $mobbex->subscription->subscribers->save();

        $mobbex->subscription->subscribers->activate();

        $response = $mobbex->subscription->subscribers->reschedule([
            'day' => 2,
            'month' => 15,
        ]);

        $this->assertTrue($response['result']);
    }

    /**
     * Private functions
    */
    /**
     * @return mixed
     */
    private function createSubscription($mobbex = false)
    {
        if(!$mobbex)
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

        $mobbex->subscription->save();

        $mobbex->subscription->activate();

        return $mobbex->subscription;
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