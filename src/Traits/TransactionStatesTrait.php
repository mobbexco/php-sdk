<?php


namespace Adue\Mobbex\Traits;


trait TransactionStatesTrait
{
    //TODO all transaction states
    private static $transactionStates = [
        'no_state' => 0,
        'pending' => 1,
        'payed' => 200
    ];

    public static function getStateCode($state)
    {
        return self::$transactionStates[$state];
    }

    public static function getAll($assocc = true)
    {
        if($assocc)
            return self::$transactionStates;

        return array_values(self::$transactionStates);
    }
}