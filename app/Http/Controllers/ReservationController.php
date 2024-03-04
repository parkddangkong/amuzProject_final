<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function create(Request $request)
{
    $carId = $request->query('car_id');
    $car = Car::findOrFail($carId); 

    return view('car_reservation', compact('car'));
}

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|exists:cars,id',
            'start_time' => 'required|date_format:Y-m-d\TH:i',
            'end_time' => 'required|date_format:Y-m-d\TH:i|after:start_time',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $overlap = Reservation::where('car_id', $request->car_id)
            ->where(function ($query) use ($request) {
                $query->where('start_time', '<', $request->end_time)
                      ->where('end_time', '>', $request->start_time);
            })->exists();

        if ($overlap) {
            return redirect()->back()->with('error', 'The selected time slot is already booked for this car.')->withInput();
        }

        $reservation = new Reservation;
        $reservation->car_id = $request->car_id;
        $reservation->start_time = Carbon::createFromFormat('Y-m-d\TH:i', $request->start_time);
        $reservation->end_time = Carbon::createFromFormat('Y-m-d\TH:i', $request->end_time);
        $reservation->save();

        return redirect()->route('car_list')->with('success', 'Reservation successfully created.');
    }

    public function checkReservation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|exists:cars,id',
            'start_time' => 'required|date_format:Y-m-d\TH:i',
            'end_time' => 'required|date_format:Y-m-d\TH:i|after:start_time',
        ]);

        if ($validator->fails()) {
            return response()->json(['isAvailable' => false, 'error' => $validator->errors()]);
        }

        $overlap = Reservation::where('car_id', $request->input('car_id'))
            ->where(function ($query) use ($request) {
                $query->where('start_time', '<', $request->input('end_time'))
                      ->where('end_time', '>', $request->input('start_time'));
            })->exists();


        if ($overlap) {
            return response()->json(['isAvailable' => false]);
        } else {
            return response()->json(['isAvailable' => true]);
        }
    }
}
