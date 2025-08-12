<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            text-align: center;
            background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .gears {
            margin-bottom: 30px;
        }

        .gear {
            width: 80px;
            height: 80px;
            background: url('https://cdn-icons-png.flaticon.com/512/3524/3524636.png') no-repeat center;
            background-size: contain;
            display: inline-block;
            margin: 0 10px;
        }

        .gear.big {
            width: 100px;
            height: 100px;
            animation: spin 3s linear infinite;
        }

        .gear.medium {
            width: 80px;
            height: 80px;
            animation: spinReverse 4s linear infinite;
        }

        .gear.small {
            width: 60px;
            height: 60px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes spinReverse {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(-360deg);
            }
        }

        h1 {
            font-size: 48px;
            color: #7c70ff;
            margin-bottom: 10px;
        }

        p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .btn {
            background-color: #7c70ff;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #655cd3;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="gears">
            <span class="gear big"></span>
            <span class="gear medium"></span>
            <span class="gear small"></span>
        </div>
        <h1>MAINTENANCE</h1>
        <p>Our site is currently under maintenance<br>we will be back shortly<br>Thank you for your patience</p>
        <!-- <a href="/" class="btn">BACK TO HOME PAGE</a> -->
    </div>

</body>

</html>