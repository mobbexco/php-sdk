<?php


namespace Adue\Mobbex\Traits;


use Adue\Mobbex\Exceptions\InvalidDataException;
use Rakit\Validation\Validator;

trait ValidationsTratit
{

    public function validateItems($items)
    {
        if($items == null) return;

        $validator = new Validator();
        foreach ($items as $item) {
            $validation = $validator->validate($item, [
                'image' => 'url',
                'quantity' => 'numeric',
                'total' => 'numeric',
            ]);

            return !$validation->fails();
        }
    }

}