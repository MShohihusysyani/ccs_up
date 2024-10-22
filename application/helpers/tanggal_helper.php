<?php

/**
 * Helpher untuk mencetak tanggal dalam format bahasa indonesia
 *
 * @package CodeIgniter
 * @category Helpers
 * @author Ardianta Pargo (ardianta_pargo@yhaoo.co.id)
 * @link https://gist.github.com/ardianta/ba0934a0ee88315359d30095c7e442de
 * @version 1.0
 */

/**
 * Fungsi untuk merubah bulan bahasa inggris menjadi bahasa indonesia
 * @param int nomer bulan, Date('m')
 * @return string nama bulan dalam bahasa indonesia
 */
if (!function_exists('bulan')) {
    function bulan()
    {
        $bulan = Date('m');
        switch ($bulan) {
            case 1:
                $bulan = "Januari";
                break;
            case 2:
                $bulan = "Februari";
                break;
            case 3:
                $bulan = "Maret";
                break;
            case 4:
                $bulan = "April";
                break;
            case 5:
                $bulan = "Mei";
                break;
            case 6:
                $bulan = "Juni";
                break;
            case 7:
                $bulan = "Juli";
                break;
            case 8:
                $bulan = "Agustus";
                break;
            case 9:
                $bulan = "September";
                break;
            case 10:
                $bulan = "Oktober";
                break;
            case 11:
                $bulan = "November";
                break;
            case 12:
                $bulan = "Desember";
                break;

            default:
                $bulan = Date('F');
                break;
        }
        return $bulan;
    }
}

/**
 * Fungsi untuk membuat tanggal dalam format bahasa indonesia
 * @param void
 * @return string format tanggal sekarang (contoh: 22 Desember 2016)
 */
if (!function_exists('tanggal')) {
    function tanggal()
    {
        $tanggal = Date('d') . " " . bulan() . " " . Date('Y');
        return $tanggal;
    }
}
// function tanggal_indo($tanggal)
// {
//     if (empty($tanggal)) {
//         return 'Invalid date format';
//     }

//     $bulan = array(
//         1 => 'Januari',
//         'Februari',
//         'Maret',
//         'April',
//         'Mei',
//         'Juni',
//         'Juli',
//         'Agustus',
//         'September',
//         'Oktober',
//         'November',
//         'Desember'
//     );

//     $split = explode('-', $tanggal);

//     // Check if $split has at least 3 elements
//     if (count($split) < 3) {
//         return 'Invalid date format';
//     }

//     // Ensure $split[1] is within valid month range
//     $bulan_index = (int)$split[1];
//     if ($bulan_index < 1 || $bulan_index > 12) {
//         return 'Invalid date format';
//     }

//     $tanggal_indo = $split[2] . ' ' . $bulan[$bulan_index] . ' ' . $split[0];

//     return $tanggal_indo;
// }

function tanggal_indo($tanggal)
{
    if (empty($tanggal)) {
        return '-';
    }

    $bulan = array(
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );

    // Memisahkan tanggal dan waktu jika ada
    $datetime_split = explode(' ', $tanggal);
    $date_part = $datetime_split[0]; // Bagian tanggal
    $time_part = isset($datetime_split[1]) ? $datetime_split[1] : ''; // Bagian waktu jika ada

    $split = explode('-', $date_part);

    // Memeriksa apakah $split memiliki setidaknya 3 elemen
    if (count($split) < 3) {
        return '-';
    }

    // Memastikan $split[1] adalah bulan yang valid
    $bulan_index = (int)$split[1];
    if ($bulan_index < 1 || $bulan_index > 12) {
        return '-';
    }

    // Format tanggal Indonesia
    $tanggal_indo = $split[2] . ' ' . $bulan[$bulan_index] . ' ' . $split[0];

    // Jika ada waktu, tambahkan di belakang
    if (!empty($time_part)) {
        $tanggal_indo .= ' ' . $time_part;
    }

    return $tanggal_indo;
}




if (!function_exists('format_indo')) {

    function format_indo1($date)
    {
        date_default_timezone_set('Asia/Jakarta');
        // array hari dan bulan
        $Hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
        $Bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

        // pemisahan tahun, bulan, hari, dan waktu
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl = substr($date, 8, 2);
        $waktu = substr($date, 11, 8);
        $hari = date("w", strtotime($date));
        $result = $Hari[$hari] . ", " . $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun . " " . $waktu;

        return $result;
    }
}

if (!function_exists('format_indo')) {

    function format_indo($date)
    {
        date_default_timezone_set('Asia/Jakarta');

        // Array hari dan bulan
        $Hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
        $Bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

        // Validate input date format (YYYY-MM-DD HH:MM:SS)
        if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $date)) {
            // Pemisahan tahun, bulan, hari, dan waktu
            $tahun = substr($date, 0, 4);
            $bulan = substr($date, 5, 2);
            $tgl = substr($date, 8, 2);
            $waktu = substr($date, 11, 8);

            // Validate extracted values
            if (checkdate((int)$bulan, (int)$tgl, (int)$tahun)) {
                $hari = date("w", strtotime($date));
                $result = $Hari[$hari] . ", " . $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun . " " . $waktu;
                return $result;
            } else {
                return "Invalid date components.";
            }
        } else {
            return "Invalid date format.";
        }
    }
}
