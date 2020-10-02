<?php


namespace Adue\Mobbex\Modules;

use Adue\Mobbex\Exceptions\InvalidDataException;
use Adue\Mobbex\Mobbex;
use Adue\Mobbex\MobbexResponse;

class Sources extends BaseModule implements ModuleInterface
{
    protected $method = 'GET';
    private $widgetCode;

    protected $validationRules = [
        'widgetCode' => 'alpha_num',
    ];

    public function __construct(Mobbex $mobbex)
    {
        parent::__construct($mobbex);
        $this->uri = 'sources';
    }

    public function setWidgetCode($widgetCode)
    {
        $this->widgetCode = $widgetCode;
    }

    public function paymentMethods($total)
    {
        $this->validateData($total);

        $response = $this->makeRequest([
            'method' => 'GET',
            'uri' => $this->uri . '?total=' . $total
        ]);

        return new MobbexResponse($response);
    }

    protected function validateData($total)
    {
        $this->validate();
        $validation = $this->validator->validate(['total' => $total], [
            'total' => 'required|numeric'
        ]);
        if($validation->fails()) {
            $errors = $validation->errors();
            throw new InvalidDataException(serialize($errors->all()));
        }
    }

}