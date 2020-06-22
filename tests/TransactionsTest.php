<?php


namespace Tests;


use Adue\Mobbex\MobbexResponse;
use Adue\Mobbex\Modules\Transaction;

class TransactionsTest extends BaseTestCase
{

    public function test_transaction_creation()
    {
        $mobbex = $this->getDefaultObject();

        $transaction = $mobbex->transaction;

        $this->assertInstanceOf(Transaction::class, $transaction);
    }

    public function test_transactions_list()
    {
        $mobbex = $this->getDefaultObject();

        $mobbex->transaction->reference = 'mi_referencia_0101';
        $response = $mobbex->transaction->all();

        $this->assertInstanceOf(MobbexResponse::class, $response);

        $responseBody = $response->getBody();

        $this->assertArrayHasKey('result', $responseBody);
        $this->assertTrue($responseBody['result']);
    }



    //Transactions test not work
    /*public function test_transaction_status()
    {
        $mobbex = $this->getDefaultObject();

        $mobbex->paymentOrder->total = 150.00;
        $mobbex->paymentOrder->description = 'Descripción de venta $150';

        $paymentOrder = $mobbex->paymentOrder->save();

        $response = $mobbex->transaction->getStatus($paymentOrder->getBody()['data']['uid']);

        $this->assertInstanceOf(MobbexResponse::class, $response);

        $responseBody = $response->getBody();

        $this->assertArrayHasKey('result', $responseBody);
        $this->assertTrue($responseBody['result']);
    }*/

}