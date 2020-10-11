<?php


namespace Adue\Mobbex\Modules;


class Checkout extends BaseModule implements ModuleInterface
{

    protected $uri = 'checkout';
    protected $validationRules = [
        'total' => 'required|numeric',
        'currency' => 'required|alpha',
        'description' => 'required',
        'return_url' => 'required|url',
        'reference' => 'required|max:255',

        'webhook' => 'url',
        'redirect' => 'in:true,false',
        'test' => 'in:true,false',
        'items' => 'array',
        'sources' => 'array',
        'options' => 'array',
        'split' => 'array'
    ];

    public function validate()
    {

        $this->validateItems($this->items);

        return parent::validate();

    }

    public function getEmbeded($callbacks = [])
    {
        $html = file_get_contents(__DIR__.'/../../resources/views/checkout.php');
        $html = str_replace('{ID Checkout}', $this->id, $html);

        return $html;
    }

}