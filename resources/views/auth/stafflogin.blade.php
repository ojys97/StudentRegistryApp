<!DOCTYPE html>
<html>
<head>
    <title>Staff Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
            margin: 0; 
        }

        .form-container {
            text-align: center;
            padding: 40px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: inline-block; 
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button[type="submit"] {
            background-color: blue;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="form-container">
    <div class="title">
        <h1>South of Australia University</h1>
    </div> 
    <h2>Staff Login</h2>
        <form method="POST" action="{{ route('stafflogin.post') }}">
            @csrf
            <p>Please enter your credentials</p>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required autofocus>
            </div>  

            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div>
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
