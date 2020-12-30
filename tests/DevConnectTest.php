<?php


namespace Tests;


use Adue\Mobbex\Modules\Checkout;
use Adue\Mobbex\Modules\DevConnect;

class DevConnectTest extends BaseTestCase
{
    public function test_dev_connect_creation()
    {
        $mobbex = $this->getDefaultObject();

        $devConnect = $mobbex->devConnect;

        $this->assertInstanceOf(DevConnect::class, $devConnect);
    }

    public function test_dev_connect()
    {
        $mobbex = $this->getDefaultObject();

        $mobbex->devConnect->return_url = 'https://adue.digital';
        $mobbex->devConnect->connect();

        $this->assertTrue(is_string($mobbex->devConnect->id) &&
            $mobbex->devConnect->url == 'https://mobbex.com/p/developer/connect/'.$mobbex->devConnect->id
        );
    }

    public function test_getting_credentials()
    {
        $mobbex = $this->getDefaultObject();

        $mobbex->devConnect->return_url = 'https://adue.digital';
        $mobbex->devConnect->connect();

        $mobbex->devConnect->getCredentials();

        $this->assertTrue($mobbex->getAccessToken() == $mobbex->devConnect->access_token);
    }
}