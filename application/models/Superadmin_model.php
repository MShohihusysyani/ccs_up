<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Superadmin_model extends CI_Model
{

    private $table = 'pelaporan';
    private $column_order = array(null, 'no_tiket', 'waktu_pelaporan', 'nama', 'perihal', 'impact', 'file', 'kategori', 'tags', 'priority', 'maxday', 'status_ccs', 'handle_by', 'handle_by2', 'handle_by3');
    private $column_search = array('no_tiket', 'waktu_pelaporan', 'nama', 'perihal', 'impact', 'file', 'kategori', 'tags', 'priority', 'maxday', 'status_ccs', 'handle_by', 'handle_by2', 'handle_by3');
    private $order = array('waktu_pelaporan' => 'DESC');

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->db->from($this->table);

        $i = 0;

        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    //ALL TICKET
    public function getKlienPelaporan()
    {

        // Fetch user data from the session
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        if ($data['user']) {
            $user_id = $this->session->userdata('id_user');

            $query = "
            SELECT DISTINCT
                nama, 
                id_pelaporan, 
                user_id, 
                kategori,
                judul, 
                perihal, 
                waktu_pelaporan, 
                status_ccs, 
                file, 
                status, 
                no_tiket, 
                priority, 
                handle_by, 
                impact, 
                maxday, 
                handle_by2, 
                handle_by3, 
                tags
            FROM 
                pelaporan 
            ORDER BY 
                waktu_pelaporan DESC
        ";

            $result = $this->db->query($query);

            if ($result) {
                return $result->result_array();
            } else {
                log_message('error', 'Query failed: ' . $this->db->last_query());
                return [];
            }
        } else {
            log_message('error', 'User not found in session.');
            return [];
        }
    }

    //ADDED
    public function getDataAdded()
    {

        // Fetch user data from the session
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        // Ensure the user is retrieved
        if ($data['user']) {
            // User ID from session
            $user_id = $this->session->userdata('id_user');

            // SQL query to retrieve reports with status_ccs='ADDED'
            $query = "
            SELECT DISTINCT
                nama, 
                id_pelaporan, 
                user_id, 
                kategori, 
                judul,
                perihal, 
                waktu_pelaporan, 
                status_ccs, 
                file, 
                status, 
                no_tiket, 
                priority, 
                maxday,
                tgl_jatuh_tempo,
                handle_by, 
                tags
            FROM 
                pelaporan 
            WHERE 
                status_ccs = 'ADDED' 
            ORDER BY 
                waktu_pelaporan DESC
        ";

            $result = $this->db->query($query);

            if ($result) {
                return $result->result_array();
            } else {
                log_message('error', 'Query failed: ' . $this->db->last_query());
                return [];
            }
        } else {
            log_message('error', 'User not found in session.');
            return [];
        }
    }

    //ON PROGRESS/HANDLE
    public function getKlienPelaporanOP()
    {

        // Fetch user data from the session
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        if ($data['user']) {
            $user_id = $this->session->userdata('id_user');

            $query = "
            SELECT DISTINCT
                nama, 
                id_pelaporan, 
                user_id, 
                kategori,
                judul, 
                perihal, 
                waktu_pelaporan, 
                status_ccs, 
                file, 
                status, 
                no_tiket, 
                priority,
                maxday, 
                handle_by, 
                impact, 
                handle_by2, 
                handle_by3, 
                tags
            FROM 
                pelaporan 
            WHERE 
                status_ccs IN ('HANDLED', 'HANDLED 2', 'ADDED 2', 'HANDLE 2') 
            ORDER BY 
                waktu_pelaporan DESC
        ";

            $result = $this->db->query($query);

            if ($result) {
                return $result->result_array();
            } else {
                log_message('error', 'Query failed: ' . $this->db->last_query());
                return [];
            }
        } else {
            log_message('error', 'User not found in session.');
            return [];
        }
    }

    //CLOSE
    public function getDataClosed()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, judul, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, maxday, handle_by, maxday, handle_by2, handle_by3, impact, tags  FROM pelaporan WHERE status_ccs='CLOSED' ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    //FINISH
    public function getKlienPelaporanFinish()
    {

        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        if ($data['user']) {
            // User ID from session
            $user_id = $this->session->userdata('id_user');

            $query = "
            SELECT DISTINCT
                nama, 
                id_pelaporan, 
                user_id, 
                kategori,
                judul, 
                perihal, 
                waktu_pelaporan, 
                status_ccs, 
                file, 
                status, 
                no_tiket, 
                priority,
                handle_by, 
                maxday, 
                waktu_approve, 
                handle_by2, 
                handle_by3, 
                impact, 
                tags,
                rating
            FROM 
                pelaporan 
            WHERE 
                status_ccs = 'FINISHED' 
            ORDER BY 
                waktu_pelaporan DESC
        ";

            $result = $this->db->query($query);

            if ($result) {
                return $result->result_array();
            } else {
                log_message('error', 'Query failed: ' . $this->db->last_query());
                return [];
            }
        } else {
            log_message('error', 'User not found in session.');
            return [];
        }
    }

    public function updateTeknisi($id_pelaporan, $nama_user)
    {

        $query = "UPDATE pelaporan SET status_ccs='HANDLED 2', handle_by2 = '$nama_user'  WHERE id_pelaporan=$id_pelaporan";
        return $this->db->query($query);
    }

    public function getAllData()
    {

        $this->db->order_by('waktu_pelaporan', 'DESC');
        $query = $this->db->get('pelaporan');
        return $query->result();
    }

    public function getAllDataFinish()
    {

        $this->db->order_by('waktu_pelaporan', 'DESC');
        $this->db->where('status_ccs', 'FINISHED');
        $query = $this->db->get('pelaporan');
        return $query->result();
    }

    public function ambil_id_pelaporan($id)
    {
        $query = "SELECT  id_pelaporan, no_tiket, waktu_pelaporan, perihal, judul, nama, status_ccs, kategori, priority, maxday, impact, file, tags, catatan_finish, file_finish, handle_by, handle_by2, handle_by3  FROM pelaporan WHERE id_pelaporan='$id'";
        return $this->db->query($query)->result_array();
    }

    public function ambil_id_comment($id)
    {

        $query = "SELECT  user.nama_user, user.id_user, comment.body, comment.pelaporan_id, comment.id_comment, comment.file
        FROM comment
        LEFT JOIN user ON comment.user_id=user.id_user
        WHERE comment.pelaporan_id='$id'";

        return $this->db->query($query)->result_array();
    }

    public function ambil_id_comment2($id)
    {

        $this->db->select('user.nama_user, user.id_user, comment.body, comment.pelaporan_id, comment.id_comment, comment.file');
        $this->db->from('comment');
        $this->db->join('user', 'comment.user_id = user.id_user', 'left');
        $this->db->where('comment.pelaporan_id', $id);
    }

    public function get_latest_comments($id)
    {
        $query = "SELECT 
                    user.nama_user, 
                    user.id_user, 
                    comment.body AS comment_body, 
                    comment.pelaporan_id, 
                    comment.created_at,
                    comment.file,
                    comment.id_comment
                FROM comment
                LEFT JOIN user ON comment.user_id = user.id_user
                WHERE comment.pelaporan_id = '$id' AND comment.parent_id = 0
                ORDER BY comment.created_at DESC";

        return $this->db->query($query, array($id))->result_array();
    }

    public function get_replies_by_pelaporan_id($id)
    {
        $query = "SELECT 
                    user.nama_user, 
                    user.id_user, 
                    reply.body, 
                    reply.pelaporan_id
                FROM reply
                LEFT JOIN user ON reply.user_id = user.id_user
                WHERE reply.pelaporan_id = $id
                ORDER BY reply.created_at DESC";

        return $this->db->query($query, array($id))->result_array();
    }


    public function getKlien()
    {
        $query = "SELECT nama, COUNT(nama) AS jumlah FROM pelaporan GROUP BY nama ORDER BY jumlah DESC";
        return $this->db->query($query)->result_array();
    }
    public function getPelaporanByNoTiket($no_tiket)
    {
        // Ambil data pelaporan berdasarkan no_tiket
        $this->db->where('no_tiket', $no_tiket);
        $queryPelaporan = $this->db->get('pelaporan');
        $pelaporan = $queryPelaporan->row();

        if ($pelaporan) {
            // Ambil komentar yang terkait dengan pelaporan
            $this->db->where('pelaporan_id', $pelaporan->id_pelaporan);
            $queryComments = $this->db->get('comment');
            $comments = $queryComments->result_array();

            foreach ($comments as &$comment) {
                // Ambil nama user dari tabel users
                $this->db->select('nama_user'); // Kolom nama di tabel users
                $this->db->where('id_user', $comment['user_id']); // Menyesuaikan dengan user_id di komentar
                $queryUser = $this->db->get('user'); // Asumsi tabel user ada
                $user = $queryUser->row();
                $comment['nama_user'] = $user ? $user->nama_user : 'Unknown'; // Jika user tidak ditemukan

                // Ambil balasan untuk setiap komentar
                $this->db->where('comment_id', $comment['id_comment']);
                $queryReplies = $this->db->get('reply');
                $replies = $queryReplies->result_array();

                foreach ($replies as &$reply) {
                    // Ambil nama user dari tabel user untuk setiap balasan
                    $this->db->select('nama_user');
                    $this->db->where('id_user', $reply['user_id']); // Menyesuaikan dengan user_id di balasan
                    $queryReplyUser = $this->db->get('user');
                    $replyUser = $queryReplyUser->row();
                    $reply['nama_user'] = $replyUser ? $replyUser->nama_user : 'Unknown'; // Jika user tidak ditemukan
                }

                $comment['replies'] = $replies; // Menambahkan balasan ke komentar
            }

            // Menambahkan komentar ke pelaporan
            $pelaporan->comments = $comments; // Menambahkan komentar ke objek pelaporan
        }

        return $pelaporan; // Mengembalikan objek pelaporan dengan komentar
    }


    // public function getPelaporanById($id_pelaporan)
    // {
    //     $this->db->where('id_pelaporan', $id_pelaporan);
    //     $query = $this->db->get('pelaporan');
    //     return $query->row_array();
    // }

    public function getTicketDetail($no_tiket)
    {
        $this->db->select('*');
        $this->db->from('pelaporan');
        $this->db->where('no_tiket', $no_tiket);
        $query = $this->db->get();
        return $query->row();
    }

    // NOTIFICATION
    public function get_notifications()
    {
        $this->db->select('id_pelaporan, no_tiket, judul, nama, waktu_pelaporan, status_ccs');
        $this->db->from('pelaporan');
        $this->db->where('status_ccs', 'ADDED');
        $this->db->order_by('waktu_pelaporan', 'DESC');
        // $this->db->limit(100);
        $query = $this->db->get();

        return $query->result_array();
    }

    // Menghitung jumlah notifikasi yang belum dibaca
    public function count_unread_notifications()
    {
        $this->db->where('status_ccs', 'ADDED');  // Syarat untuk notifikasi belum dibaca
        return $this->db->count_all_results('pelaporan');
    }

    //     public function fetchData($columns)
    // {
    //     $this->db->select('*');
    //     $this->db->from('pelaporan'); // Replace with your table name
    //     // Add your filtering and sorting logic here based on $_POST parameters

    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

    // public function countAllData()
    // {
    //     return $this->db->count_all('pelaporan'); // Replace with your table name
    // }

    // public function countFilteredData()
    // {
    //     $this->db->select('*');
    //     $this->db->from('pelaporan'); // Replace with your table name
    //     // Add your filtering logic here based on $_POST parameters

    //     $query = $this->db->get();
    //     return $query->num_rows();
    // }
}
