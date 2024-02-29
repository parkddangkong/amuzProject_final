<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Car</title>
</head>
<body>
    <h1>Create New Car</h1>
    
    <form action="{{ route('create') }}" method="POST" enctype="multipart/form-data">
        @csrf <!-- CSRF Token -->
        
        <label for="make">Make:</label>
        <input type="text" name="make" id="make" required>
        
        <label for="model">Model:</label>
        <input type="text" name="model" id="model" required>
        
        <label for="registration_number">Registration Number:</label>
        <input type="text" name="registration_number" id="registration_number" required>
        
        <label for="image">Car Image:</label>
        <input type="file" name="image" id="image">
        
        <button type="submit">Submit</button>
    </form>
</body>
</html>