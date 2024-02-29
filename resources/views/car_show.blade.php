<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>{{ $car->make }} {{ $car->model }}</h1>
<p>Registration Number: {{ $car->registration_number }}</p>
@if ($car->image)
    <img src="{{ asset('images/' . $car->image) }}" alt="Car Image" style="width:200px;">
@endif

<h2>예약정보</h2>
@if($car->reservations->isEmpty())
    <p>이 차에 대한 예약은 아직 없습니다.</p>
@else
    <ul>
        @foreach($car->reservations as $reservation)
            <li>From: {{ $reservation->start_time }} To: {{ $reservation->end_time }}</li>
        @endforeach
    </ul>
@endif

<a href="{{ route('car_reservation.create', ['car_id' => $car->id]) }}">이 차량 예약하기</a>

  

</body>
</html>