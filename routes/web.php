<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController; 
use App\Http\Controllers\CarController; 
use App\Http\Controllers\ReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/', function () {
    return view('contact');
});

Route::get('/blog', function () {
    return view('blog');
});

// '/blog' 라우트는 BlogController의 'door' 메서드로 대체됩니다.
Route::get('/blog', [BlogController::class, 'door'])->name('door');

// 등록된 차량 리스트 페이지
Route::get('/car_list', [CarController::class, 'list'])->name('car_list'); // 이름 수정됨

// 차량 등록 페이지
Route::get('/create', [CarController::class, 'create'])->name('create');

// 차량 생성 폼을 제출할 때 사용하는 라우트
Route::post('/create', [CarController::class, 'store'])->name('create.store');

// 차량 생성 폼을 제출할 때 사용하는 라우트
Route::post('/contact', [CarController::class, 'contact'])->name('contact');

// 상세페이지
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');

// 예약페이지
Route::get('/car_reservation', [ReservationController::class, 'create'])->name('car_reservation.create');

// 예약 폼 제출
Route::post('/car_reservation', [ReservationController::class, 'store'])->name('car_reservation.store');

Route::post('/check-reservation', [ReservationController::class, 'checkReservation'])->name('car_reservation.check');