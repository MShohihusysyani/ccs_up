<?php

use Pusher\Pusher;

defined('BASEPATH') or exit('No direct script access allowed');

class Chat extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Pastikan user sudah login dan session ada. Sesuaikan dengan sistem login Anda.
        if (!$this->session->userdata('id_user')) {
            redirect('auth'); // Ganti 'auth' dengan controller login Anda
        }
        $this->load->model('Chat_model');
    }

    // Menampilkan halaman chat utama
    public function index()
    {
        $this->load->view('chat_view');
    }

    // API endpoint untuk mengambil daftar kontak
    public function get_contacts()
    {
        $my_id = $this->session->userdata('id_user');
        $my_role = $this->session->userdata('role');

        $users = $this->Chat_model->get_contact_list($my_id, $my_role);
        echo json_encode($users);
    }

    // API endpoint untuk mengambil riwayat pesan
    public function get_messages($partner_id)
    {
        $my_id = $this->session->userdata('id_user');
        // Nanti di sini bisa ditambahkan logika izin untuk Supervisor/Superadmin
        // Untuk saat ini, kita hanya ambil pesan antara user yg login dan partnernya
        $messages = $this->Chat_model->get_messages($my_id, $partner_id);
        echo json_encode($messages);
    }

    // API endpoint untuk mengirim pesan
    public function send_message()
    {
        $sender_id   = $this->session->userdata('id_user');
        $receiver_id = $this->input->post('receiver_id');
        $message     = $this->input->post('message');

        $data = [
            'sender_id'   => $sender_id,
            'receiver_id' => $receiver_id,
            'message'     => $message,
        ];
        $insert_id = $this->Chat_model->save_message($data);

        if ($insert_id) {
            try {
                $options = [
                    'cluster' => PUSHER_APP_CLUSTER,
                    'useTLS'  => true
                ];
                $pusher = new Pusher(PUSHER_APP_KEY, PUSHER_APP_SECRET, PUSHER_APP_ID, $options);

                date_default_timezone_set('Asia/Jakarta');
                $createdAt = date('c'); // ISO 8601 (contoh: 2025-08-20T15:20:00+07:00)

                // 1. Trigger ke channel percakapan (untuk chat window aktif)
                $conversation_channel = 'new-message-' . min($sender_id, $receiver_id) . '-' . max($sender_id, $receiver_id);
                $push_data = [
                    'sender_id'   => $sender_id,
                    'receiver_id' => (int)$receiver_id,
                    'message'     => $message,
                    'created_at'  => $createdAt,
                ];
                $pusher->trigger($conversation_channel, 'new-message', $push_data);

                // 2. Trigger ke channel personal penerima (untuk notifikasi list kontak)
                $notification_channel = 'new-message-' . $receiver_id;
                $unread_count = $this->Chat_model->count_unread_messages_from_sender($receiver_id, $sender_id);
                $notification_data = [
                    'sender_id'    => $sender_id,
                    'message'      => $message,
                    'unread_count' => $unread_count,
                    'created_at'   => $createdAt, // tambahin waktu di notifikasi
                ];
                $pusher->trigger($notification_channel, 'new-message', $notification_data);

                echo json_encode(['status' => 'success']);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save message']);
        }
    }

    // Buka file application/controllers/Chat.php
    // Cari fungsi mark_as_read() dan ganti dengan ini:

    public function mark_as_read($partner_id)
    {
        $my_id = $this->session->userdata('id_user');

        // 1. Update status pesan di database (ini sudah ada)
        $this->Chat_model->mark_messages_as_read($my_id, $partner_id);

        // --- BAGIAN BARU: Trigger Pusher untuk notifikasi 'sudah dibaca' ---
        try {
            $options = [
                'cluster' => PUSHER_APP_CLUSTER,
                'useTLS'  => true
            ];
            $pusher = new Pusher(PUSHER_APP_KEY, PUSHER_APP_SECRET, PUSHER_APP_ID, $options);

            // Channel tujuan adalah channel personal si PENGIRIM pesan (partner_id)
            // Agar notifikasi "Dilihat" muncul di layarnya.
            $read_receipt_channel = 'read-receipt-channel-' . $partner_id;

            // Data yang dikirim: ID user yang baru saja membaca pesan
            $data = ['reader_id' => (int)$my_id];

            // Trigger event 'messages-read'
            $pusher->trigger($read_receipt_channel, 'messages-read', $data);
        } catch (Exception $e) {
            // Abaikan jika Pusher gagal, ini tidak boleh mengganggu fungsionalitas utama
            // Anda bisa menambahkan log error di sini jika perlu
        }
        // --- AKHIR BAGIAN BARU ---

        echo json_encode(['status' => 'success']);
    }

    // public function send_message()
    // {
    //     // ... (kode untuk mengambil data dan menyimpan pesan tetap sama)
    //     $sender_id = $this->session->userdata('id_user');
    //     $receiver_id = $this->input->post('receiver_id');
    //     $message = $this->input->post('message');
    //     $data = [
    //         'sender_id'   => $sender_id,
    //         'receiver_id' => $receiver_id,
    //         'message'     => $message,
    //     ];
    //     $insert_id = $this->Chat_model->save_message($data);

    //     if ($insert_id) {
    //         try {
    //             $options = [
    //                 'cluster' => PUSHER_APP_CLUSTER,
    //                 'useTLS' => true
    //             ];
    //             $pusher = new Pusher(PUSHER_APP_KEY, PUSHER_APP_SECRET, PUSHER_APP_ID, $options);

    //             // 1. Trigger ke channel percakapan (untuk realtime chat yang sedang aktif)
    //             $conversation_channel = 'new-message-' . min($sender_id, $receiver_id) . '-' . max($sender_id, $receiver_id);
    //             date_default_timezone_set('Asia/Jakarta');
    //             $push_data = [
    //                 'sender_id'   => $sender_id,
    //                 'receiver_id' => (int)$receiver_id,
    //                 'message'     => $message,
    //                 'created_at'  => date('Y-m-d H:i:s'),
    //             ];
    //             $pusher->trigger($conversation_channel, 'new-message', $push_data);

    //             // **BAGIAN BARU**: Trigger notifikasi ke channel personal penerima
    //             $notification_channel = 'new-message-' . $receiver_id;
    //             $unread_count = $this->Chat_model->count_unread_messages_from_sender($receiver_id, $sender_id);
    //             $notification_data = [
    //                 'sender_id'    => $sender_id,
    //                 'message'      => $message,
    //                 'unread_count' => $unread_count
    //             ];
    //             $pusher->trigger($notification_channel, 'new-message', $notification_data);

    //             echo json_encode(['status' => 'success']);
    //         } catch (Exception $e) {
    //             echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    //         }
    //     } else {
    //         echo json_encode(['status' => 'error', 'message' => 'Failed to save message']);
    //     }
    // }
    // public function mark_as_read($partner_id)
    // {
    //     $my_id = $this->session->userdata('id_user');
    //     $this->Chat_model->mark_messages_as_read($my_id, $partner_id);
    //     echo json_encode(['status' => 'success']);
    // }
    // public function send_message()
    // {
    //     // Ambil data dari POST request
    //     $sender_id = $this->session->userdata('id_user');
    //     $receiver_id = $this->input->post('receiver_id');
    //     $message = $this->input->post('message');

    //     // Simpan pesan ke database
    //     $data = [
    //         'sender_id'   => $sender_id,
    //         'receiver_id' => $receiver_id,
    //         'message'     => $message,
    //     ];
    //     $insert_id = $this->Chat_model->save_message($data);

    //     if ($insert_id) {
    //         // Jika berhasil disimpan, trigger event ke Pusher
    //         require FCPATH . 'vendor/autoload.php';
    //         $options = [
    //             'cluster' => 'ap1',
    //             'useTLS' => true
    //         ];
    //         $pusher = new Pusher('22626787fd399de4d80a', 'a5543e5d25fcf94b6aaa', '1988550', $options);

    //         // Tentukan nama channel yang konsisten untuk 2 user
    //         $channel_name = 'new-message-' . min($sender_id, $receiver_id) . '-' . max($sender_id, $receiver_id);

    //         // Data yang akan dikirim
    //         $push_data = [
    //             'sender_id'   => $sender_id,
    //             'receiver_id' => $receiver_id,
    //             'message'     => $message,
    //             'created_at'  => date('Y-m-d H:i:s'),
    //         ];

    //         // Kirim event 'new-message' ke channel
    //         $pusher->trigger($channel_name, 'new-message', $push_data);

    //         echo json_encode(['status' => 'success']);
    //     } else {
    //         echo json_encode(['status' => 'error']);
    //     }
    // }
}
