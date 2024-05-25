<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin_model extends CI_Model {

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
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, maxday, handle_by, keterangan, maxday, handle_by2, handle_by3, impact, tags  FROM pelaporan WHERE status_ccs='CLOSE' ORDER BY waktu_pelaporan DESC";
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

}
