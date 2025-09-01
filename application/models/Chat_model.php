<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chat_model extends CI_Model
{
    public function get_contact_list($my_id, $my_role)
    {
        $allowed_roles = [];
        switch ($my_role) {
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
            // --- PASTIKAN NAMA INI BENAR ---
            '(SELECT created_at FROM chat WHERE (sender_id = u.id_user AND receiver_id = ' . $my_id . ') OR (sender_id = ' . $my_id . ' AND receiver_id = u.id_user) ORDER BY created_at DESC LIMIT 1) as last_message_created_at',
            '(SELECT COUNT(*) FROM chat WHERE sender_id = u.id_user AND receiver_id = ' . $my_id . " AND status != 'read') as unread_count"
        ]);
        $this->db->from('user u');
        $this->db->where('u.id_user !=', $my_id);
        $this->db->where('u.active', 'Y');

        if (!empty($allowed_roles)) {
            $this->db->where_in('u.role', $allowed_roles);
        }

        $this->db->order_by('last_message_created_at', 'DESC');

        return $this->db->get()->result();
    }

    public function get_messages($user1_id, $user2_id)
    {
        // Menambahkan select untuk memastikan semua kolom yang dibutuhkan terambil
        $this->db->select('id, sender_id, receiver_id, message, status, created_at');
        $this->db->where("(sender_id = $user1_id AND receiver_id = $user2_id)");
        $this->db->or_where("(sender_id = $user2_id AND receiver_id = $user1_id)");
        $this->db->order_by('created_at', 'ASC');
        return $this->db->get('chat')->result();
    }

    public function save_message($data)
    {
        $this->db->insert('chat', $data);
        return $this->db->insert_id();
    }

    public function count_unread_messages_from_sender($receiver_id, $sender_id)
    {
        $this->db->where('receiver_id', $receiver_id);
        $this->db->where('sender_id', $sender_id);
        $this->db->where('status !=', 'read');
        return $this->db->count_all_results('chat');
    }

    public function mark_messages_as_read($my_id, $partner_id)
    {
        $this->db->set('status', 'read');
        $this->db->where('receiver_id', $my_id);
        $this->db->where('sender_id', $partner_id);
        $this->db->where('status !=', 'read');
        return $this->db->update('chat');
    }

    /**
     * Mengambil riwayat pesan untuk sebuah room chat CCS.
     */
    public function get_ccs_messages($ccs_id)
    {
        // Query ini akan:
        // 1. Mengambil semua pesan untuk tiket_id tertentu.
        // 2. Mengambil nama PENGIRIM pesan (sender.nama_user).
        // 3. Mengambil detail pesan yang DIBALAS (replied_message.message).
        // 4. Mengambil nama PENGIRIM dari pesan yang DIBALAS (replied_user.nama_user).
        $this->db->select('
        chat.id,
        chat.sender_id,
        chat.message,
        chat.created_at,
        chat.reply_to_id,
        sender.nama_user, 
        replied_message.id as reply_id,
        replied_message.message as reply_message,
        replied_user.nama_user as reply_nama_user
    ');
        $this->db->from('chat');
        $this->db->join('user as sender', 'sender.id_user = chat.sender_id');

        // LEFT JOIN digunakan karena tidak semua pesan adalah balasan.
        $this->db->join('chat as replied_message', 'replied_message.id = chat.reply_to_id', 'left');
        $this->db->join('user as replied_user', 'replied_user.id_user = replied_message.sender_id', 'left');

        $this->db->where('chat.tiket_id', $ccs_id);
        $this->db->order_by('chat.created_at', 'ASC');

        $results = $this->db->get()->result();

        // Sekarang, kita format hasilnya agar menjadi struktur JSON yang benar untuk JavaScript
        $formatted_messages = [];
        foreach ($results as $row) {
            $message = [
                'id'          => $row->id,
                'sender_id'   => $row->sender_id,
                'nama_user'   => $row->nama_user,
                'message'     => $row->message,
                'created_at'  => $row->created_at,
                'reply_to'    => null // Default 'reply_to' adalah null
            ];

            // Jika pesan ini adalah balasan (reply_to_id tidak kosong),
            // kita buat objek 'reply_to' dengan data yang sudah kita ambil.
            if (!empty($row->reply_to_id)) {
                $message['reply_to'] = [
                    'id'        => $row->reply_id,
                    'nama_user' => $row->reply_nama_user,
                    'message'   => $row->reply_message
                ];
            }

            // Tambahkan pesan yang sudah diformat ke dalam array hasil
            $formatted_messages[] = (object) $message;
        }

        return $formatted_messages;
    }
    // public function get_ccs_messages($ccs_id)
    // {
    //     $this->db->select('chat.*, user.nama_user'); // Ambil juga nama pengirim
    //     $this->db->from('chat');
    //     $this->db->join('user', 'user.id_user = chat.sender_id');
    //     $this->db->where('chat.tiket_id', $ccs_id);
    //     $this->db->order_by('chat.created_at', 'ASC');
    //     return $this->db->get()->result();
    // }

    /**
     * Menyimpan pesan baru ke database untuk sebuah room chat CCS.
     */
    public function save_ccs_message($data)
    {
        // data sudah termasuk sender_id, message, dan ccs_id
        $this->db->insert('chat', $data);
        return $this->db->insert_id();
    }

    // Buka application/models/Chat_model.php
    // GANTI SELURUH FUNGSI get_involved_users_by_ccs_id DENGAN KODE FINAL INI:

    public function get_allowed_users($ccs_id)
    {
        $allowed_users = [];

        // 1. Ambil ID Klien (pelapor) dari tabel 'pelaporan'
        // Kolom yang benar: 'user_id' dan 'id_pelaporan'
        $pelaporan = $this->db->select('user_id')->where('id_pelaporan', $ccs_id)->get('pelaporan')->row();
        if ($pelaporan && $pelaporan->user_id) {
            $allowed_users[] = $pelaporan->user_id;
        }

        // 2. Ambil ID Handle 1 dari tabel 'forward'
        // Kolom yang benar: 'user_id' dan 'pelaporan_id'
        $handle1 = $this->db->select('user_id')->where('pelaporan_id', $ccs_id)->get('forward')->row();
        if ($handle1 && $handle1->user_id) {
            $allowed_users[] = $handle1->user_id;
        }

        // 3. Ambil ID Handle 2 dari tabel 't1_forward'
        // Kolom yang benar: 'user_id' dan 'pelaporan_id'
        $handle2 = $this->db->select('user_id')->where('pelaporan_id', $ccs_id)->get('t1_forward')->row();
        if ($handle2 && $handle2->user_id) {
            $allowed_users[] = $handle2->user_id;
        }

        // Mengembalikan daftar ID yang unik untuk menghindari duplikasi
        return array_unique($allowed_users);
    }

    // Tambahkan fungsi ini di dalam file Chat_model.php Anda
    public function get_message_details_for_reply($message_id)
    {
        // Ganti 'tabel_pesan_ccs' dengan nama tabel pesan Anda
        // Ganti 'tabel_user' dengan nama tabel user Anda
        // Ganti 'tabel_user.id' dan 'tabel_user.nama' sesuai struktur tabel Anda
        $this->db->select('chat.*, user.id_user, user.nama_user');
        $this->db->from('chat');
        $this->db->join('user', 'user.id_user = chat.sender_id');
        $this->db->where('chat.id', $message_id);
        $query = $this->db->get();

        return $query->row(); // Mengembalikan satu baris objek
    }
}
