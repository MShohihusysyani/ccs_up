 <?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Supervisor_model extends CI_Model
    {
        var $table_2 = 'pelaporan'; // Na
        var $column_order2 = array(null, 'no_tiket', 'waktu_pelaporan', 'nama', 'judul', 'kategori', 'tags', 'priority', 'maxday', 'status_ccs', 'handle_by', 'rating', null); // Field yang diurutkan
        var $column_search2 = array('no_tiket', 'nama', 'judul', 'kategori'); // Field yang di-search
        var $order2 = array('waktu_pelaporan' => 'desc'); // Default order

        private $table = 'pelaporan';
        private $column_order = array(null, 'no_tiket', 'waktu_pelaporan', 'nama', 'perihal', 'impact', 'file', 'kategori', 'tags', 'priority', 'maxday', 'status_ccs', 'handle_by', 'handle_by2', 'handle_by3', 'rating');
        private $column_search = array('no_tiket', 'waktu_pelaporan', 'nama', 'perihal', 'impact', 'file', 'kategori', 'tags', 'priority', 'maxday', 'status_ccs', 'handle_by', 'handle_by2', 'handle_by3', 'rating');
        private $order = array('waktu_pelaporan' => 'DESC'); // Default order

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
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $user_id = $this->session->userdata('id_user');
            $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, judul, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, handle_by, impact, maxday, handle_by2, handle_by3, tags  FROM pelaporan ORDER BY waktu_pelaporan DESC";
            return $this->db->query($query)->result_array();
        }

        //ADDED
        public function getKlienPelaporanAdd()
        {
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $user_id = $this->session->userdata('id_user');
            $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, judul, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, maxday, handle_by, tags  FROM pelaporan WHERE status_ccs='ADDED' ORDER BY waktu_pelaporan DESC";
            return $this->db->query($query)->result_array();
        }

        //ON PROGRESS/HANDLE
        public function getKlienPelaporanOP()
        {
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $user_id = $this->session->userdata('id_user');

            // Subquery to gather subtasks and their statuses
            $subquery = "
        SELECT
            pelaporan_id,
            MAX(CASE WHEN row_num = 1 THEN subtask END) AS subtask1,
            MAX(CASE WHEN row_num = 1 THEN status END) AS status1,
            MAX(CASE WHEN row_num = 2 THEN subtask END) AS subtask2,
            MAX(CASE WHEN row_num = 2 THEN status END) AS status2,
            MAX(CASE WHEN row_num = 3 THEN subtask END) AS subtask3,
            MAX(CASE WHEN row_num = 3 THEN status END) AS status3,
            MAX(CASE WHEN row_num = 1 THEN tanggal END) AS tanggal,
            MAX(CASE WHEN row_num = 1 THEN judul END) AS forward_judul,
            MAX(CASE WHEN row_num = 1 THEN id_forward END) AS id_forward,
            MAX(CASE WHEN row_num = 1 THEN status END) AS forward_status
        FROM (
            SELECT
                pelaporan_id,
                subtask,
                status,
                tanggal,
                judul,
                id_forward,
                ROW_NUMBER() OVER(PARTITION BY pelaporan_id ORDER BY id_forward) AS row_num
            FROM t1_forward
        ) AS sub
        GROUP BY pelaporan_id
    ";

            // Build the main query
            $this->db->select('
        pelaporan.kategori,
        pelaporan.id_pelaporan,
        pelaporan.waktu_pelaporan,
        pelaporan.status_ccs,
        pelaporan.priority,
        pelaporan.maxday,
        pelaporan.judul,
        pelaporan.perihal,
        pelaporan.file,
        pelaporan.nama,
        pelaporan.no_tiket,
        pelaporan.impact,
        pelaporan.handle_by,
        pelaporan.handle_by2,
        pelaporan.handle_by3,
        pelaporan.status,
        pelaporan.tags,
        subtask_data.subtask1,
        subtask_data.status1,
        subtask_data.subtask2,
        subtask_data.status2,
        subtask_data.subtask3,
        subtask_data.status3,
        subtask_data.tanggal,
        subtask_data.forward_judul,
        subtask_data.id_forward,
        subtask_data.forward_status
    ');
            $this->db->from('pelaporan');
            $this->db->join("($subquery) AS subtask_data", 'subtask_data.pelaporan_id = pelaporan.id_pelaporan', 'left');
            $this->db->where_in('pelaporan.status_ccs', ['ADDED 2', 'HANDLED 2', 'HANDLED']);
            $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

            // Execute the query and return the result
            return $this->db->get()->result_array();
        }


        //CLOSE
        public function getKlienPelaporanClose()
        {
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $user_id = $this->session->userdata('id_user');

            // Subquery to gather subtasks and their statuses
            $subquery = "
        SELECT
            pelaporan_id,
            MAX(CASE WHEN row_num = 1 THEN subtask END) AS subtask1,
            MAX(CASE WHEN row_num = 1 THEN status END) AS status1,
            MAX(CASE WHEN row_num = 2 THEN subtask END) AS subtask2,
            MAX(CASE WHEN row_num = 2 THEN status END) AS status2,
            MAX(CASE WHEN row_num = 3 THEN subtask END) AS subtask3,
            MAX(CASE WHEN row_num = 3 THEN status END) AS status3,
            MAX(CASE WHEN row_num = 1 THEN tanggal END) AS tanggal,
            MAX(CASE WHEN row_num = 1 THEN judul END) AS forward_judul,
            MAX(CASE WHEN row_num = 1 THEN id_forward END) AS id_forward,
            MAX(CASE WHEN row_num = 1 THEN status END) AS forward_status
        FROM (
            SELECT
                pelaporan_id,
                subtask,
                status,
                tanggal,
                judul,
                id_forward,
                ROW_NUMBER() OVER(PARTITION BY pelaporan_id ORDER BY id_forward) AS row_num
            FROM t1_forward
        ) AS sub
        GROUP BY pelaporan_id
    ";

            // Build the main query
            $this->db->select('
        pelaporan.kategori,
        pelaporan.id_pelaporan,
        pelaporan.waktu_pelaporan,
        pelaporan.status_ccs,
        pelaporan.priority,
        pelaporan.maxday,
        pelaporan.judul,
        pelaporan.perihal,
        pelaporan.file,
        pelaporan.nama,
        pelaporan.no_tiket,
        pelaporan.impact,
        pelaporan.handle_by,
        pelaporan.handle_by2,
        pelaporan.handle_by3,
        pelaporan.status,
        pelaporan.tags,
        subtask_data.subtask1,
        subtask_data.status1,
        subtask_data.subtask2,
        subtask_data.status2,
        subtask_data.subtask3,
        subtask_data.status3,
        subtask_data.tanggal,
        subtask_data.forward_judul,
        subtask_data.id_forward,
        subtask_data.forward_status
    ');
            $this->db->from('pelaporan');
            $this->db->join("($subquery) AS subtask_data", 'subtask_data.pelaporan_id = pelaporan.id_pelaporan', 'left');
            $this->db->where('pelaporan.status_ccs', 'CLOSED');
            $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

            // Execute the query and return the result
            return $this->db->get()->result_array();
        }


        //FINISH
        public function getKlienPelaporanFinish()
        {
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $user_id = $this->session->userdata('id_user');
            $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, judul, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, handle_by, maxday, waktu_approve, handle_by2, handle_by3, impact, tags, rating  FROM pelaporan WHERE status_ccs='FINISHED' ORDER BY waktu_pelaporan DESC";
            return $this->db->query($query)->result_array();
        }

        private function _get_datatables_query_finish()
        {
            $this->db->from($this->table2);
            $this->db->where('status_ccs', 'FINISHED');

            $i = 0;

            foreach ($this->column_search2 as $item) { // Looping untuk setiap field yang di-search
                if ($_POST['search']['value']) {

                    if ($i === 0) {
                        $this->db->group_start(); // Open bracket untuk grouping
                        $this->db->like($item, $_POST['search']['value']);
                    } else {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }

                    if (count($this->column_search2) - 1 == $i) {
                        $this->db->group_end(); // Close bracket
                    }
                }
                $i++;
            }

            if (isset($_POST['order'])) { // Untuk order by berdasarkan request DataTable
                $this->db->order_by($this->column_order2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } else if (isset($this->order2)) {
                $order = $this->order2;
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }

        function get_datatables_finish()
        {
            $this->_get_datatables_query();
            if ($_POST['length'] != -1) {
                $this->db->limit($_POST['length'], $_POST['start']);
            }
            $query = $this->db->get();
            return $query->result_array();
        }

        function count_filtered_finish()
        {
            $this->_get_datatables_query();
            $query = $this->db->get();
            return $query->num_rows();
        }

        function count_all_finish()
        {
            $this->db->from($this->table2);
            $this->db->where('status_ccs', 'FINISHED');
            return $this->db->count_all_results();
        }


        public function getKlien()
        {
            $query = "SELECT nama, COUNT(nama) AS jumlah FROM pelaporan GROUP BY nama ORDER BY jumlah DESC";
            return $this->db->query($query)->result_array();
        }

        public function getKategori()
        {
            $query = "SELECT kategori, COUNT(kategori) AS jumlah FROM pelaporan GROUP BY kategori ORDER BY jumlah DESC";
            return $this->db->query($query)->result_array();
        }

        public function add_forward()
        {
            $user_id = $this->session->userdata('id_user');
            $query = "INSERT INTO forward(user_id, pelaporan_id) select user_id, pelaporan_id FROM forward where user_id = $user_id ";

            $this->db->query($query);
        }

        public function updateForward($id_pelaporan, $nama_user)
        {

            $query = "UPDATE pelaporan SET status_ccs='HANDLE', handle_by = '$nama_user', status='Forward To Helpdesk' WHERE id_pelaporan=$id_pelaporan";
            return $this->db->query($query);
        }

        // 
        public function updateHD($id_pelaporan, $nama_user)
        {

            $query = "UPDATE pelaporan SET status_ccs='HANDLE', handle_by = '$nama_user', status='Forward To Helpdesk'  WHERE id_pelaporan=$id_pelaporan";
            return $this->db->query($query);
        }

        public function updateTeknisi($id_pelaporan, $nama_user)
        {

            $query = "UPDATE pelaporan SET status_ccs='HANDLE 2', handle_by2 = '$nama_user', status='Forward To Teknisi'  WHERE id_pelaporan=$id_pelaporan";
            return $this->db->query($query);
        }

        public function updateHD1($id_pelaporan, $nama_user)
        {

            $query = "UPDATE pelaporan
                SET status_ccs = 'HANDLE', handle_by = '$nama_user'
                FROM pelaporan
                JOIN forward ON pelaporan.id_pelaporan = forward.pelaporan_id
                WHERE pelaporan.id_pelaporan = '$id_pelaporan;";
            return $this->db->query($query);
        }
        public function delete_forward()
        {
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $user_id = $this->session->userdata('id_user');

            $query = "DELETE FROM forward where user_id = $user_id";
            //$query2 = "DELETE FROM barang_temp where user_id = $user_id";
            $this->db->query($query);
        }

        public function updateReject($id_pelaporan, $nama_user)
        {

            $query = "UPDATE pelaporan SET status_ccs='REJECT', status='Return To Helpdesk', handle_by = '$nama_user'  WHERE id_pelaporan=$id_pelaporan";
            return $this->db->query($query);
        }

        public function ambil_id_pelaporan($id)
        {
            $query = "SELECT  id_pelaporan, no_tiket, waktu_pelaporan, perihal, judul, nama, status_ccs, kategori, priority, maxday, impact, tags, catatan_finish, file, file_finish  FROM pelaporan WHERE id_pelaporan='$id'";
            return $this->db->query($query)->result_array();
        }

        public function ambil_id_pelaporan_close($id)
        {
            $query = "SELECT  id_pelaporan, no_tiket, waktu_pelaporan, perihal, judul, nama, status_ccs, kategori, priority, maxday, impact, judul, catatan_finish, file_finish, tags  FROM pelaporan WHERE id_pelaporan='$id'";
            return $this->db->query($query)->result_array();
        }

        public function ambil_comment_id($id)
        {


            $query = "SELECT  user.nama_user, user.id_user,reply.body, reply.pelaporan_id
        FROM reply

        LEFT JOIN comment ON reply.comment_id = comment.id_comment
        LEFT JOIN user ON reply.user_id=user.id_user
        WHERE reply.pelaporan_id ='$id'";

            return $this->db->query($query)->result_array();
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
                    comment.id_comment,
                    comment.created_at
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
                    reply.pelaporan_id,
                    reply.created_at,
                    reply.file
                FROM reply
                LEFT JOIN user ON reply.user_id = user.id_user
                WHERE reply.pelaporan_id = $id
                ORDER BY reply.created_at DESC";

            return $this->db->query($query, array($id))->result_array();
        }

        public function getAllData()
        {

            $this->db->order_by('waktu_pelaporan', 'DESC');
            $query = $this->db->get('pelaporan'); // Assuming 'pelaporan' is the name of your table
            return $query->result(); // Returns an array of object
        }

        public function get_recent_pelaporan()
        {
            $this->db->select('id_pelaporan,no_tiket, judul, waktu_pelaporan, status_ccs, nama');
            $this->db->where('status_ccs', 'ADDED');
            $this->db->order_by('waktu_pelaporan', 'DESC');
            return $this->db->get('pelaporan')->result();
        }


        public function get_notifications()
        {
            $this->db->select('id_pelaporan, no_tiket, judul, nama, waktu_pelaporan, status_ccs');
            $this->db->from('pelaporan');
            $this->db->where('status_ccs', 'ADDED'); // Contoh filter status
            $this->db->order_by('waktu_pelaporan', 'DESC');
            // $this->db->limit(100); // Batasi hasil notifikasi
            $query = $this->db->get();

            return $query->result_array();
        }

        // Menghitung jumlah notifikasi yang belum dibaca
        public function count_unread_notifications()
        {
            $this->db->where('status_ccs', 'ADDED');  // Syarat untuk notifikasi belum dibaca
            return $this->db->count_all_results('pelaporan');
        }
    }
