<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Criteria extends CI_Controller
{
	//membuat atribut alert 
	private $alert = '';

	public $js_default = 'js_datatable';
	public $css_default = 'css_datatable';

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('CriteriaModel');
		if (empty($this->session->userdata("id"))) {
			redirect('login/index');
		}
	}

	private function alert($open_tag = null, $close_tag = null, $data = null)
	{
		//buat nampilin alert
		if ($data != null) $data = $open_tag . $data . $close_tag;

		return $data;
		//contoh : $this->alert('<h1>','</h1>','Hello world'); Output : <h1>Hello World</h1>
	}

	private function template($content, $data = null)
	{
		$data['user_name'] = $this->session->userdata("name");
		$data['content'] = $this->load->view($content, $data, true);

		$this->load->view('template', $data);
	}

	public function index()
	{
		$data_save = $this->session->flashdata('data');
		if (!empty($data_save)) {
			$data['criteria_save'] = $data_save;
		}
		$data['criterias'] = $this->CriteriaModel->all();
		$this->template('criteria/list', $data);
	}

	public function form()
	{
		if ($this->input->post('save')) {
			$post_data = array(
				'name' => $this->input->post('name'),
				'weight' => $this->input->post('weight'),
				'type' => $this->input->post('type'),
				'description' => $this->input->post('description'),
			);

			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('weight', 'Bobot', 'required');

			if ($this->form_validation->run()) {
				if ($this->input->post('id') == '') {
					// Kalau ga ada id insert data
					$post_data['created_at'] = date('Y-m-d H:i:s');
					$post_data['updated_at'] = date('Y-m-d H:i:s');

					if ($this->CriteriaModel->insert($post_data)) {
						// Kalau sukses
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data kriteria berhasil disimpan..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('criteria');
					} else {
						// Kalau gagal
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal menyimpan data kriteria..");
					}
				} else {
					// Kalau ada id update data
					$post_data['updated_at'] = date('Y-m-d H:i:s');
					if (!empty($this->input->post('password'))) {
						$post_data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
					}

					if ($this->CriteriaModel->update($post_data, array('id' => $this->input->post('id')))) {
						// Kalau sukses
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data kriteria berhasil diupdate..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('criteria');
					} else {
						// Kalau gagal
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal mengupdate data kriteria..");
					}
				}
			} else {
				$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal validasi..");
			}

		}

		$type = array(
			'1' => 'Benefit',
			'2' => 'Cost',
		);

		$data = array(
			'data' => $this->CriteriaModel->getWhere(array('id' => $this->uri->segment(3)))->row_array(),
			'alert' => $this->alert,
			'type' => $type
		);

		$this->template('criteria/form', $data);
	}

	public function delete()
	{
		if ($this->uri->segment(3)) {
			if ($this->CriteriaModel->delete(array('id' => $this->uri->segment(3)))) {
				$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data kriteria berhasil dihapus..");

				$data = array(
					'alert' => $this->alert,
				);
				$this->session->set_flashdata('data', $data);

				redirect('criteria');
			}
		}
	}
}
