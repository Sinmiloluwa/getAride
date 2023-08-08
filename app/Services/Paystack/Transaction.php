<?php

namespace App\Services\Paystack;

trait Transaction
{
    /**
     * @return mixed
     */
    public function verify($reference)
    {
        $this->get('transaction/verify/'.$reference);
        return $this->response;
    }
}
