<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $car->make }} {{ $car->model }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        p {
            margin-bottom: 10px;
        }

        img {
            display: block;
            margin: 0 auto 20px;
            border-radius: 8px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin-bottom: 20px;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            display: block;
            width: 200px;
            margin: 0 auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #0056b3;
        }

        .reservation-button {
            background-color: #ffa500;
        }

        .reservation-button:hover {
            background-color: #ff8000;
        }
        .main-button {
            background-color: #ffa500;
            color: white;
            padding: 15px 30px; 
            font-size: 18px; 
            border: none;
            border-radius: 4px; 
            margin: 20px auto; 
            display: block; 
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .main-button:hover {
            background-color: #ff8000;
        }
    </style>
</head>
<body>
    <div class="header">
        <button onclick="window.location='/'" class="main-button">메인 페이지로</button>
    </div>

    <div class="container">
        <h1>{{ $car->make }} {{ $car->model }}</h1>
        <p>차량번호: {{ $car->registration_number }}</p>
        @if ($car->image)
            <img src="{{ asset('images/' . $car->image) }}" alt="Car Image" style="width:200px;">
        @endif

        <h2>예약정보</h2>
        @if($car->reservations->isEmpty())
            <p>이 차에 대한 예약은 아직 없습니다.</p>
        @else
            <ul>
                @foreach($car->reservations as $reservation)
                    <li>예약 접수시간: {{ $reservation->start_time }} 예약 마감시간: {{ $reservation->end_time }}</li>
                @endforeach
            </ul>
        @endif

        <a class="reservation-button" href="{{ route('car_reservation.create', ['car_id' => $car->id]) }}">이 차량 예약하기</a>
    </div>
</body>
</html>
