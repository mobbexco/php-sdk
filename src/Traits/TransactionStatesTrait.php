<?php


namespace Adue\Mobbex\Traits;


trait TransactionStatesTrait
{

    private static $transactionStates = [
        0 => "Sin Estado",
        1 => "Pendiente",
        2 => "En Espera",
        3 => "Autorizada",
        4 => "Entregada",
        100 => "En Revisión",
        200 => "Paga",
        201 => "Aceptada",
        210 => "Retenida",
        299 => "Liquidación en Progreso",
        300 => "Liquidada",
        301 => "Liberada",
        302 => "Conciliada",
        303 => "Liberación Retenida",
        400 => "Declinada",
        401 => "Expirada",
        402 => "Abandonada",
        403 => "Fallida",
        410 => "Denegada: Fondos insuficientes",
        411 => "Denegada: Autorización Requerida",
        412 => "Denegada: Comercio Inválido",
        413 => "Denegada: Tarjeta Inválida",
        414 => "Denegada: Problema en la Red",
        415 => "Denegada: Operación Inválida",
        500 => "Error",
        600 => "Cancelación en proceso",
        601 => "Cancelada",
        602 => "Devuelta",
        603 => "Desconocida",
        605 => "Parcialmente Devuelta",
        800 => "Lista",
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