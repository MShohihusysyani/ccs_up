<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usermaster_model extends CI_Model
{
    public function getUser()
    {
        $query = "SELECT *
                    FROM user
                    ";
        return $this->db->query($query)->result_array();
    }

    public function hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user');
    }

    function updateUser($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('user', $data);
    }


}