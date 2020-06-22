<?php


namespace Tests;

use Adue\Mobbex\Modules\Sources;

class SourcesTest extends BaseTestCase
{

    public function test_checkout_creation()
    {
        $mobbex = $this->getDefaultObject();

        $checkout = $mobbex->sources;

        $this->assertInstanceOf(Sources::class, $checkout);
    }

    //TODO Implementar bien la API de medios de pagos

}