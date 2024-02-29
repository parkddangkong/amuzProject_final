<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Car List</title>
</head>
<body>
    <h1>Car List</h1>
    <ul>
        @foreach ($cars as $car)
            <li>
                <a href="{{ route('cars.show', $car->id) }}">
                    {{ $car->make }} {{ $car->model }} ({{ $car->registration_number }})
                </a>
                @if ($car->image)
                    <img src="{{ asset('images/' . $car->image) }}" alt="{{ $car->make }} {{ $car->model }}" style="width:100px; height:auto;">
                @else
                    No image available
                @endif
            </li>
        @endforeach
    </ul>
</body>
</html>