<?php


namespace Tests;


use Adue\Mobbex\MobbexResponse;
use Adue\Mobbex\Modules\Subscription;

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

        $this->assertInstanceOf(MobbexResponse::class, $subscription);

        $responseBody = $subscription->getBody();

        $this->assertIsArray($responseBody);
        $this->assertArrayHasKey('result', $responseBody);
        $this->assertTrue($responseBody['result']);
    }

    public function test_subscriptions_lists()
    {
        $mobbex = $this->getDefaultObject();

        $subscriptions =  $mobbex->subscription->all();

        $responseBody = $subscriptions->getBody();

        $this->assertIsArray($responseBody);
        $this->assertArrayHasKey('result', $responseBody);
        $this->assertTrue($responseBody['result']);
    }

    public function test_subscription_data()
    {
        $id = 'AFRYsSQZW';
        $mobbex = $this->getDefaultObject();

        $subscription =  $mobbex->subscription->get($id);

        $responseBody = $subscription->getBody();

        $this->assertIsArray($responseBody);
        $this->assertArrayHasKey('result', $responseBody);
        $this->assertTrue($responseBody['result']);
    }

    public function test_subscription_activation()
    {
        $id = 'AFRYsSQZW';
        $mobbex = $this->getDefaultObject();

        $subscription =  $mobbex->subscription->activate($id);

        $responseBody = $subscription->getBody();

        $this->assertIsArray($responseBody);
        $this->assertArrayHasKey('result', $responseBody);
        $this->assertTrue($responseBody['result']);
    }

    public function test_subscription_delete()
    {
        $id = 'AFRYsSQZW';
        $mobbex = $this->getDefaultObject();

        $subscription =  $mobbex->subscription->delete($id);

        $responseBody = $subscription->getBody();

        $this->assertIsArray($responseBody);
        $this->assertArrayHasKey('result', $responseBody);
        $this->assertTrue($responseBody['result']);
    }

    public function test_subscription_subscribers()
    {
        $id = 'AFRYsSQZW';
        $mobbex = $this->getDefaultObject();

        $subscription =  $mobbex->subscription->subscribers($id);

        $responseBody = $subscription->getBody();

        $this->assertIsArray($responseBody);
        $this->assertArrayHasKey('result', $responseBody);
        $this->assertTrue($responseBody['result']);
    }

    public function test_subscription_create_subscriber()
    {
        $subscription = $this->createSubscription();
        $subscriber = $this->createSubscriber($subscription->getBody()['data']['uid']);

        $responseBody = $subscriber->getBody();

        $this->assertIsArray($responseBody);
        $this->assertArrayHasKey('result', $responseBody);
        $this->assertTrue($responseBody['result']);
    }

    public function test_subscription_edit_subscriber()
    {
        $subscription = $this->createSubscription();
        $subscriptionId = $subscription->getBody()['data']['uid'];

        $subscriber = $this->createSubscriber($subscriptionId);
        $subscriberId = $subscriber->getBody()['data']['uid'];

        $mobbex = $this->getDefaultObject();

        $response = $mobbex->subscription->editSubscriber(
            $subscriberId,
            $subscriptionId,
            [
                'total' => 15,
                'reference' => 'mi_referencia_2',
            ]
        );

        $responseBody = $response->getBody();

        $this->assertIsArray($responseBody);
        $this->assertArrayHasKey('result', $responseBody);
        $this->assertTrue($responseBody['result']);
    }

    public function test_subscription_suspend_subscriber()
    {
        $subscription = $this->createSubscription();
        $subscriptionId = $subscription->getBody()['data']['uid'];

        $subscriber = $this->createSubscriber($subscriptionId);
        $subscriberId = $subscriber->getBody()['data']['uid'];

        $mobbex = $this->getDefaultObject();

        $response = $mobbex->subscription->suspendSubscriber(
            $subscriberId,
            $subscriptionId
        );

        $responseBody = $response->getBody();

        $this->assertIsArray($responseBody);
        $this->assertArrayHasKey('result', $responseBody);
        $this->assertTrue($responseBody['result']);
    }

    public function test_subscription_move_subscriber()
    {
        $subscription1 = $this->createSubscription();
        $subscription1Id = $subscription1->getBody()['data']['uid'];

        $subscription2 = $this->createSubscription();
        $subscription2Id = $subscription2->getBody()['data']['uid'];

        $subscriber = $this->createSubscriber($subscription1Id);
        $subscriberId = $subscriber->getBody()['data']['uid'];

        $mobbex = $this->getDefaultObject();

        $response = $mobbex->subscription->moveSubscriber(
            $subscriberId,
            $subscription1Id,
            $subscription2Id
        );

        $responseBody = $response->getBody();

        $this->assertIsArray($responseBody);
        $this->assertArrayHasKey('result', $responseBody);
        $this->assertTrue($responseBody['result']);
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