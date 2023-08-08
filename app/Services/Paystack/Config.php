<?php

namespace App\Services\Paystack;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class Config
{
    use Card, HttpTrait, Transaction;

    protected string $secretKey;
    protected string $publicKey;
    protected PendingRequest $client;
    protected string $baseUrl = 'https://api.paystack.co/';

    public function __construct()
    {
        $this->setConstant();
        $this->checkConstant();
        $this->prepareClient();

    }

    /**
     * @return void
     */
    protected function setConstant() : void
    {
        $this->secretKey = config('services.paystack.secretKey');
        $this->publicKey = config('services.paystack.publicKey');
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function checkConstant() : void
    {
        if(empty($this->secretKey) || empty($this->publicKey)){
            throw new \Exception('Keys are not set');
        }
    }

    /**
     * @return void
     */
    protected function prepareClient() : void
     {
         $this->client = Http::withToken($this->secretKey)->acceptJson();
     }
}
