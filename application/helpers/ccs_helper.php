<?php

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('username')) {
        redirect('auth');
    }
      
}
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
    $tanggal_indo =  $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

    return $tanggal_indo;
}

if (!function_exists('format_indo')) {

    function format_indo($date){
        date_default_timezone_set('Asia/Jakarta');
        // array hari dan bulan
        $Hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
        $Bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        
        // pemisahan tahun, bulan, hari, dan waktu
        $tahun = substr($date,0,4);
        $bulan = substr($date,5,2);
        $tgl = substr($date,8,2);
        $waktu = substr($date, 11,8);
        $hari = date("w",strtotime($date));
        $result = $Hari[$hari].", ".$tgl." ".$Bulan[(int)$bulan-1]." ".$tahun." ".$waktu;
    
        return $result;
    }
    }

function noUrutClient()
{
    $ci = get_instance();
    $query = "SELECT max(no_urut) as maxNo FROM klien";
    $data = $ci->db->query($query)->row_array();
    $kode = $data['maxNo'];
    $noUrut = (int) substr($kode, 0);

    $noUrut++;

    $kodeBaru = sprintf('%01s', $noUrut);
    return $kodeBaru;
}

function noTiket()
{
    $ci = get_instance();
    $taun = date('Y');
    $bulan = date('m');
    $query = "SELECT max(no_tiket) as maxNotiket FROM pelaporan";
    $data = $ci->db->query($query)->row_array();
    $noTiket = $data['maxNotiket'];
    $noUrut = (int) substr($noTiket, 0, 3);

    $noUrut++;
    $kodeHuruf = "TIC";

    $noTiketBaru = $kodeHuruf . $taun . $bulan . sprintf('%03s', $noUrut);
    return $noTiketBaru;
}

// COUNT PRIORITY 
function total_high()
{
    $ci = get_instance();
    $query = "SELECT count(id_pelaporan) as totalh FROM pelaporan where status_ccs='FINISH' AND priority='High'";
    $data = $ci->db->query($query)->row_array();
    $total = $data['totalh'];
    $kodeBaru = $total;
    return $kodeBaru;
}

function total_medium()
{
    $ci = get_instance();
    $query = "SELECT count(id_pelaporan) as totalm FROM pelaporan where status_ccs='FINISH' AND priority='Medium'";
    $data = $ci->db->query($query)->row_array();
    $total = $data['totalm'];
    $kodeBaru = $total;
    return $kodeBaru;
}

function total_low()
{
    $ci = get_instance();
    $query = "SELECT count(id_pelaporan) as totall FROM pelaporan where status_ccs='FINISH' AND priority='Low'";
    $data = $ci->db->query($query)->row_array();
    $total = $data['totall'];
    $kodeBaru = $total;
    return $kodeBaru;
}

// COUNT TIKET
function total_today()
{
    $ci = get_instance();
    $query = "SELECT count(id_pelaporan) as totald FROM pelaporan where waktu_pelaporan = CURDATE()";
    $data = $ci->db->query($query)->row_array();
    $total = $data['totald'];
    $kodeBaru = $total;
    return $kodeBaru;
}

function total_yesterday()
{
    $ci = get_instance();
    $query = "SELECT count(id_pelaporan) as totaly FROM pelaporan where waktu_pelaporan = CURDATE() - INTERVAL 1 DAY";
    $data = $ci->db->query($query)->row_array();
    $total = $data['totaly'];
    $kodeBaru = $total;
    return $kodeBaru;
}

function total_lastweek()
{
    $ci = get_instance();
    $query = "SELECT count(id_pelaporan) as totallw FROM pelaporan where waktu_pelaporan  BETWEEN CURDATE() - INTERVAL 1 WEEK AND CURDATE() - INTERVAL 1 DAY";
    $data = $ci->db->query($query)->row_array();
    $total = $data['totallw'];
    $kodeBaru = $total;
    return $kodeBaru;
}

function total_thismonth()
{
    $ci = get_instance();
    $query = "SELECT count(id_pelaporan) as totaltm FROM pelaporan where MONTH(waktu_pelaporan) = MONTH(CURDATE()) AND YEAR(waktu_pelaporan) = YEAR(CURDATE())";
    $data = $ci->db->query($query)->row_array();
    $total = $data['totaltm'];
    $kodeBaru = $total;
    return $kodeBaru;
}


function total_lastmonth()
{
    $ci = get_instance();
    $query = "SELECT count(id_pelaporan) as totallm FROM pelaporan where MONTH(waktu_pelaporan) = MONTH(CURDATE() - INTERVAL 1 MONTH) 
              AND YEAR(waktu_pelaporan) = YEAR(CURDATE() - INTERVAL 1 MONTH)";
    $data = $ci->db->query($query)->row_array();
    $total = $data['totallm'];
    $kodeBaru = $total;
    return $kodeBaru;
}

function total_all()
{
    $ci = get_instance();
    $query = "SELECT count(no_tiket) as totalt FROM pelaporan";
    $data = $ci->db->query($query)->row_array();
    $total = $data['totalt'];
    $kodeBaru = $total;
    return $kodeBaru;
}

function total_bpr()
{
    $ci = get_instance();
    $query = "SELECT nama, COUNT(nama) AS jumlah
    FROM pelaporan
    GROUP BY nama";
    $data = $ci->db->query($query)->row_array();
    $total = $data['jumlah'];
    $kodeBaru = $total;
    return $kodeBaru;
}








