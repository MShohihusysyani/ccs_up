<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Maintinance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('errors/under_maintinance');
    }
}
