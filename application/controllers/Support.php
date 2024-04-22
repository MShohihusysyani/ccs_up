<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Support extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
      
    }

    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/support_sidebar');
        $this->load->view('support/dashboard');
        $this->load->view('templates/footer');
    }

}