<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Temp_model extends CI_Model
{
    public function getTiketTemp()
    {
        $query = "SELECT 	id_temp,  user_id, perihal, no_tiket, file, nama_klien, kategori, tags, judul

                    FROM tiket_temp
                    ";
        return $this->db->query($query)->result_array();
    }
    public function getNoKlien($id)
    {
        $no_klien = $this->db->query("SELECT no_klien FROM klien WHERE id_user_klien = $id")->row_array();

        return $no_klien['no_klien'];
    }

    public function getNoUrut($user_id)
    {
        // Transaksi untuk mencegah race condition
        $this->db->trans_start();

        // Ambil nomor tiket terbesar yang sudah ada untuk klien tersebut
        $query = $this->db->query("SELECT MAX(CAST(SUBSTRING(no_tiket, -4) AS UNSIGNED)) AS no_urut FROM pelaporan WHERE user_id = ? FOR UPDATE", [$user_id])->row_array();

        // Debugging: Log hasil query
        log_message('debug', 'Nomor urut terakhir dari query: ' . json_encode($query));

        // Jika query tidak menghasilkan nomor tiket, mulai nomor urut dari 1
        if ($query == NULL || empty($query['no_urut'])) {
            $no_urut = 1;
        } else {
            // Ambil 4 digit terakhir dari nomor tiket dan tambahkan 1
            $no_urut = (int) $query['no_urut'] + 1;
        }

        // Format nomor urut menjadi 4 digit
        $no_urut = sprintf('%04d', $no_urut);

        // Selesaikan transaksi
        $this->db->trans_complete();

        return $no_urut;
    }






    // FUNGSI UNTUK INPUT TIKET DARI HELPDESK
    // public function getNoKlien($klien_id)
    // {
    //     // Ambil nomor klien dari tabel klien berdasarkan id klien
    //     $this->db->select('no_klien');
    //     $this->db->from('klien');
    //     $this->db->where('id_user_klien', $klien_id);
    //     $result = $this->db->get()->row_array();

    //     return $result ? $result['no_klien'] : null;  // Kembalikan no_klien atau null jika tidak ada
    // }

    // // Fungsi untuk mendapatkan nomor urut tiket terakhir berdasarkan klien
    // public function getNoUrut($user_id)
    // {
    //     // Ambil no tiket terakhir dari tabel pelaporan berdasarkan user (user_id)
    //     $this->db->select('max(no_tiket) as no_tiket');
    //     $this->db->from('pelaporan');
    //     $this->db->where('user_id', $user_id);
    //     $result = $this->db->get()->row_array();

    //     if ($result && $result['no_tiket']) {
    //         // Jika ada no_tiket yang ditemukan, ambil 4 digit terakhir untuk no urut
    //         $no_tiket = $result['no_tiket'];
    //         $no_urut = (int) substr($no_tiket, -4);  // Mengambil 4 digit terakhir dari no tiket
    //     } else {
    //         // Jika tidak ada tiket sebelumnya, mulai dari 0
    //         $no_urut = 0;
    //     }

    //     // Tambahkan 1 untuk nomor urut berikutnya dan format menjadi 4 digit (misalnya: 0001)
    //     return sprintf('%04d', $no_urut + 1);
    // }

    // tiket temp helpdesk
    public function getTiketTempHd()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT user.nama_user,tiket_temp.id_temp,  tiket_temp.no_tiket, tiket_temp.perihal, tiket_temp.file, user.id_user, tiket_temp.kategori, tiket_temp.tags, tiket_temp.judul, tiket_temp.nama
                    FROM tiket_temp JOIN user
                    ON tiket_temp.user_id_hd = user.id_user
                    WHERE user_id_hd = $user_id";
        return $this->db->query($query)->result_array();
    }

    // Tiket Temp Klien
    public function getTiketTempKlien()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT user.nama_user,tiket_temp.id_temp,  tiket_temp.no_tiket, tiket_temp.perihal, tiket_temp.file, user.id_user, tiket_temp.kategori, tiket_temp.tags, tiket_temp.judul, tiket_temp.nama
                    FROM tiket_temp JOIN user
                    ON tiket_temp.user_id = user.id_user
                    WHERE user_id = $user_id";
        return $this->db->query($query)->result_array();
    }

    public function hapus_temp($id)
    {
        // Ambil informasi file berdasarkan ID
        $this->db->where('id_temp', $id);
        $query = $this->db->get('tiket_temp');

        // Debug: cek apakah query berhasil dan mengembalikan data
        if ($query->num_rows() > 0) {
            $file_data = $query->row();
            // Debug: cek hasil query
            var_dump($file_data);

            // Hapus data dari database
            $this->db->where('id_temp', $id);
            $this->db->delete('tiket_temp');

            // Hapus file fisik jika ada
            if (isset($file_data->file)) { // Ganti 'file_name' dengan 'file'
                $file_path = FCPATH . 'assets/files/' . $file_data->file; // Ganti 'file_name' dengan 'file'
                // Debug: cek apakah file path benar dan bukan direktori
                // var_dump($file_path);

                if (is_file($file_path)) {
                    if (unlink($file_path)) {
                        log_message('info', 'File berhasil dihapus: ' . $file_path);
                        return true;  // Penghapusan file berhasil
                    } else {
                        log_message('error', 'Gagal menghapus file: ' . $file_path);
                        return false;  // Penghapusan file gagal
                    }
                } else {
                    log_message('error', 'File tidak ditemukan atau ini adalah direktori: ' . $file_path);
                    return true;  // File tidak ditemukan, tetap kembalikan true karena data sudah dihapus
                }
            } else {
                // Tidak ada file yang dihapus, tetap kembalikan true
                return true;
            }
        } else {
            log_message('error', 'Data file tidak ditemukan di database dengan ID: ' . $id);
            return false;  // Data file tidak ditemukan di database
        }
    }

    function updateTiket($id_temp, $data)
    {
        $this->db->where('id_temp', $id_temp);
        $this->db->update('tiket_temp', $data);
    }

    public function ambil_id_temp($id)
    {
        $query = "SELECT  id_temp, no_tiket, perihal, judul, kategori, tags, nama, file  FROM tiket_temp WHERE id_temp='$id'";
        return $this->db->query($query)->result_array();
    }
}
