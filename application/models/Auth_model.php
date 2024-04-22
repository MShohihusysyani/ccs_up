<?php
defined('BASEPATH') or exit('No direct script access allowed');

class auth_model extends CI_Model
{
    public function getUser()
    {
        $query = "SELECT *
                    FROM user
                    ";
        return $this->db->query($query)->result_array();
    }

    public function logout($date, $id)
{
    $this->db->where($this->id, $id);
    $this->db->update($this->table, $date);
    
}

}