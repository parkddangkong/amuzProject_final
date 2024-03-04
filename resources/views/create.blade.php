<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Car</title>
    <style>
        /* 기존 스타일 유지 */
        body {
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .container, .header {
            max-width: 500px;
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
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
        }
        input[type="text"], input[type="file"] {
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            color: #333;
        }
        button {
            padding: 12px 20px;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .main-button {
            background-color: #ffa500; 
            margin-bottom: 20px; 
            margin-left: 35%;
        }
        .main-button:hover {
            background-color: #ff8000; 
        }
        .submit-button {
            background-color: #ffa500; 
        }
        .submit-button:hover {
            background-color: #ff8000; 
        }
    </style>
</head>
<body>
    <div class="header">
        <button onclick="window.location='/'" class="main-button">메인 페이지로</button>
    </div>
    <div class="container">
        <h1>차량 등록하기</h1>
        
        <form action="{{ route('create') }}" method="POST" enctype="multipart/form-data">
            @csrf 
     
            
            <label for="make">차종:</label>
            <input type="text" name="make" id="make" required>
            
            <label for="model">차량 모델명:</label>
            <input type="text" name="model" id="model" required>
            
            <label for="registration_number">차량 번호:</label>
            <input type="text" name="registration_number" id="registration_number" required>
            
            <label for="image">차량 이미지 주소:</label>
            <input type="file" name="image" id="image">
            
            <button type="submit" class="submit-button">등록하기</button>
        </form>
    </div>
</body>
</html>
