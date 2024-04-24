<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function getUser()
    {
        $this->session->userdata('username');
        $query = "SELECT id_user, divisi, nama_klien
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
                    WHERE id_user= '$id'
                    ";
        return $this->db->query($query)->result_array();
    }

    public function getNamaUser(){

        $query = "SELECT id_user, nama_user FROM user WHERE divisi='Helpdesk 1' OR divisi='Helpdesk 2' OR divisi='Helpdesk 3' OR divisi='Helpdesk 4' ORDER by nama_user ASC";
        return $this->db->query($query)->result_array();
    }

    public function getNamaSpv(){

        $query = "SELECT id_user, nama_user FROM user WHERE divisi='Supervisor 2' ORDER by nama_user ASC";
        return $this->db->query($query)->result_array();
    }

    public function getNamaTeknisi(){

        $query = "SELECT id_user, nama_user FROM user WHERE divisi='Support' OR divisi='Implementator' ORDER by nama_user ASC";
        return $this->db->query($query)->result_array();
    }

    function updateUser($id, $data)
    {
        $this->db->where('id_user', $id);
        $this->db->update('user', $data);
    }

    public function deleteUser($id)
    {
        $this->db->where('id_user', $id);
        $this->db->delete('user');
    }
}