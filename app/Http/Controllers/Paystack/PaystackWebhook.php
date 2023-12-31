<?php

namespace App\Http\Controllers\Paystack;

use App\Enums\TransactionChannel;
use App\Enums\TransactionStatus;
use App\Http\Controllers\Controller;
use App\Models\SavedCard;
use App\Models\Transaction;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaystackWebhook extends Controller
{
    public function handle(Request $request){

        $method = Str::replace('.', '', ucwords($request->event, '.'));

        if(method_exists($this, $handler ='handle' . $method)){
            $this->{$handler}($request->data);
        }

    }

    public function checkTransaction($request, $transaction)
    {
        return ($request['status'] === 'success' && $transaction);
    }

    /**
     * @param $request
     * @return void
     * @throws \Exception
     */
    public function handleChargeSuccess($request)
    {
        if ($request['metadata']['payment_type'] == 'trip') {
            Log::info($request);
            $this->updatePaymentType($request);
        }

        $transaction = Transaction::where('reference', $request['reference'])->first();

        if (! $this->checkTransaction($request, $transaction)) throw new \Exception('Invalid Transaction');
        $user = User::where('email', $request['customer']['email'])->first();


        SavedCard::create([
            'authorization_code' => $request['authorization']['authorization_code'],
            'card_type' => $request['authorization']['card_type'],
            'email' => $request['customer']['email'],
            'user_id' => $user->id,
            'signature' => $request['authorization']['signature']
        ]);

        $transaction->status = TransactionStatus::Successful;
        $transaction->save();
    }

    public function updatePaymentType($request) {
        $transaction = Transaction::where('trip_id', $request['metadata']['trip_id'])->first();
        Log::info($transaction);
        $trip = Trip::where('id', $request['metadata']['trip_id'])->first();
        $transaction->trip_id = $request['metadata']['trip_id'];
        $trip->payment_type = TransactionChannel::Card;
        $transaction->save();
        $trip->save();
    }
}

