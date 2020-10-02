<?php


namespace Tests;

use Adue\Mobbex\Exceptions\InvalidDataException;
use Adue\Mobbex\Modules\Sources;

class SourcesTest extends BaseTestCase
{

    private $widgetCode = '8a3a478c-dd42-41fb-a7c0-a01e87abcd35';

    public function test_sources_creation()
    {
        $mobbex = $this->getDefaultObject();

        $sources = $mobbex->sources;

        $this->assertInstanceOf(Sources::class, $sources);
    }

    public function test_sources_list()
    {
        $mobbex = $this->getDefaultObject();

        $total = 10000;

        $response = $mobbex->sources->paymentMethods($total);
        $responseBody = $response->getBody();

        $this->assertIsArray($responseBody);

    }

    public function test_cant_get_list_with_non_numeric_total_value()
    {
        $this->expectException(
            InvalidDataException::class
        );

        $mobbex = $this->getDefaultObject();

        $total = 'ABC';

        $mobbex->sources->paymentMethods($total);
    }

    public function test_cant_get_list_with_empty_total_value()
    {
        $this->expectException(
            \ArgumentCountError::class
        );

        $mobbex = $this->getDefaultObject();

        $mobbex->sources->paymentMethods();
    }

}