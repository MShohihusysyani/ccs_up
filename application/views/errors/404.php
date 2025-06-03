<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>404 - Halaman Tidak Ditemukan</title>
    <link rel="icon" href="assets/images/mso.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: url('https://www.transparenttextures.com/patterns/cubes.png') repeat;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            padding: 40px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            max-width: 500px;
        }

        .icon {
            font-size: 100px;
            color: #ef4444;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        h1 {
            font-size: 48px;
            margin: 10px 0;
            color: #4f46e5;
            font-weight: 900;
        }

        p {
            font-size: 16px;
            margin-bottom: 30px;
            color: #555;
        }

        .btn {
            background-color: #4f46e5;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background-color: #4338ca;
        }

        @media (max-width: 500px) {
            .icon {
                font-size: 70px;
            }

            h1 {
                font-size: 36px;
            }

            p {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="icon">🚫</div>
        <h1>404 - Tidak Ditemukan</h1>
        <p>Oops! Halaman yang kamu cari tidak tersedia.<br>Silakan periksa URL atau kembali ke halaman utama.</p>
        <button onclick="goHome()" class="btn mt-4 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition duration-300">
            Kembali
        </button>
    </div>

    <script>
        function goHome() {
            window.location.href = "<?= base_url(); ?>";
        }
    </script>

</body>

</html>