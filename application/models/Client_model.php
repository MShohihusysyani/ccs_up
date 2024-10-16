<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client_model extends CI_Model
{


    public function getClient()
    {
        $query = "SELECT *
                    FROM klien
                    ";
        return $this->db->query($query)->result_array();
    }

    public function getDataClient()
    {
        $query = "SELECT id, nama_klien FROM klien";

        return $this->db->query($query)->result_array();
    }


    public function hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('klien');
    }

    function updateKlien($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('klien', $data);
    }

    public function getNoKlien($id)
    {
        $no_klien = $this->db->query("SELECT no_klien FROM klien WHERE id_user_klien = $id")->row_array();

        return $no_klien['no_klien'];
    }

    public function getNoUrut($user_id)
    {
        // Dapatkan bulan dan tahun saat ini
        $currentMonth = date('Ym'); // Format: YYYYMM

        // Mulai transaksi untuk mencegah race condition
        $this->db->trans_start();

        // Ambil nomor tiket terakhir yang terbesar untuk user yang sama
        $query = $this->db->query(
            "SELECT no_tiket 
         FROM pelaporan 
         WHERE user_id = ? 
         ORDER BY no_tiket DESC 
         LIMIT 1 FOR UPDATE",
            [$user_id]
        )->row_array();

        // Debugging: Log hasil query untuk melihat nomor tiket terakhir
        log_message('debug', 'Tiket terakhir dari query: ' . json_encode($query));

        // Jika tidak ada tiket sebelumnya, mulai dari 0001
        if ($query == NULL || empty($query['no_tiket'])) {
            $no_urut = 1; // Mulai dari 0001 jika tidak ada tiket sebelumnya
        } else {
            // Ambil bulan dari tiket terakhir (4 sampai 9 adalah YYYYMM)
            $lastTicketMonth = substr($query['no_tiket'], 3, 6);

            // Cek apakah bulan sekarang berbeda dengan bulan terakhir pada tiket
            if ($lastTicketMonth != $currentMonth) {
                // Reset ke 0001 jika bulan sudah berubah
                $no_urut = 1;
            } else {
                // Jika masih bulan yang sama, tambahkan nomor urut
                $lastNoUrut = (int) substr($query['no_tiket'], -4); // Ambil 4 digit terakhir
                $no_urut = $lastNoUrut + 1;
            }
        }

        // Format nomor urut menjadi 4 digit (misalnya: 0001, 0002, dst.)
        $no_urut = sprintf('%04d', $no_urut);

        $no_klien = $this->getNoKlien($user_id);
        // Gabungkan nomor urut dengan prefix 'TIC', no klien, dan bulan/tahun
        $no_tiket = 'TIC' . $no_klien . $currentMonth . $no_urut;



        // Selesaikan transaksi
        $this->db->trans_complete();

        return $no_tiket; // Kembalikan nomor tiket lengkap
    }

    // public function getNoUrut($user_id)
    // {
    //     // Dapatkan bulan dan tahun saat ini
    //     $currentMonth = date('Ym'); // Format: YYYYMM

    //     // Transaksi untuk mencegah race condition
    //     $this->db->trans_start();

    //     // Ambil nomor tiket terakhir yang terbesar untuk user yang sama
    //     $query = $this->db->query(
    //         "SELECT no_tiket 
    //          FROM pelaporan 
    //          WHERE user_id = ? 
    //          ORDER BY no_tiket DESC 
    //          LIMIT 1 FOR UPDATE",
    //         [$user_id]
    //     )->row_array();

    //     // Debugging: Log hasil query
    //     log_message('debug', 'Tiket terakhir dari query: ' . json_encode($query));

    //     // Jika tidak ada tiket sebelumnya, mulai dari 0001
    //     if ($query == NULL || empty($query['no_tiket'])) {
    //         $no_urut = 1;
    //     } else {
    //         // Ambil bulan dari tiket terakhir (4 sampai 9 adalah YYYYMM)
    //         $lastTicketMonth = substr($query['no_tiket'], 3, 6);

    //         // Cek apakah bulan sekarang berbeda dengan bulan terakhir pada tiket
    //         if ($lastTicketMonth != $currentMonth) {
    //             // Reset ke 0001 jika bulan sudah berubah
    //             $no_urut = 1;
    //         } else {
    //             // Jika masih bulan yang sama, tambahkan nomor urut
    //             $lastNoUrut = (int) substr($query['no_tiket'], -4); // Ambil 4 digit terakhir
    //             $no_urut = $lastNoUrut + 1;
    //         }
    //     }

    //     // Format nomor urut menjadi 4 digit
    //     $no_urut = sprintf('%04d', $no_urut);

    //     // Gabungkan prefix 'TIC', bulan dan tahun saat ini (YYYYMM), dan nomor urut

    //     // Selesaikan transaksi
    //     $this->db->trans_complete();

    //     return $no_urut;
    // }



    // public function getNoUrut($user_id)
    // {
    //     // Transaksi untuk mencegah race condition
    //     $this->db->trans_start();

    //     // Ambil nomor tiket terbesar yang sudah ada untuk klien tersebut
    //     $query = $this->db->query("SELECT MAX(CAST(SUBSTRING(no_tiket, -4) AS UNSIGNED)) AS no_urut FROM pelaporan WHERE user_id = ? FOR UPDATE", [$user_id])->row_array();

    //     // Debugging: Log hasil query
    //     log_message('debug', 'Nomor urut terakhir dari query: ' . json_encode($query));

    //     // Jika query tidak menghasilkan nomor tiket, mulai nomor urut dari 1
    //     if ($query == NULL || empty($query['no_urut'])) {
    //         $no_urut = 1;
    //     } else {
    //         // Ambil 4 digit terakhir dari nomor tiket dan tambahkan 1
    //         $no_urut = (int) $query['no_urut'] + 1;
    //     }

    //     // Format nomor urut menjadi 4 digit
    //     $no_urut = sprintf('%04d', $no_urut);

    //     // Selesaikan transaksi
    //     $this->db->trans_complete();

    //     return $no_urut;
    // }


    // GENERATE KODE OTOMATIS
    public function getkodeticket()
    {
        $query = $this->db->query("select max(no_tiket) as max_code FROM pelaporan");

        $row = $query->row_array();

        $max_id = $row['max_code'];
        $max_fix = (int) substr($max_id, 9, 4);
        $max_nik = $max_fix + 1;

        // $tanggal = $time = date("d");
        $bulan = $time = date("m");
        $tahun = $time = date("Y");

        $nik = "TIC" . $tahun . $bulan . sprintf("%04s", $max_nik);
        return $nik;
    }

    public function getUserClient()
    {
        return $this->db->query("SELECT id_user, nama_user FROM user where role = 1")->result_array();
    }

    // DASHBOARD KLIEN
    public function getDataKlienHandle()
    {

        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT no_tiket, status_ccs FROM pelaporan WHERE  user_id= $user_id AND status_ccs IN('HANDLE', 'HANDLE 2')";
        return $this->db->query($query)->result_array();
    }
}
