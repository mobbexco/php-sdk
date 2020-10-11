<?php


namespace Tests;


use Adue\Mobbex\Exceptions\InvalidDataException;
use Adue\Mobbex\MobbexResponse;
use Adue\Mobbex\Modules\Checkout;

class CheckoutTest extends BaseTestCase
{

    public function test_checkout_creation()
    {
        $mobbex = $this->getDefaultObject();

        $checkout = $mobbex->checkout;

        $this->assertInstanceOf(Checkout::class, $checkout);
    }

    public function test_checkout_process_successfully_with_required_data()
    {
        $mobbex = $this->getDefaultObject();

        $mobbex->checkout->total = 150.00;
        $mobbex->checkout->currency = 'ARS';
        $mobbex->checkout->description = 'Descripción de venta $150';
        $mobbex->checkout->return_url = 'http://returncallback.com';
        $mobbex->checkout->reference = 'Descripción de venta $150';

        $response = $mobbex->checkout->save();

        $this->assertTrue($response['result']);
    }

    public function test_checkout_process_successfully_with_optional_data()
    {
        $mobbex = $this->getDefaultObject();

        //Obligatorios
        $mobbex->checkout->total = 150.00;
        $mobbex->checkout->currency = 'ARS';
        $mobbex->checkout->description = 'Descripción de venta $150';
        $mobbex->checkout->return_url = 'http://returncallback.com';
        $mobbex->checkout->reference = 'Descripción de venta $150';

        //Opcionales
        $mobbex->checkout->webhook = 'http://webhook.com';
        $mobbex->checkout->items = [
            [
                "image" => "https://www.mobbex.com/wp-content/uploads/2019/03/web_logo.png",
                "quantity" => 2,
                "description" => "Mi Producto",
                "total" => 50
            ]
        ];

        $mobbex->checkout->options = [
            "theme" => [
                "type" => "light",
                "background" => "#0000FF",
                "showHeader" => false,
                "header" => [
                        "name" => "Pepito el pistolero",
                        "logo" => "https://res.mobbex.com/images/icons/def_store.png"
                ],
                "colors" => [
                    "primary" => "#FF0000"
                ]
            ]
        ];

        $response = $mobbex->checkout->save();

        $this->assertTrue($response['result']);
    }

    public function test_checkout_cant_execute_with_invalid_data()
    {
        $this->expectException(
            InvalidDataException::class
        );

        $mobbex = $this->getDefaultObject();

        //Obligatorios
        $mobbex->checkout->total = 150.00;
        $mobbex->checkout->currency = 'ARS';
        $mobbex->checkout->description = 'Descripción de venta $150';

        $response = $mobbex->checkout->save();

    }

    public function test_checkout_cant_execute_with_optionaldata()
    {
        $this->expectException(
            InvalidDataException::class
        );

        $mobbex = $this->getDefaultObject();

        //Obligatorios
        $mobbex->checkout->total = 150.00;
        $mobbex->checkout->currency = 'ARS';
        $mobbex->checkout->description = 'Descripción de venta $150';

        $mobbex->checkout->webhook = 123456;
        $mobbex->checkout->redirect = 123456;

        $response = $mobbex->checkout->save();

    }

    //TODO Test Split checkout

}