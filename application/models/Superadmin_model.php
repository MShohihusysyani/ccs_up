<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin_model extends CI_Model {

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

        foreach ($this->column_search as $item)
        {
            if($_POST['search']['value'])
            {
                if($i===0)
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
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
        // $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        // $user_id = $this->session->userdata('id_user');
        // $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, handle_by, impact, maxday, handle_by2, handle_by3, tags  FROM pelaporan ORDER BY waktu_pelaporan DESC";
        // return $this->db->query($query)->result_array();

        // Fetch user data from the session
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
    
        // Ensure the user is retrieved
        if ($data['user']) {
        // User ID from session
        $user_id = $this->session->userdata('id_user');

        // SQL query to retrieve reports
        $query = "
            SELECT DISTINCT
                nama, 
                id_pelaporan, 
                user_id, 
                kategori, 
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

        // Execute the query and return the result as an array
        $result = $this->db->query($query);

        // Check for query execution errors
        if ($result) {
            return $result->result_array();
        } else {
            // Handle the error appropriately (e.g., log the error, return a message)
            log_message('error', 'Query failed: ' . $this->db->last_query());
            return []; // Return an empty array or handle as needed
        }
    } else {
        // Handle case when user data is not found
        log_message('error', 'User not found in session.');
        return []; // Return an empty array or handle as needed
    }
    }

     //ADDED
    public function getKlienPelaporanAdd()
    {
        // $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        // $user_id = $this->session->userdata('id_user');
        // $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, maxday, handle_by, tags  FROM pelaporan WHERE status_ccs='ADDED' ORDER BY waktu_pelaporan DESC";
        // return $this->db->query($query)->result_array();

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
                perihal, 
                waktu_pelaporan, 
                status_ccs, 
                file, 
                status, 
                no_tiket, 
                priority, 
                maxday, 
                handle_by, 
                tags
            FROM 
                pelaporan 
            WHERE 
                status_ccs = 'ADDED' 
            ORDER BY 
                waktu_pelaporan DESC
        ";

        // Execute the query and return the result as an array
        $result = $this->db->query($query);

        // Check for query execution errors
        if ($result) {
            return $result->result_array();
        } else {
            // Handle the error appropriately (e.g., log the error, return a message)
            log_message('error', 'Query failed: ' . $this->db->last_query());
            return []; // Return an empty array or handle as needed
        }
    } else {
        // Handle case when user data is not found
        log_message('error', 'User not found in session.');
        return []; // Return an empty array or handle as needed
    }
    }

    //ON PROGRESS/HANDLE
    public function getKlienPelaporanOP()
    {
        // $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        // $user_id = $this->session->userdata('id_user');
        // $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority,maxday, handle_by, impact, handle_by2, handle_by3, tags  FROM pelaporan WHERE status_ccs='HANDLE' OR status_ccs='HANDLE 2' OR status_ccs='ADDED 2'  ORDER BY waktu_pelaporan DESC";
        // return $this->db->query($query)->result_array();

        // Fetch user data from the session
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        // Ensure the user is retrieved
        if ($data['user']) {
        // User ID from session
        $user_id = $this->session->userdata('id_user');

        // SQL query to retrieve reports with status_ccs='HANDLE', 'HANDLE 2', or 'ADDED 2'
        $query = "
            SELECT DISTINCT
                nama, 
                id_pelaporan, 
                user_id, 
                kategori, 
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
                status_ccs IN ('HANDLE', 'HANDLE 2', 'ADDED 2') 
            ORDER BY 
                waktu_pelaporan DESC
        ";

        // Execute the query and return the result as an array
        $result = $this->db->query($query);

        // Check for query execution errors
        if ($result) {
            return $result->result_array();
        } else {
            // Handle the error appropriately (e.g., log the error, return a message)
            log_message('error', 'Query failed: ' . $this->db->last_query());
            return []; // Return an empty array or handle as needed
        }
    } else {
        // Handle case when user data is not found
        log_message('error', 'User not found in session.');
        return []; // Return an empty array or handle as needed
    }
    }

    //CLOSE
    public function getKlienPelaporanClose()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, maxday, handle_by, maxday, handle_by2, handle_by3, impact, tags  FROM pelaporan WHERE status_ccs='CLOSE' ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    //FINISH
    public function getKlienPelaporanFinish()
    {
        // $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        // $user_id = $this->session->userdata('id_user');
        // $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, handle_by, maxday, waktu_approve, handle_by2, handle_by3, impact, tags  FROM pelaporan WHERE status_ccs='FINISH' ORDER BY waktu_pelaporan DESC";
        // return $this->db->query($query)->result_array();

        // Fetch user data from the session
    $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

    // Ensure the user is retrieved
    if ($data['user']) {
        // User ID from session
        $user_id = $this->session->userdata('id_user');

        // SQL query to retrieve reports with status_ccs='FINISH'
        $query = "
            SELECT DISTINCT
                nama, 
                id_pelaporan, 
                user_id, 
                kategori, 
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
                tags
            FROM 
                pelaporan 
            WHERE 
                status_ccs = 'FINISH' 
            ORDER BY 
                waktu_pelaporan DESC
        ";

        // Execute the query and return the result as an array
        $result = $this->db->query($query);

        // Check for query execution errors
        if ($result) {
            return $result->result_array();
        } else {
            // Handle the error appropriately (e.g., log the error, return a message)
            log_message('error', 'Query failed: ' . $this->db->last_query());
            return []; // Return an empty array or handle as needed
        }
    } else {
        // Handle case when user data is not found
        log_message('error', 'User not found in session.');
        return []; // Return an empty array or handle as needed
    }
    }

    public function getAllData(){

        $this->db->order_by('waktu_pelaporan', 'DESC');
        $query = $this->db->get('pelaporan'); // Assuming 'pelaporan' is the name of your table
        return $query->result(); // Returns an array of object
    }

    public function ambil_id_pelaporan($id)
    { 
        $query = "SELECT  id_pelaporan, no_tiket, waktu_pelaporan, perihal, nama, status_ccs, kategori, priority, maxday, impact, file  FROM pelaporan WHERE id_pelaporan='$id'";
        return $this->db->query($query)->result_array();
    }

    public function ambil_id_comment($id){

        $query = "SELECT  user.nama_user, user.id_user, comment.body, comment.pelaporan_id, comment.id_comment, comment.file
        FROM comment
        LEFT JOIN user ON comment.user_id=user.id_user
        WHERE comment.pelaporan_id='$id'";

        return $this->db->query($query)->result_array();
    }

    public function ambil_id_comment2($id){
        
        $this->db->select('user.nama_user, user.id_user, comment.body, comment.pelaporan_id, comment.id_comment, comment.file');
        $this->db->from('comment');
        $this->db->join('user', 'comment.user_id = user.id_user', 'left');
        $this->db->where('comment.pelaporan_id', $id);

    }

    public function get_latest_comments($id) {
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

    public function get_replies_by_pelaporan_id($id) {
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

    
    public function getPelaporanById($id_pelaporan)
    {
        $this->db->where('id_pelaporan', $id_pelaporan);
        $query = $this->db->get('pelaporan'); // Replace 'pelaporan' with your actual table name
        return $query->row_array();
    }

    public function getTicketDetail($no_tiket)
{
    $this->db->select('*');
    $this->db->from('pelaporan');
    $this->db->where('no_tiket', $no_tiket);
    $query = $this->db->get();
    return $query->row();
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
