<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Reservation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        form div {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
            display: block;
        }

        input[type="datetime-local"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
            width: calc(100% - 16px); 
        }

        button[type="submit"] {
            padding: 12px 20px;
            background-color: #ffa500;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #ff8000; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>차량 예약하기</h1>
        
        <form id="reservationForm" action="{{ route('car_reservation.store') }}" method="POST">
            @csrf

            <div>
                <label for="car_id">차종:</label>
                <span>{{ $car->make }} {{ $car->model }}</span>
                <input type="hidden" name="car_id" id="car_id" value="{{ $car->id }}">
            </div>
            <br>

            <div>
                <label for="start_time">예약 시작시간:</label>
                <input type="datetime-local" id="start_time" name="start_time" required>
            </div>
            <br>

            <div>
                <label for="end_time">예약 마감시간:</label>
                <input type="datetime-local" id="end_time" name="end_time" required>
            </div>
            <br>
            
            <button type="submit">예약완료하기</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('reservationForm').addEventListener('submit', function (event) {
                event.preventDefault();

                var carId = document.getElementById('car_id').value;
                var startTime = document.getElementById('start_time').value;
                var endTime = document.getElementById('end_time').value;

                fetch('/check-reservation', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ car_id: carId, start_time: startTime, end_time: endTime })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.isAvailable === false) {
                        alert('이미 예약이 되어있으므로 예약시간을 다시 확인해주시길 바랍니다.');
                    } else {
                        alert('예약을 완료했습니다.');
                        event.target.submit();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while checking the reservation.');
                });
            });
        });
    </script>
</body>
</html>
