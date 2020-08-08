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

    //TODO test transaction search with more data and wrong data
    public function test_transaction_search()
    {
        $responseBody = $this->getPayedTransactions();

        $this->assertArrayHasKey('result', $responseBody);
        $this->assertTrue($responseBody['result']);
    }

    //TODO validate transaction result
    public function test_refund_transaction()
    {
        $mobbex = $this->getDefaultObject();
        $responseBody = $this->getPayedTransactions();

        $response = $mobbex->transaction->refund($responseBody["data"]["docs"][0]["uid"]);

        $this->assertInstanceOf(MobbexResponse::class, $response);

        $responseBody = $response->getBody();

        $this->assertArrayHasKey('result', $responseBody);
        $this->assertTrue(!$responseBody['result']);
    }


    //Transactions test not work
    /*public function test_transaction_status()
    {
        $mobbex = $this->getDefaultObject();

        $mobbex->paymentOrder->total = 150.00;
        $mobbex->paymentOrder->description = 'Descripción de venta $150';

        $paymentOrder = $mobbex->paymentOrder->save();

        $response = $mobbex->transaction->getStatus(123);

        $this->assertInstanceOf(MobbexResponse::class, $response);

        $responseBody = $response->getBody();

        $this->assertArrayHasKey('result', $responseBody);
        $this->assertTrue($responseBody['result']);
    }*/

    /**
     * @return mixed
     */
    private function getPayedTransactions()
    {
        $mobbex = $this->getDefaultObject();

        $mobbex->transaction->searchParams = [
            'page' => 1,
            'limit' => 10
        ];
        $mobbex->transaction->status = $mobbex::getStateCode('payed');
        $mobbex->transaction->currency = 'ARS';
        $mobbex->transaction->created_from = '2020-01-01';
        $mobbex->transaction->created_to = date('Y-m-d');
        $mobbex->transaction->context = 'plugin.value.checkout:web';

        $response = $mobbex->transaction->search();

        $this->assertInstanceOf(MobbexResponse::class, $response);

        $responseBody = $response->getBody();
        return $responseBody;
    }

}