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
    $car = Car::findOrFail($carId); // 차량 ID에 해당하는 차량 정보 조회

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

        // Check for overlapping reservations
        $overlap = Reservation::where('car_id', $request->car_id)
            ->where(function ($query) use ($request) {
                $query->where('start_time', '<', $request->end_time)
                      ->where('end_time', '>', $request->start_time);
            })->exists();

        if ($overlap) {
            return redirect()->back()->with('error', 'The selected time slot is already booked for this car.')->withInput();
        }

        // Store the reservation
        $reservation = new Reservation;
        $reservation->car_id = $request->car_id;
        $reservation->start_time = Carbon::createFromFormat('Y-m-d\TH:i', $request->start_time);
        $reservation->end_time = Carbon::createFromFormat('Y-m-d\TH:i', $request->end_time);
        $reservation->save();

        return redirect()->route('car_list')->with('success', 'Reservation successfully created.');
    }

    public function checkReservation(Request $request)
    {
        // AJAX 요청을 통해 전달된 데이터의 유효성 검사
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|exists:cars,id',
            'start_time' => 'required|date_format:Y-m-d\TH:i',
            'end_time' => 'required|date_format:Y-m-d\TH:i|after:start_time',
        ]);

        // 유효성 검사 실패 시, JSON으로 오류 응답 반환
        if ($validator->fails()) {
            return response()->json(['isAvailable' => false, 'error' => $validator->errors()]);
        }

        // 예약 중복 여부 확인
        $overlap = Reservation::where('car_id', $request->input('car_id'))
            ->where(function ($query) use ($request) {
                $query->where('start_time', '<', $request->input('end_time'))
                      ->where('end_time', '>', $request->input('start_time'));
            })->exists();

        // 예약 중복 여부에 따라 JSON 응답 반환
        if ($overlap) {
            // 예약이 중복되는 경우
            return response()->json(['isAvailable' => false]);
        } else {
            // 예약이 가능한 경우
            return response()->json(['isAvailable' => true]);
        }
    }
}
