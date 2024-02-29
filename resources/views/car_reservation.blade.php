<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF 토큰 메타 태그 추가 -->
    <title>Create Reservation</title>
    <script>
        // 폼 제출 이벤트 리스너
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('reservationForm').addEventListener('submit', function (event) {
                event.preventDefault(); // 폼 제출 방지

                var carId = document.getElementById('car_id').value;
                var startTime = document.getElementById('start_time').value;
                var endTime = document.getElementById('end_time').value;

                // AJAX 요청을 보내는 부분
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
                        // 예약이 불가능한 경우 경고 창 표시
                        alert('이미 예약이 되어있으므로 예약시간을 다시 확인해주시길 바랍니다.');
                    } else {
                        // 예약이 가능한 경우 폼 제출
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
</head>
<body>
    <h1>Create a New Reservation</h1>
    
    <!-- 예약 폼 -->
    <form id="reservationForm" action="{{ route('car_reservation.store') }}" method="POST">
        @csrf

        <!-- 차량 정보 표시 -->
        <div>
            <label for="car_id">Car:</label>
            <span>{{ $car->make }} {{ $car->model }}</span>
            <!-- Hidden 필드로 차량 ID 전달 -->
            <input type="hidden" name="car_id" id="car_id" value="{{ $car->id }}">
        </div>
        <br>

        <!-- 예약 시작 시간 입력 -->
        <label for="start_time">Start Time:</label>
        <input type="datetime-local" id="start_time" name="start_time" required>
        <br>

        <!-- 예약 종료 시간 입력 -->
        <label for="end_time">End Time:</label>
        <input type="datetime-local" id="end_time" name="end_time" required>
        <br>
        
        <!-- 예약 제출 버튼 -->
        <button type="submit">Submit Reservation</button>
    </form>

</body>
</html>
