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
function tanggal_indo($tanggal)
{
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

    $split = explode('-', $tanggal);
    $tanggal_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

    return $tanggal_indo;
}

function romawi()
{
    $romawi = Date('m');
    switch ($romawi) {
        case 1:
            $romawi = "I";
            break;
        case 2:
            $romawi = "II";
            break;
        case 3:
            $romawi = "III";
            break;
        case 4:
            $romawi = "IV";
            break;
        case 5:
            $romawi = "V";
            break;
        case 6:
            $romawi = "VI";
            break;
        case 7:
            $romawi = "VII";
            break;
        case 8:
            $romawi = "VIII";
            break;
        case 9:
            $romawi = "IX";
            break;
        case 10:
            $romawi = "X";
            break;
        case 11:
            $romawi = "XI";
            break;
        case 12:
            $romawi = "XII";
            break;

        default:
            $romawi = Date('F');
            break;
    }
    return $romawi;
}

function kodeSurat()
{
    $ci = get_instance();
    $bulan = date('m');
    $romawi = romawi($bulan);
    $taun = date('Y');
    $query = "SELECT max(kode_surat) as maxKode FROM surat where month(tanggal_surat) = '$bulan' AND year(tanggal_surat) = '$taun' ";
    $data = $ci->db->query($query)->row_array();
    $kode = $data['maxKode'];
    $noUrut = (int) substr($kode, 0, 3);

    $noUrut++;

    $char = "/PR/AMIKOMPWT/UPB/" . $romawi . "/" . $taun;
    $kodeBaru = sprintf('%03s', $noUrut) . $char;
    return $kodeBaru;
}

function romawipo()
{
    $romawi = Date('m');
    switch ($romawi) {
        case 1:
            $romawi = "I";
            break;
        case 2:
            $romawi = "II";
            break;
        case 3:
            $romawi = "III";
            break;
        case 4:
            $romawi = "IV";
            break;
        case 5:
            $romawi = "V";
            break;
        case 6:
            $romawi = "VI";
            break;
        case 7:
            $romawi = "VII";
            break;
        case 8:
            $romawi = "VIII";
            break;
        case 9:
            $romawi = "IX";
            break;
        case 10:
            $romawi = "X";
            break;
        case 11:
            $romawi = "XI";
            break;
        case 12:
            $romawi = "XII";
            break;

        default:
            $romawi = Date('F');
            break;
    }
    return $romawi;
}

function kodeSuratPO()
{
    $ci = get_instance();
    $bulan = date('m');
    $romawi = romawipo($bulan);
    $taun = date('Y');
    $query = "SELECT max(kode_surat) as maxKode FROM surat_po where month(tanggal_surat) = '$bulan' AND year(tanggal_surat) = '$taun' ";
    $data = $ci->db->query($query)->row_array();
    $kode = $data['maxKode'];
    $noUrut = (int) substr($kode, 0, 3);

    $noUrut++;

    $char = "/PO/AMIKOMPWT/UPB/" . $romawi . "/" . $taun;
    $kodeBaru = sprintf('%03s', $noUrut) . $char;
    return $kodeBaru;
}

function kodeSuratBA()
{
    $ci = get_instance();
    $bulan = date('m');
    $romawi = romawi($bulan);
    $taun = date('Y');
    $query = "SELECT max(kode_surat) as maxKode FROM surat_ba where month(tanggal_surat) = '$bulan' AND year(tanggal_surat) = '$taun' ";
    $data = $ci->db->query($query)->row_array();
    $kode = $data['maxKode'];
    $noUrut = (int) substr($kode, 0, 3);

    $noUrut++;

    $char = "/BA/AMIKOMPWT/UPB/" . $romawi . "/" . $taun;
    $kodeBaru = sprintf('%03s', $noUrut) . $char;
    return $kodeBaru;
}