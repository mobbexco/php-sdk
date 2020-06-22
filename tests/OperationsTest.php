<?php


namespace Tests;


use Adue\Mobbex\MobbexResponse;
use Adue\Mobbex\Modules\Operation;

class OperationsTest extends BaseTestCase
{

    public function test_operation_creation()
    {
        $mobbex = $this->getDefaultObject();

        $operation = $mobbex->operation;

        $this->assertInstanceOf(Operation::class, $operation);
    }

    public function test_operations_base_filtered_list()
    {
        $mobbex = $this->getDefaultObject();

        $mobbex->operation->page = 1;
        $mobbex->operation->limit = 20;
        $response = $mobbex->operation->filter();

        $this->assertInstanceOf(MobbexResponse::class, $response);

        $responseBody = $response->getBody();

        $this->assertArrayHasKey('result', $responseBody);
        $this->assertTrue($responseBody['result']);
    }

    //TODO test advanced transactions filters

    //TODO CheckResult
    public function test_operation_refund()
    {
        $mobbex = $this->getDefaultObject();

        $mobbex->paymentOrder->total = 150.00;
        $mobbex->paymentOrder->description = 'Descripción de venta $150';

        $orderResponse = $mobbex->paymentOrder->save()->getBody();

        $response = $mobbex->operation->refund($orderResponse['data']['uid']);

        $this->assertInstanceOf(MobbexResponse::class, $response);

        $responseBody = $response->getBody();

        $this->assertArrayHasKey('result', $responseBody);
        $this->assertTrue(!$responseBody['result']);
    }

}