<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Development extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/development_sidebar');
        $this->load->view('development/dashboard');
        $this->load->view('templates/footer');
    }

}