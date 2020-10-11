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

        $operations = $mobbex->operation->filter([
            'page' => 1,
            'limit' => 20,
        ]);

        $this->assertIsArray($operations);

        foreach ($operations as $operation)
            $this->assertInstanceOf(Operation::class, $operation);

    }

    //TODO test advanced transactions filters

    //TODO Fix this test. CheckResult
    public function operation_refund()
    {
        $mobbex = $this->getDefaultObject();

        $mobbex->paymentOrder->total = 150.00;
        $mobbex->paymentOrder->description = 'Descripción de venta $150';

        $orderResponse = $mobbex->paymentOrder->save();

        $response = $mobbex->operation->refund($orderResponse['data']['uid']);

        $this->assertTrue($response['result']);
    }

}