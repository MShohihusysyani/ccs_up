<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client_model extends CI_Model
{


    public function getClient()
    {
        $query = "SELECT *
                    FROM klien ORDER BY no_klien ASC";
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
        $currentMonth = date('Ym');

        $no_klien = $this->getNoKlien($user_id);
        $this->db->trans_start();

        // Ambil nomor tiket terakhir yang sesuai dengan user_id dan nomor klien
        $query = $this->db->query(
            "SELECT no_tiket 
            FROM pelaporan 
            WHERE user_id = ? AND no_tiket LIKE ?
            ORDER BY no_tiket DESC 
            LIMIT 1 FOR UPDATE",
            [$user_id, 'TIC' . $no_klien . $currentMonth . '%']
        )->row_array();

        // Jika tidak ada tiket sebelumnya, mulai dari 0001
        if ($query == NULL || empty($query['no_tiket'])) {
            $no_urut = 1; // Mulai dari 0001 jika tidak ada tiket sebelumnya
        } else {
            // Ambil 4 digit terakhir (nomor urut)
            $lastNoUrut = (int) substr($query['no_tiket'], -4);
            $no_urut = $lastNoUrut + 1;
        }

        $no_urut = sprintf('%04d', $no_urut);
        $no_tiket = 'TIC' . $no_klien . $currentMonth . $no_urut;

        $this->db->trans_complete();

        return $no_tiket;
    }


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
