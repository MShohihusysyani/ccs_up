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

    public function getTiketTemp1()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT user.nama_user,tiket_temp.id_temp,  tiket_temp.no_tiket, tiket_temp.perihal, tiket_temp.file, user.id_user, tiket_temp.kategori, tiket_temp.tags, tiket_temp.judul
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

            if (isset($file_data->file)) { // Ganti 'file_name' dengan 'file'
                // Hapus data dari database
                $this->db->where('id_temp', $id);
                $this->db->delete('tiket_temp');

                // Hapus file fisik
                $file_path = FCPATH . 'assets/files/' . $file_data->file; // Ganti 'file_name' dengan 'file'
                // Debug: cek apakah file path benar dan bukan direktori
                var_dump($file_path);

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
                    return false;  // File tidak ditemukan atau ini adalah direktori
                }
            } else {
                log_message('error', 'Properti file tidak ditemukan di objek $file_data');
                return false;  // Properti file tidak ditemukan di objek $file_data
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
