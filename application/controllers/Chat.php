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

    // Fungsi untuk menampilkan halaman room chat CCS

    public function room($no_tiket)
    {
        $this->load->model('Pelaporan_model');
        $ccs_data = $this->Pelaporan_model->get_by_no_tiket($no_tiket);

        if (!$ccs_data) {
            show_404();
            return;
        }

        $my_id = $this->session->userdata('id_user');
        $my_role = $this->session->userdata('role');
        $super_access_roles = ['3', '6', '9'];
        $has_super_access = in_array($my_role, $super_access_roles);

        if (!$has_super_access) {
            $id_pelaporan = $ccs_data->id_pelaporan;
            $allowed_users = $this->Chat_model->get_allowed_users($id_pelaporan);
            if (!in_array($my_id, $allowed_users)) {
                show_error('Anda tidak memiliki izin untuk mengakses ruang obrolan ini.', 403, 'Akses Ditolak');
                return;
            }
        }

        // Tandai semua pesan sebagai sudah dibaca
        $this->Chat_model->mark_ccs_messages_as_read($ccs_data->id_pelaporan, $my_id);

        // --- BAGIAN BARU: Kirim sinyal untuk menghapus badge di halaman forward ---
        try {
            $options = [
                'cluster' => PUSHER_APP_CLUSTER,
                'useTLS'  => true
            ];
            $pusher = new Pusher(PUSHER_APP_KEY, PUSHER_APP_SECRET, PUSHER_APP_ID, $options);

            $notification_channel = 'user-notifications-' . $my_id;
            $notification_data = [
                'tiket_id'     => (int)$ccs_data->id_pelaporan,
                'unread_count' => 0 // Kirim 0 untuk menghapus badge
            ];
            $pusher->trigger($notification_channel, 'update-badge', $notification_data);
        } catch (Exception $e) {
            // Abaikan jika Pusher gagal, ini bukan fungsionalitas kritis
        }
        // --- AKHIR BAGIAN BARU ---

        $data_to_view = [
            'ccs_data' => $ccs_data
        ];

        $this->load->view('chat_room', $data_to_view);
    }



    // API endpoint untuk mengambil riwayat pesan CCS
    public function get_ccs_messages($ccs_id)
    {
        $messages = $this->Chat_model->get_ccs_messages($ccs_id);
        echo json_encode($messages);
    }

    // API endpoint untuk mengirim pesan di room chat CCS
    // public function send_ccs_message()
    // {
    //     $sender_id = $this->session->userdata('id_user');
    //     $ccs_id    = $this->input->post('tiket_id');
    //     $message   = $this->input->post('message');
    //     // --- TAMBAHKAN: Ambil ID pesan yang dibalas ---
    //     $reply_to_id = $this->input->post('reply_to_id');

    //     // --- MODIFIKASI: Tambahkan reply_to_id ke data yang akan disimpan ---
    //     $data = [
    //         'sender_id' => $sender_id,
    //         'message'   => $message,
    //         'tiket_id'  => $ccs_id,
    //         'status'    => 'read'
    //     ];

    //     // Hanya tambahkan reply_to_id jika ada (bukan pesan biasa)
    //     if (!empty($reply_to_id)) {
    //         $data['reply_to_id'] = $reply_to_id;
    //     }

    //     // Simpan pesan dan dapatkan ID dari pesan yang baru saja di-insert
    //     $insert_id = $this->Chat_model->save_ccs_message($data);

    //     if ($insert_id) {
    //         try {
    //             $options = [
    //                 'cluster' => PUSHER_APP_CLUSTER,
    //                 'useTLS'  => true
    //             ];
    //             $pusher = new Pusher(PUSHER_APP_KEY, PUSHER_APP_SECRET, PUSHER_APP_ID, $options);

    //             $channel = 'chat-room-' . $ccs_id;

    //             // --- MODIFIKASI: Siapkan data untuk Pusher ---
    //             $push_data = [
    //                 'id'          => $insert_id, // Kirim ID pesan baru agar UI bisa update
    //                 'sender_id'   => $sender_id,
    //                 'nama_user'   => $this->session->userdata('nama_user'),
    //                 'message'     => $message,
    //                 'created_at'  => date('c'), // Format ISO 8601 yang lebih baik untuk JS
    //                 'reply_to'    => null // Default 'reply_to' adalah null
    //             ];

    //             // Jika ini adalah balasan, ambil detail pesan asli untuk dikirim via Pusher
    //             if (!empty($reply_to_id)) {
    //                 // Anda perlu fungsi baru di model untuk mengambil detail ini
    //                 $original_message = $this->Chat_model->get_message_details_for_reply($reply_to_id);
    //                 if ($original_message) {
    //                     $push_data['reply_to'] = [
    //                         'id'        => $original_message->id,
    //                         'nama_user' => $original_message->nama_user,
    //                         'message'   => $original_message->message
    //                     ];
    //                 }
    //             }

    //             $pusher->trigger($channel, 'new-message', $push_data);

    //             echo json_encode(['status' => 'success', 'insert_id' => $insert_id]);
    //         } catch (Exception $e) {
    //             echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    //         }
    //     } else {
    //         echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan pesan']);
    //     }
    // }
    // application/controllers/Chat.php

    public function send_ccs_message()
    {
        $sender_id   = $this->session->userdata('id_user');
        $ccs_id      = $this->input->post('tiket_id'); // Ini adalah id_pelaporan
        $message     = $this->input->post('message');
        $reply_to_id = $this->input->post('reply_to_id');

        $data = [
            'sender_id' => $sender_id,
            'message'   => $message,
            'tiket_id'  => $ccs_id,
            'status'    => 'read' // Dianggap langsung read untuk group chat
        ];

        if (!empty($reply_to_id)) {
            $data['reply_to_id'] = $reply_to_id;
        }

        $insert_id = $this->Chat_model->save_ccs_message($data);

        if ($insert_id) {
            try {
                $options = [
                    'cluster' => PUSHER_APP_CLUSTER,
                    'useTLS'  => true
                ];
                $pusher = new Pusher(PUSHER_APP_KEY, PUSHER_APP_SECRET, PUSHER_APP_ID, $options);

                // =======================================================================
                // BAGIAN 1: Mengirim pesan ke Chat Room (PENTING UNTUK NOTIFIKASI DESKTOP)
                // =======================================================================
                $chat_room_channel = 'chat-room-' . $ccs_id;

                // Siapkan data pesan lengkap untuk dikirim ke chat room
                $original_message_details = null;
                if (!empty($reply_to_id)) {
                    $original_message_details = $this->Chat_model->get_message_details_for_reply($reply_to_id);
                }
                $push_data = [
                    'id'          => $insert_id,
                    'sender_id'   => $sender_id,
                    'nama_user'   => $this->session->userdata('nama_user'),
                    'message'     => $message,
                    'created_at'  => date('c'),
                    'reply_to'    => $original_message_details ? [
                        'id'        => $original_message_details->id,
                        'nama_user' => $original_message_details->nama_user,
                        'message'   => $original_message_details->message
                    ] : null
                ];

                // Trigger event 'new-message' yang akan diterima oleh chat_room.php
                $pusher->trigger($chat_room_channel, 'new-message', $push_data);


                // ===============================================================
                // BAGIAN 2: Mengirim sinyal update badge ke halaman Forward
                // ===============================================================
                $involved_users = $this->Chat_model->get_allowed_users($ccs_id);
                foreach ($involved_users as $user_id) {
                    // Jangan kirim notif badge ke diri sendiri
                    if ($user_id == $sender_id) {
                        continue;
                    }

                    $unread_count = $this->Chat_model->get_unread_ccs_messages_count($ccs_id, $user_id);

                    $notification_channel = 'user-notifications-' . $user_id;
                    $notification_data = [
                        'tiket_id'     => (int)$ccs_id,
                        'unread_count' => $unread_count
                    ];

                    // Trigger event 'update-badge' yang akan diterima oleh forward.php
                    $pusher->trigger($notification_channel, 'update-badge', $notification_data);
                }

                // Kirim response sukses ke pengirim pesan
                echo json_encode(['status' => 'success', 'insert_id' => $insert_id]);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan pesan']);
        }
    }
}
