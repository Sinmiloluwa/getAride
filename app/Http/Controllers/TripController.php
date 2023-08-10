<?php

namespace App\Http\Controllers;

use App\Enums\TransactionChannel;
use App\Enums\TransactionStatus;
use App\Events\TripAccepted;
use App\Events\TripCompleted;
use App\Events\TripLocationUpdated;
use App\Events\TripStarted;
use App\Models\SavedCard;
use App\Models\Transaction;
use App\Models\Trip;
use App\Services\Paystack\Paystack;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Trip\TripRequest;

class TripController extends Controller
{
    public function store(TripRequest $request)
    {
        return $request->user()->trips()->create($request->only([
            'pick_up',
            'destination',
            'destination_name'
        ]));
    }

    public function show(Request $request, Trip $trip)
    {
       if ($trip->user->id === $request->user()->id) {
            return $trip;
       }

       if($trip->driver && $request->user()->driver) {
            if($trip->driver->id === $request->user()->driver->id) {
                return $trip;
            }
       }

       return response()->json([
            'message' => 'No trip found'
       ], 404);
    }

    public function accept(Request $request, Trip $trip)
    {
        $request->validate([
            'driver_location' => 'required'
        ]);

        $trip->update([
            'driver_id' => $request->user()->id,
            'driver_location' => $request->driver_location
        ]);

        $trip->load('driver.user');

        TripAccepted::dispatch($trip, $request->user());

        return $trip;
    }

    public function start(Request $request, Trip $trip)
    {
        $trip->update([
            'trip_started' => true
        ]);

        $trip->load('driver.user');

        TripStarted::dispatch($trip, $request->user());

        return $trip;
    }

    public function location(Request $request, Trip $trip)
    {
        $request->validate([
            'driver_location' => 'required'
        ]);

        $trip->update([
            'driver_location' => $request->driver_location
        ]);

        $trip->load('driver.user');

        TripLocationUpdated::dispatch($trip, $request->user());

        return $trip;
    }

    public function end(Request $request, Trip $trip)
    {
        $trip->update([
            'trip_completed' => true
        ]);

        $trip->load('driver.user');

        TripCompleted::dispatch($trip, $request->user());

        return $trip;
    }

    /**
     * @param Trip $trip
     * @return JsonResponse
     */
    public function cancel(Trip $trip)
    {
        if (!$trip->trip_completed) {
            $trip->delete();
            return $this->successResponse('You sucessfully cancelled the trip');
        } else {
            return $this->badRequestResponse('You cannot cancel this trip');
        }
    }

    public function pay(Request $request, Trip $trip)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'card_id' => 'required|exists:saved_cards,id',
            'driver' => 'required|exists:drivers,id',
        ]);

        $transaction = Transaction::create([
            'user_id' => $request->user()->id,
            'status' => TransactionStatus::Pending,
            'type' => TransactionChannel::Card,
            'narration' => 'trip',
            'reference' => uniqid('TRF'),
            'transaction_generated_ref' => uniqid('MyRide'),
            'source' => $request->user()->id,
            'trip_id' => $trip->id,
            'destination' => $request->driver ?? null
        ]);
        $metadata = json_encode(['payment_type' => 'trip', 'trip_id' => $trip->id, 'driver' => $request->driver]);

        $savedCard = SavedCard::where('id', $request->card_id)->first();

        return Paystack::add('email', $request->user()->email)
            ->add('amount', $request->amount * 100)
            ->add('reference', $transaction['reference'])
            ->add('authorization_code', $savedCard->authorization_code)
            ->add('metadata', $metadata)
            ->chargeAuthorization();
    }
}
