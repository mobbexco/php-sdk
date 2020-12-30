<?php


namespace Adue\Mobbex;

use Adue\Mobbex\Exceptions\ModuleNotFound;
use Adue\Mobbex\Modules\Checkout;
use Adue\Mobbex\Modules\DevConnect;
use Adue\Mobbex\Modules\Operation;
use Adue\Mobbex\Modules\PaymentCode;
use Adue\Mobbex\Modules\PaymentOrder;
use Adue\Mobbex\Modules\Sources;
use Adue\Mobbex\Modules\Subscription;
use Adue\Mobbex\Modules\Transaction;
use Adue\Mobbex\Traits\TransactionStatesTrait;

class Mobbex
{
    use TransactionStatesTrait;

    private $apiKey;
    private $accessToken;

    private $modules = [
        'checkout' => Checkout::class,
        'paymentOrder' => PaymentOrder::class,
        'sources' => Sources::class,
        'paymentCode' => PaymentCode::class,
        'subscription' => Subscription::class,
        'transaction' => Transaction::class,
        'operation' => Operation::class,
        'devConnect' => DevConnect::class,
    ];

    private $sharing = [];

    /**
     * Mobbex constructor.
     * @param $apiKey
     * @param $accessToken
     */
    public function __construct($apiKey, $accessToken = false)
    {
        $this->apiKey = $apiKey;

        if($accessToken)
            $this->accessToken = $accessToken;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param mixed $apiKey
     */
    public function setApiKey($apiKey): void
    {
        $this->apiKey = $apiKey;
    }
    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param mixed $accessToken
     */
    public function setAccessToken($accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    public function __get($property)
    {
        if(in_array($property, array_keys($this->modules))) {
            if(!in_array($property, array_keys($this->sharing)))
                return $this->sharing[$property] = new $this->modules[$property]($this);
            return $this->sharing[$property];
        }

        throw new ModuleNotFound;
    }

}