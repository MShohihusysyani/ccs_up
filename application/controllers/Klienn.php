<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Klienn extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('M_klien');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $siswa = $this->M_Klien->get_all();

        $response = array();

        foreach($siswa->result() as $hasil) {

            $response[] = array(
                'nama_klien' => $hasil->nama_klien
            );

        }
        
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'success' => true,
                'message' => 'Get All Data Klien',
                'data'    => $response  
            )
        );
}

}