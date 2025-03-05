<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
</head>

<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md text-center" data-aos="zoom-in">
        <img src="https://cdn-icons-png.flaticon.com/512/564/564619.png" alt="No Access" class="w-24 mx-auto mb-12 animate-pulse">
        <h1 class="text-2xl font-bold text-red-600">Akses Ditolak</h1>
        <p class="text-gray-600 mt-12">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="<?= base_url('auth/logout'); ?>"
            class="mt-12 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition transform hover:scale-105 active:scale-95">
            Kembali ke Halaman Login
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

<!-- <body class="four-zero-four">
    <div class="four-zero-four-container">
        <div class="error-code">404</div>
        <div class="error-message">This page doesn't exist</div>
        <div class="button-place">
            <a href="<?= base_url('auth/logout'); ?>" class="btn btn-default btn-lg waves-effect">GO TO LOGIN</a>
        </div>
    </div> -->