<?php
namespace Tests;

use Adue\Mobbex\Exceptions\ModuleNotFound;

class ObjectCreationTest extends BaseTestCase
{

    public function test_mobbex_object_creation()
    {
        $apiKey = 'zJ8LFTBX6Ba8D611e9io13fDZAwj0QmKO1Hn1yIj';
        $accessToken = 'd31f0721-2f85-44e7-bcc6-15e19d1a53cc';

        $mobbex = $this->getDefaultObject();

        $this->assertSame($apiKey, $mobbex->getApiKey());
        $this->assertSame($accessToken, $mobbex->getAccessToken());
    }

    public function test_user_cant_access_invalid_module()
    {
        $this->expectException(
            ModuleNotFound::class
        );

        $mobbex = $this->getDefaultObject();

        $invalidModule = $mobbex->invalidModule;
    }

}