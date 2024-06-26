 <?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Supervisor_model extends CI_Model
    {

        private $table = 'pelaporan';
        private $column_order = array(null, 'no_tiket', 'waktu_pelaporan', 'nama', 'perihal', 'impact', 'file', 'kategori', 'tags', 'priority', 'maxday', 'status_ccs', 'handle_by', 'handle_by2', 'handle_by3');
        private $column_search = array('no_tiket', 'waktu_pelaporan', 'nama', 'perihal', 'impact', 'file', 'kategori', 'tags', 'priority', 'maxday', 'status_ccs', 'handle_by', 'handle_by2', 'handle_by3');
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
            $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, judul, waktu_pelaporan, status_ccs, file, status, no_tiket, priority,maxday, handle_by, impact, handle_by2, handle_by3, tags  FROM pelaporan WHERE status_ccs='HANDLE' OR status_ccs='HANDLE 2' OR status_ccs='ADDED 2'  ORDER BY waktu_pelaporan DESC";
            return $this->db->query($query)->result_array();
        }

        //CLOSE
        public function getKlienPelaporanClose()
        {
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $user_id = $this->session->userdata('id_user');
            $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, judul, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, maxday, handle_by, maxday, handle_by2, handle_by3, impact, tags  FROM pelaporan WHERE status_ccs='CLOSE' ORDER BY waktu_pelaporan DESC";
            return $this->db->query($query)->result_array();
        }

        //FINISH
        public function getKlienPelaporanFinish()
        {
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $user_id = $this->session->userdata('id_user');
            $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, judul, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, handle_by, maxday, waktu_approve, handle_by2, handle_by3, impact, tags, rating  FROM pelaporan WHERE status_ccs='FINISH' ORDER BY waktu_pelaporan DESC";
            return $this->db->query($query)->result_array();
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
            $query = "SELECT  id_pelaporan, no_tiket, waktu_pelaporan, perihal, judul, nama, status_ccs, kategori, priority, maxday, impact, file  FROM pelaporan WHERE id_pelaporan='$id'";
            return $this->db->query($query)->result_array();
        }

        public function ambil_id_pelaporan_close($id)
        {
            $query = "SELECT  id_pelaporan, no_tiket, waktu_pelaporan, perihal, judul, nama, status_ccs, kategori, priority, maxday, impact, judul, catatan_finish, file_finish, tags  FROM pelaporan WHERE id_pelaporan='$id'";
            return $this->db->query($query)->result_array();
        }

        // public function ambil_id_comment($id){
        //     $this->db->select('*');
        //     $this->db->from('comment');
        //     $this->db->where('pelaporan_id', $id);
        //     return $this->db->get()->result();
        // }

        // public function ambil_id_comment($id){

        //     $query = "SELECT  user.nama_user, user.id_user, comment.body, comment.pelaporan_id, comment.id_comment, comment.file
        //     FROM comment
        //     LEFT JOIN user ON comment.user_id=user.id_user
        //     WHERE comment.pelaporan_id='$id'";

        //     return $this->db->query($query)->result_array();
        // }

        // public function ambil_comment_id($id){


        //     $query = "SELECT  user.nama_user, user.id_user, comment.body, comment.pelaporan_id,  comment.file, comment.comment_id
        //     FROM comment
        //     LEFT JOIN user ON comment.user_id=user.id_user
        //     WHERE comment.comment_id='$id'";

        //     return $this->db->query($query)->result_array();
        // }

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
    }
