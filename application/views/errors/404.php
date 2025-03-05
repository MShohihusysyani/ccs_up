<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link rel="icon" href="assets/images/mso.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="text-center p-6 bg-white rounded-lg shadow-lg">
        <h1 class="text-9xl font-bold text-red-500 animate-bounce">404</h1>
        <p class="text-xl text-gray-700 mt-2">Oops! Halaman yang kamu cari tidak ditemukan.</p>
        <div class="mt-4 flex justify-center">
            <svg class="w-24 h-24 text-gray-400 animate-floating" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M6 12a6 6 0 1112 0 6 6 0 01-12 0z" />
            </svg>
        </div>
        <button onclick="goHome()" class="mt-4 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition duration-300">
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