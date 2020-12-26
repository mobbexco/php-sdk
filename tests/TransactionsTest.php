<?php


namespace Tests;


use Adue\Mobbex\Mobbex;
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

        $this->assertIsArray($response);
    }

    //TODO test transaction search with more data and wrong data
    public function test_transaction_search()
    {
        $transactions = $this->getPayedTransactions();

        $this->assertIsArray($transactions);
    }

    //TODO validate transaction result
    public function test_refund_transaction()
    {
        $mobbex = $this->getDefaultObject();
        $transactions = $this->getPayedTransactions();

        $uid = $transactions[0]->uid;

        $response = $mobbex->transaction->refund($uid);

        $mobbex->transaction->getStatus($uid);

        $this->assertTrue($mobbex->transaction->status == Mobbex::getStateCode('Declinada'));

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

        $response = $mobbex->transaction->search([
            'pagination' => [
                'page' => 1,
                'limit' => 10
            ],
            'form_params' => [
                'status' => $mobbex::getStateCode(200),
                'currency' => 'ARS',
                'created_from' => '2020-01-01',
                'created_to' => date('Y-m-d'),
                'context' => 'plugin.value.checkout:web',
            ]
        ]);

        return $response;
    }

}