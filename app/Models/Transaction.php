<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'type',
        'reference',
        'transaction_generated_ref',
        'destination',
        'source',
        'narration'
    ];

    protected $casts = [
        'status' => TransactionStatus::class
    ];
}
