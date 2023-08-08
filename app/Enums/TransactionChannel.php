<?php

namespace App\Enums;

enum TransactionChannel:string
{
    case Transfer = 'transfer';
    case Card = 'card';

    case Cash = 'cash';
}
