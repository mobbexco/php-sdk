<?php


namespace Tests;


use Adue\Mobbex\Exceptions\InvalidDataException;
use Adue\Mobbex\MobbexResponse;
use Adue\Mobbex\Modules\PaymentCode;

class PaymentCodeTest extends BaseTestCase
{

    public function test_payment_code_creation()
    {
        $mobbex = $this->getDefaultObject();

        $paymentCode = $mobbex->paymentCode;

        $this->assertInstanceOf(PaymentCode::class, $paymentCode);
    }

    public function test_payment_code_execute_succesfully_with_required_data()
    {
        $mobbex = $this->getDefaultObject();

        $mobbex->paymentCode->total = 150.00;
        $mobbex->paymentCode->reference = '0002-00000002';
        $mobbex->paymentCode->expiration = date('d-m-Y');

        $response = $mobbex->paymentCode->save();

        $this->isImage($response);
    }

    public function test_payment_code_execute_succesfully_with_optional_data()
    {
        $mobbex = $this->getDefaultObject();

        $mobbex->paymentCode->total = 150.00;
        $mobbex->paymentCode->reference = '0002-00000002';
        $mobbex->paymentCode->expiration = date('d-m-Y');

        $mobbex->paymentCode->email = 'user@email.com';
        $mobbex->paymentCode->surchargeDays = 2;
        $mobbex->paymentCode->surchargeTotal = 50;

        $response = $mobbex->paymentCode->save();

        $this->isImage($response);
    }

    public function test_payment_code_cant_execute_with_invalid_data()
    {
        $this->expectException(
            InvalidDataException::class
        );

        $mobbex = $this->getDefaultObject();

        $mobbex->paymentCode->total = 150.00;
        $mobbex->paymentCode->reference = '0002-00000002';
        $mobbex->paymentCode->expiration = date('Y-m-d');

        $response = $mobbex->checkout->save();

    }

    private function isImage($response)
    {
        $my_file = 'image.png';
        $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file); //implicitly creates file
        fwrite($handle, $response->getBody(false));
        fclose($handle);

        $this->assertEquals('image/png', mime_content_type($my_file));

        unlink($my_file);
    }

}