<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>

        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .box {
            background-color: #f0f0f0; 
            padding: 20px; 
            margin: 10px; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
        }

    
        .box a {
            text-decoration: none;
            color: #333; 
            font-weight: bold; 
            
        }
        .title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="title">
        <h1>South of Australia University</h1>
    </div> 
    <div class="box">
        <a href="/studentlogin/get">Student Login</a>
    </div>

    <div class="box">
        <a href="/studentregister/get">Student Register</a>
    </div>

    <div class="box">
        <a href="/stafflogin/get">Staff Login</a>
    </div>

    <div class="box">
        <a href="/staffregister/get">Staff Register</a>
    </div>
</body>
</html>
