<?php

namespace Tests;

use Adue\Mobbex\Mobbex;
use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    public static $apiKey = 'zJ8LFTBX6Ba8D611e9io13fDZAwj0QmKO1Hn1yIj';
    public static $accessToken = 'd31f0721-2f85-44e7-bcc6-15e19d1a53cc';

    public function getDefaultObject()
    {
        return new Mobbex(static::$apiKey, static::$accessToken);
    }
}