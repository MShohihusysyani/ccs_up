<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chat_model extends CI_Model
{

    /**
     * Mengambil daftar kontak yang diizinkan untuk diajak bicara
     * oleh user yang sedang login, berdasarkan perannya.
     */
    public function get_contact_list($my_id, $my_role)
    {
        $allowed_roles = [];
        switch ($my_role) {
            // ... (switch case Anda tetap sama)
            case '1':
                $allowed_roles = ['2'];
                break;
            case '4':
                $allowed_roles = ['1', '2', '4', '3', '9'];
                break;
            case '2':
            case '3':
            case '9':
            case '6':
                break;
        }

        $this->db->select([
            'u.id_user',
            'u.nama_user',
            'u.role',
            '(SELECT message FROM chat WHERE (sender_id = u.id_user AND receiver_id = ' . $my_id . ') OR (sender_id = ' . $my_id . ' AND receiver_id = u.id_user) ORDER BY created_at DESC LIMIT 1) as last_message',
            '(SELECT created_at FROM chat WHERE (sender_id = u.id_user AND receiver_id = ' . $my_id . ') OR (sender_id = ' . $my_id . ' AND receiver_id = u.id_user) ORDER BY created_at DESC LIMIT 1) as last_message_time',
            // --- PERUBAHAN DI SINI ---
            // Menghitung pesan yang statusnya BUKAN 'read'
            '(SELECT COUNT(*) FROM chat WHERE sender_id = u.id_user AND receiver_id = ' . $my_id . " AND status != 'read') as unread_count"
        ]);
        $this->db->from('user u');
        $this->db->where('u.id_user !=', $my_id);
        $this->db->where('u.active', 'Y');

        if (!empty($allowed_roles)) {
            $this->db->where_in('u.role', $allowed_roles);
        }

        $this->db->order_by('last_message_time', 'DESC');

        return $this->db->get()->result();
    }

    /**
     * Mengambil riwayat pesan antara dua pengguna.
     */
    public function get_messages($user1_id, $user2_id)
    {
        $this->db->where("(sender_id = $user1_id AND receiver_id = $user2_id)");
        $this->db->or_where("(sender_id = $user2_id AND receiver_id = $user1_id)");
        $this->db->order_by('created_at', 'ASC');
        return $this->db->get('chat')->result();
    }

    /**
     * Menyimpan pesan baru ke database.
     */
    public function save_message($data)
    {
        $this->db->insert('chat', $data);
        return $this->db->insert_id();
    }

    public function count_unread_messages_from_sender($receiver_id, $sender_id)
    {
        $this->db->where('receiver_id', $receiver_id);
        $this->db->where('sender_id', $sender_id);
        // --- PERUBAHAN DI SINI ---
        // Memeriksa status yang BUKAN 'read'
        $this->db->where('status !=', 'read');
        return $this->db->count_all_results('chat');
    }

    public function mark_messages_as_read($my_id, $partner_id)
    {
        // --- PERUBAHAN DI SINI ---
        // Mengubah status menjadi 'read'
        $this->db->set('status', 'read');

        // Kondisi: pesan yang ditujukan untuk saya (receiver_id)
        $this->db->where('receiver_id', $my_id);
        // dari partner yang chatnya sedang dibuka (sender_id)
        $this->db->where('sender_id', $partner_id);
        // yang statusnya belum 'read'
        $this->db->where('status !=', 'read');

        // Jalankan query UPDATE
        return $this->db->update('chat');
    }
}
