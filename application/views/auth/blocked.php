<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Akses Ditolak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
            background-color: #f3f4f6;
        }

        .icon-bounce {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-12px);
            }
        }
    </style>
</head>

<body class="flex items-center justify-center h-screen">
    <div class="bg-white/90 backdrop-blur-md shadow-2xl rounded-2xl px-10 py-12 max-w-lg text-center" data-aos="zoom-in">
        <img src="https://cdn-icons-png.flaticon.com/512/2913/2913465.png" alt="Access Denied"
            class="w-24 mx-auto mb-8 icon-bounce" />
        <h1 class="text-3xl font-black text-red-600 mb-4">Akses Ditolak</h1>
        <p class="text-gray-700 text-base leading-relaxed mb-8">
            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
        </p>
        <a href="<?= base_url('auth/logout'); ?>"
            class="inline-block px-5 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 hover:scale-105 active:scale-95 transition">
            ⬅ Kembali ke Halaman Login
        </a>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800
        });
    </script>
</body>

</html>