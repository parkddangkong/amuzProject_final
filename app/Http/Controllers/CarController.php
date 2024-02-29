<?php
namespace App\Http\Controllers;
use App\Models\Car;
use App\Models\Reservation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CarController extends Controller
{
    public function create()
    {
        return view('create');
    }

    public function list()
{
    // 데이터베이스에서 모든 차량 데이터를 가져옵니다.
    $cars = Car::all();

    // 가져온 데이터를 'car_list'라는 뷰로 전달합니다.
    // 뷰에서는 이 데이터를 사용하여 사용자에게 차량 목록을 보여줄 수 있습니다.
    return view('car_list', ['cars' => $cars]);
}

public function store(Request $request)
{
    // 데이터 유효성 검사
    $validated = $request->validate([
        'make' => 'required|max:255',
        'model' => 'required|max:255',
        'registration_number' => 'required|unique:cars|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // 데이터 저장
    $car = new Car;
    $car->make = $request->make;
    $car->model = $request->model;
    $car->registration_number = $request->registration_number;
    
    if ($request->hasFile('image')) {
        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('images'), $imageName);
        $car->image = $imageName;
    }

    $car->save();

    // 저장 후 리디렉션
    return redirect()->route('contact')->with('success','Car created successfully.');
}

public function show($id)
{
    $car = Car::findOrFail($id);
    $reservations = Reservation::where('car_id', $id)->get();

    return view('car_show', compact('car', 'reservations'));
}

}