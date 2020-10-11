<?php


namespace Tests;

use Adue\Mobbex\MobbexResponse;

class EmbeddedCheckoutTest extends BaseTestCase
{
    public function test_checkout_embeded()
    {
        $mobbex = $this->getDefaultObject();

        $mobbex->checkout->total = 150.00;
        $mobbex->checkout->currency = 'ARS';
        $mobbex->checkout->description = 'Descripción de venta $150';
        $mobbex->checkout->return_url = 'http://returncallback.com';
        $mobbex->checkout->reference = 'Descripción de venta $150';

        $mobbex->checkout->save();

        $embeded = $mobbex->checkout->getEmbeded();

        $this->assertStringContainsString('https://res.mobbex.com/js/embed/mobbex.embed@1.0.8.js', $embeded);
        $this->assertStringContainsString('id: "'.$mobbex->checkout->id.'"', $embeded);
    }
}