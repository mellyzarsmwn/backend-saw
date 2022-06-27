<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Defaults extends CI_Controller
{

	public $js_default = 'js_dashboard';

	public $css_default = 'css_dashboard';

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->model('SalaryReportModel');

		if (empty($this->session->userdata("id"))) {
			redirect('login/index');
		}
	}

	public function index()
	{
		//load method template
		$data['user_name'] = $this->session->userdata("name");
		$this->template('defaults/index', $data);
	}

	private function template($content, $data = null)
	{
		//method ini digunakan untuk memanggil template yang telah dibuat
		// untuk dapat digunakan pada method lainnya
		//parameter $content = lokasi file view pada folder View
		//parameter $data = data yang akan dimasukkan ke file view

		$data['user_name'] = $this->session->userdata("name");
		$data['access'] = $this->session->userdata("access");
		$data['content'] = $this->load->view($content, $data, true);

		$this->load->view('template', $data);
	}
}
