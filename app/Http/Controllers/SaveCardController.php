<?php

namespace App\Http\Controllers;

use App\Enums\CardTransactionAmount;
use App\Enums\TransactionChannel;
use App\Enums\TransactionStatus;
use App\Models\SavedCard;
use App\Models\Transaction;
use App\Services\Paystack\Paystack;
use Illuminate\Http\Request;

class SaveCardController extends Controller
{
    public function initialize(Request $request)
    {
        $transaction = Transaction::create([
            'user_id' => $request->user()->id,
            'status' => TransactionStatus::Pending,
            'type' => TransactionChannel::Card,
            'narration' => 'Save Card',
            'reference' => uniqid('TRF'),
            'transaction_generated_ref' => uniqid('MyRide'),
            'source' => $request->user()->id,
            'destination' => null

        ]);
        return Paystack::add('email', $request->user()->email)
            ->add('amount', intval(CardTransactionAmount::SaveCard) * 100)
            ->add('reference', $transaction['reference'])
            ->add('callback_url', $request->callback_url ?? null)
            ->add('channels', $request->channels ?? null)
            ->initialize();
    }

    public function chargeCard(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'card_id' => 'required|exists:saved_cards,id'
        ]);

        $transaction = Transaction::create([
            'user_id' => $request->user()->id,
            'status' => TransactionStatus::Pending,
            'type' => TransactionChannel::Card,
            'narration' => 'trip',
            'reference' => uniqid('TRF'),
            'transaction_generated_ref' => uniqid('MyRide'),
            'source' => $request->user()->id,
            'destination' => null
        ]);
        $metadata = json_encode(['payment_type' => 'trip']);

        $savedCard = SavedCard::where('id', $request->card_id)->first();

        return Paystack::add('email', $request->user()->email)
            ->add('amount', $request->amount * 100)
            ->add('reference', $transaction['reference'])
            ->add('authorization_code', $savedCard->authorization_code)
            ->add('metadata', $metadata)
            ->chargeAuthorization();
    }
}
