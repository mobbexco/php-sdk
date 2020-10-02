<?php


namespace Adue\Mobbex\Modules;


use Adue\Mobbex\Exceptions\InvalidDataException;
use Rakit\Validation\Validator;

class PaymentOrder extends BaseModule implements ModuleInterface
{

    protected $uri = 'payment_order';
    protected $validationRules = [
        'total' => 'required|numeric',
        'description' => 'required',
        'email' => 'email',
        'phone' => 'digits_between:10,15',
        'due' => 'array',
        'secondDue' => 'array',
        'actions' => 'array',
        'return_url' => 'url',
        'webhook' => 'url',
        'items' => 'array',
        'options' => 'array',
    ];

    public function validate()
    {

        parent::validate();

        $this->validateDueDate($this->due);
        $this->validateSecondDue($this->secondDue);
        $this->validateActions($this->actions);
        $this->validateItems($this->items);
        return $this->validateOptions($this->options);

    }

    private function validateDueDate($dueDate)
    {

        if($dueDate == null) return;

        if(!isset($dueDate['year']) || !isset($dueDate['month']) || !isset($dueDate['day']))
            throw new InvalidDataException(serialize(['The due input must have year, month and day values']));

        $validator = new Validator();

        $date = $dueDate['year'] . '-' . $dueDate['month'] . '-' . $dueDate['day'];

        $validation = $validator->validate(compact('date'), [
            'date' => 'date:Y-m-d'
        ]);

        if($validation->fails())
            throw new InvalidDataException(serialize(['Invalid data']));

        return !$validation->fails();
    }

    private function validateSecondDue($secondDue)
    {

        if($secondDue == null) return;

        if(!isset($secondDue['days']) || !isset($secondDue['surcharge']))
            throw new InvalidDataException(serialize(['The due input must have days and surcharge values']));

        $validator = new Validator();

        $validation = $validator->validate($secondDue, [
            'days' => 'integer',
            'surcharge' => 'numeric',
        ]);

        if($validation->fails())
            throw new InvalidDataException(serialize(['Invalid data']));

        return !$validation->fails();
    }

    private function validateActions($actions)
    {
        if($actions == null) return;

        $validator = new Validator();

        $validation = $validator->validate($actions, [
            'url' => 'url',
        ]);

        if($validation->fails())
            throw new InvalidDataException(serialize(['Invalid data']));

        return !$validation->fails();
    }

    private function validateOptions($options)
    {
        if($options == null) return;

        $validator = new Validator();

        $validation = $validator->validate($options, [
            'smsMessage' => 'max:140',
        ]);

        if($validation->fails())
            throw new InvalidDataException(serialize(['Invalid data']));

        return !$validation->fails();
    }
}