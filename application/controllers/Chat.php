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
    // public function room($ccs_id)
    // {
    //     echo "<pre style='background-color: #333; color: #eee; padding: 20px; font-family: monospace;'>";
    //     echo "<h1>--- SESI DEBUGGING HAK AKSES ---</h1>";

    //     $my_id = $this->session->userdata('id_user');
    //     $allowed_users = $this->Chat_model->get_involved_users_by_ccs_id($ccs_id);

    //     echo "<h3>ID Saya (yang sedang login):</h3>";
    //     var_dump($my_id);

    //     echo "<hr>";

    //     echo "<h3>Daftar ID User yang diizinkan untuk tiket ini (dari Model):</h3>";
    //     var_dump($allowed_users);

    //     echo "<hr>";

    //     // Kita lakukan pengecekan secara manual untuk melihat hasilnya
    //     $is_allowed = in_array($my_id, $allowed_users);
    //     echo "<h3>Apakah ID saya ada di dalam daftar di atas?</h3>";
    //     var_dump($is_allowed);

    //     echo "<hr>";
    //     echo "<h2>--- AKHIR DEBUGGING ---</h2>";
    //     echo "</pre>";

    //     die(); // Hentikan eksekusi di sini agar kita bisa lihat hasilnya.
    // }
    // public function room($ccs_id)
    // {
    //     // Pastikan Anda punya model untuk mengambil data tiket/ccs
    //     // Ganti 'Serversidehandle_model' sesuai dengan nama model Anda yang benar
    //     $this->load->model('Serversidehandle_model');

    //     // Ganti 'get_by_id_pelaporan' sesuai fungsi di model Anda untuk mengambil 1 tiket
    //     $ccs_data = $this->Serversidehandle_model->get_by_id_pelaporan($ccs_id);

    //     if (!$ccs_data) {
    //         // Jika data tiket tetap tidak ditemukan, tampilkan pesan error yang lebih jelas
    //         die("Error: Tidak dapat menemukan data tiket dengan ID: " . $ccs_id . ". Pastikan nama model dan fungsi sudah benar.");
    //     }

    //     // Data yang akan dikirim ke view baru kita
    //     $data_to_view = [
    //         'ccs_data' => $ccs_data
    //     ];

    //     // Pastikan nama view Anda benar (chat_room.php)
    //     $this->load->view('chat_room', $data_to_view);
    // }

    public function room($no_tiket)
    {
        // 1. Ambil data tiket lengkap berdasarkan no_tiket
        $this->load->model('Pelaporan_model');
        $ccs_data = $this->Pelaporan_model->get_by_no_tiket($no_tiket);

        // Jika tiket tidak ada di database, langsung tampilkan 404
        if (!$ccs_data) {
            show_404();
            return;
        }

        // Ambil data user yang sedang login
        $my_id = $this->session->userdata('id_user');
        $my_role = $this->session->userdata('role');

        // Daftar role yang memiliki akses super (Superadmin, SPV1, SPV2)
        $super_access_roles = ['3', '6', '9'];

        // Cek 1: Apakah user yang login memiliki role super?
        $has_super_access = in_array($my_role, $super_access_roles);

        if (!$has_super_access) {

            $id_pelaporan = $ccs_data->id_pelaporan;

            // Lakukan pemeriksaan hak akses menggunakan ID numerik
            $allowed_users = $this->Chat_model->get_allowed_users($id_pelaporan);
            $is_allowed = in_array($my_id, $allowed_users);

            if (!$is_allowed) {
                show_error('Anda tidak memiliki izin untuk mengakses ruang obrolan ini.', 403, 'Akses Ditolak');
                return;
            }
        }


        // 4. Jika lolos, kirim data tiket ke view
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
    public function send_ccs_message()
    {
        $sender_id = $this->session->userdata('id_user');
        $ccs_id    = $this->input->post('tiket_id');
        $message   = $this->input->post('message');
        // --- TAMBAHKAN: Ambil ID pesan yang dibalas ---
        $reply_to_id = $this->input->post('reply_to_id');

        // --- MODIFIKASI: Tambahkan reply_to_id ke data yang akan disimpan ---
        $data = [
            'sender_id' => $sender_id,
            'message'   => $message,
            'tiket_id'  => $ccs_id,
            'status'    => 'read'
        ];

        // Hanya tambahkan reply_to_id jika ada (bukan pesan biasa)
        if (!empty($reply_to_id)) {
            $data['reply_to_id'] = $reply_to_id;
        }

        // Simpan pesan dan dapatkan ID dari pesan yang baru saja di-insert
        $insert_id = $this->Chat_model->save_ccs_message($data);

        if ($insert_id) {
            try {
                $options = [
                    'cluster' => PUSHER_APP_CLUSTER,
                    'useTLS'  => true
                ];
                $pusher = new Pusher(PUSHER_APP_KEY, PUSHER_APP_SECRET, PUSHER_APP_ID, $options);

                $channel = 'chat-room-' . $ccs_id;

                // --- MODIFIKASI: Siapkan data untuk Pusher ---
                $push_data = [
                    'id'          => $insert_id, // Kirim ID pesan baru agar UI bisa update
                    'sender_id'   => $sender_id,
                    'nama_user'   => $this->session->userdata('nama_user'),
                    'message'     => $message,
                    'created_at'  => date('c'), // Format ISO 8601 yang lebih baik untuk JS
                    'reply_to'    => null // Default 'reply_to' adalah null
                ];

                // Jika ini adalah balasan, ambil detail pesan asli untuk dikirim via Pusher
                if (!empty($reply_to_id)) {
                    // Anda perlu fungsi baru di model untuk mengambil detail ini
                    $original_message = $this->Chat_model->get_message_details_for_reply($reply_to_id);
                    if ($original_message) {
                        $push_data['reply_to'] = [
                            'id'        => $original_message->id,
                            'nama_user' => $original_message->nama_user,
                            'message'   => $original_message->message
                        ];
                    }
                }

                $pusher->trigger($channel, 'new-message', $push_data);

                echo json_encode(['status' => 'success', 'insert_id' => $insert_id]);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan pesan']);
        }
    }
    // public function send_ccs_message()
    // {
    //     $sender_id = $this->session->userdata('id_user');
    //     $ccs_id    = $this->input->post('tiket_id');
    //     $message   = $this->input->post('message');

    //     $data = [
    //         'sender_id' => $sender_id,
    //         'message'   => $message,
    //         'tiket_id'    => $ccs_id,
    //         'status'    => 'read' // Pesan di room chat langsung dianggap 'read'
    //     ];
    //     $insert_id = $this->Chat_model->save_ccs_message($data);

    //     if ($insert_id) {
    //         try {
    //             $options = [
    //                 'cluster' => PUSHER_APP_CLUSTER,
    //                 'useTLS'  => true
    //             ];
    //             $pusher = new Pusher(PUSHER_APP_KEY, PUSHER_APP_SECRET, PUSHER_APP_ID, $options);

    //             // Channel Pusher unik untuk setiap room chat CCS
    //             $channel = 'chat-room-' . $ccs_id;

    //             $push_data = [
    //                 'sender_id'   => $sender_id,
    //                 'nama_user'   => $this->session->userdata('nama_user'), // Kirim juga nama pengirim
    //                 'message'     => $message,
    //                 'created_at'  => date('c'),
    //             ];
    //             $pusher->trigger($channel, 'new-message', $push_data);

    //             echo json_encode(['status' => 'success']);
    //         } catch (Exception $e) {
    //             echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    //         }
    //     } else {
    //         echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan pesan']);
    //     }
    // }


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
