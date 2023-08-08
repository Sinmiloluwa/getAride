<?php

namespace App\Services\Paystack;

trait Card
{
    public function initialize()
    {
        $this->post('transaction/initialize');
        return $this->response;
    }

    public function chargeAuthorization()
    {
        $this->post('transaction/charge_authorization');
        return $this->response;
    }
}
