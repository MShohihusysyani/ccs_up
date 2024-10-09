<?php
function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('username')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role');
        $menu = $ci->uri->segment(1);

        $queryMenu = $ci->db->get_where('menu', ['nama_menu' => $menu])->row_array();
        $menu_id = $queryMenu['nama_menu'];

        $userAccess = $ci->db->get_where('menu', [
            'role_id' => $role_id,
            'nama_menu' => $menu_id
        ]);

        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
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


function noUrutClient()
{
    $ci = get_instance();
    $query = "SELECT max(no_klien) as maxNo FROM klien";
    $data = $ci->db->query($query)->row_array();
    $kode = $data['maxNo'];
    $noUrut = (int) substr($kode, 0, 4);

    $noUrut++;

    $kodeBaru = sprintf('%04s', $noUrut);
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
    $query = "SELECT count(id_pelaporan) as totalh FROM pelaporan where status_ccs='FINISHED' AND priority='High'";
    $data = $ci->db->query($query)->row_array();
    $total = $data['totalh'];
    $kodeBaru = $total;
    return $kodeBaru;
}

function total_medium()
{
    $ci = get_instance();
    $query = "SELECT count(id_pelaporan) as totalm FROM pelaporan where status_ccs='FINISHED' AND priority='Medium'";
    $data = $ci->db->query($query)->row_array();
    $total = $data['totalm'];
    $kodeBaru = $total;
    return $kodeBaru;
}

function total_low()
{
    $ci = get_instance();
    $query = "SELECT count(id_pelaporan) as totall FROM pelaporan where status_ccs='FINISHED' AND priority='Low'";
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

// COUNT TIKET PER HELPDESK USER
function total_ticket_progres()
{
    $ci = get_instance();
    $query = "SELECT u.*, COUNT(p.user_id) AS ticket_count
                FROM pelaporan p
                JOIN user u ON p.user_id = u.id_user
                WHERE p.status_ccs IN ('HANDLE', 'HANDLE 2')
                AND u.divisi IN ('Helpdesk 1', 'Helpdesk 2', 'Helpdesk 3', 'Helpdesk 4')
                GROUP BY u.id_user";

    $result = $ci->db->query($query)->result_array();

    $data['user_ticket_counts'] = $result; // Store the query result in a different variable

    return $data;
}
