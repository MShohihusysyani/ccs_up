<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function getUser()
    {
        $this->session->userdata('username');
        $query = "SELECT id, divisi, nama_klien
                    FROM user
                    WHERE username= 'username'
                    ";
        return $this->db->query($query)->result_array();
    }

    public function getDataUser()
    {
        $query = "SELECT *
                    FROM user
                    ";
        return $this->db->query($query)->result_array();
    }

    public function getUserDetail($id)
    {

        $query = "SELECT *
                    FROM user
                    WHERE id= '$id'
                    ";
        return $this->db->query($query)->result_array();
    }

    public function getNamaUser(){

        $query = "SELECT id, nama FROM user WHERE divisi='Helpdesk 1' OR divisi='Helpdesk 2' OR divisi='Helpdesk 3' OR divisi='Helpdesk 4' ";
        return $this->db->query($query)->result_array();
    }

    function updateUser($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('user', $data);
    }

    public function deleteUser($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user');
    }
}