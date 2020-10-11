<?php


namespace Tests;


use Adue\Mobbex\Exceptions\InvalidDataException;
use Adue\Mobbex\MobbexResponse;
use Adue\Mobbex\Modules\PaymentOrder;

class PaymentOrderTest extends BaseTestCase
{

    public function test_payment_order_creation()
    {
        $mobbex = $this->getDefaultObject();

        $paymentOrder = $mobbex->paymentOrder;

        $this->assertInstanceOf(PaymentOrder::class, $paymentOrder);
    }

    public function test_payment_order_execute_succesfully_with_required_data()
    {
        $mobbex = $this->getDefaultObject();

        $mobbex->paymentOrder->total = 150.00;
        $mobbex->paymentOrder->description = 'Descripción de venta $150';

        $response = $mobbex->paymentOrder->save();

        $this->assertTrue($response['result']);
    }

    public function test_payment_order_execute_succesfully_with_optional_data()
    {
        $mobbex = $this->getDefaultObject();

        $mobbex->paymentOrder->total = 150.00;
        $mobbex->paymentOrder->description = 'Descripción de venta $150';
        $mobbex->paymentOrder->due = [
            'day' => 01,
            'month' => 01,
            'year' => 2021,
        ];
        $mobbex->paymentOrder->actions = [
            [
                "icon" => "attachment",
                "title"  => "Factura",
                "url" => "https://speryans.com/mifactura/123"
            ]
        ];
        $mobbex->paymentOrder->reference = "mi_referencia_123";
        $mobbex->paymentOrder->webhook = "http://webhook.com";

        $response = $mobbex->paymentOrder->save();

        $this->assertTrue($response['result']);
    }

    public function test_payment_order_fail_with_wrong_optional_data()
    {
        $this->expectException(
            InvalidDataException::class
        );

        $mobbex = $this->getDefaultObject();

        $mobbex->paymentOrder->total = 150.00;
        $mobbex->paymentOrder->description = 'Descripción de venta $150';
        $mobbex->paymentOrder->due = [
            'day' => 01,
            'month' => 01,
            'year' => 2021,
        ];
        $mobbex->paymentOrder->actions = [
            [
                "icon" => "attachment",
                "title"  => "Factura",
                "url" => "https://speryans.com/mifactura/123"
            ]
        ];
        $mobbex->paymentOrder->reference = "mi_referencia_123";
        $mobbex->paymentOrder->webhook = "http://webhook.com";

        //Wrong Data
        $mobbex->paymentOrder->email = 123456;
        $mobbex->paymentOrder->actions = 'anything';

        $response = $mobbex->paymentOrder->save();
    }

}