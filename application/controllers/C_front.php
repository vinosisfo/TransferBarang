<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_front extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_admin');
		$this->load->library('pdf');
	}

	public function index()
	{

		$this->load->view('template/css/css');
		$this->load->view('template/menu_bar/menu_top_front');
		
		$this->load->view('pages/front/body');

		$this->load->view('template/menu_bar/footer_front');
		$this->load->view('template/js/js');

	}
}
