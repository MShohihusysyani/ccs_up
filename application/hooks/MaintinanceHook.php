<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MaintinanceHook
{
    public function check_maintenance()
    {
        // Aktifkan/Nonaktifkan mode maintenance
        $is_maintenance = FALSE;

        // URL yang masih diizinkan saat maintenance
        $allowed_routes = [
            'hooks/under_maintenance',
        ];

        // Ambil URI dari request, misalnya: /ccs_up/auth
        $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

        // Hilangkan path dasar jika proyek berada di subfolder
        $base_path = 'localhost/ccs_up/';
        if (strpos($uri, $base_path) === 0) {
            $uri = substr($uri, strlen($base_path));
        }

        // Hilangkan query string (?xxx=yyy)
        $uri = strtok($uri, '?');

        // Hilangkan slash depan dan belakang
        $uri = trim($uri, '/');

        if ($is_maintenance && !in_array($uri, $allowed_routes)) {
            // Langsung tampilkan view tanpa CI loader
            include(APPPATH . 'hooks/under_maintinance.php');
            exit;
        }
    }
}
