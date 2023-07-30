<?php

namespace App\Http\Controllers;

use App\Http\Requests\Driver\DriverUpdateRequest;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user()->load('driver');
        return $user;
    }

    public function update(DriverUpdateRequest $request)
    {
        $details = $request->validated();

        $user = $request->user();

        $user->update($request->only('name'));

        $user->driver()->updateOrCreate($request->only([
            'year',
            'make',
            'color',
            'model',
            'license_plate'
        ]));

        $user->load('driver');

        return $user;
    }
}
