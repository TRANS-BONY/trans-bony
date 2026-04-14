<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Trans Bony</title>
    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>
        body {
            background: url('/images/bg-truck.jpg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        .glass {
            backdrop-filter: blur(20px);
            background: rgba(255,255,255,0.15);
            border-radius: 20px;
            padding: 40px;
            width: 350px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }

        .input {
            width: 100%;
            padding: 12px;
            border-radius: 25px;
            border: none;
            margin: 10px 0;
            background: rgba(255,255,255,0.7);
        }

        .btn {
            width: 100%;
            padding: 12px;
            border-radius: 25px;
            background: linear-gradient(to right, #007bff, #00c6ff);
            color: white;
            border: none;
            margin-top: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        a {
            font-size: 12px;
            color: white;
        }
    </style>
</head>

<body>

    @yield('content')

</body>
</html>
