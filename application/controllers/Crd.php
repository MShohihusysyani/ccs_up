<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Crd extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/crd_sidebar');
        $this->load->view('crd/dashboard');
        $this->load->view('templates/footer');
    }

}