<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SubCriteria extends CI_Controller
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
		$this->load->model('SubCriteriaModel');
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
		$criteria_id = isset($_REQUEST["criteria_id"]) ? $_REQUEST["criteria_id"] : "";

		$data_save = $this->session->flashdata('data');
		if (!empty($data_save)) {
			$data['sub_criteria_save'] = $data_save;
		}
		$data['criterias'] = $this->CriteriaModel->getActiveCriteria();
		$data['sub_criterias'] = $this->SubCriteriaModel->all($criteria_id);
		$this->template('sub-criteria/list', $data);
	}

	public function form()
	{
		if ($this->input->post('save')) {
			$post_data = array(
				'criteria_id' => $this->input->post('criteria_id'),
				'name' => $this->input->post('name'),
				'point' => $this->input->post('point'),
			);

			$this->form_validation->set_rules('criteria_id', 'Kriteria', 'required');
			$this->form_validation->set_rules('name', 'Keterangan', 'required');
			$this->form_validation->set_rules('point', 'Nilai', 'required');

			if ($this->form_validation->run()) {
				if ($this->input->post('id') == '') {
					// Kalau ga ada id insert data
					$post_data['created_at'] = date('Y-m-d H:i:s');
					$post_data['updated_at'] = date('Y-m-d H:i:s');

					if ($this->SubCriteriaModel->insert($post_data)) {
						// Kalau sukses
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Nilai crips berhasil disimpan..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('subcriteria');
					} else {
						// Kalau gagal
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal menyimpan nilai crips..");
					}
				} else {
					// Kalau ada id update data
					$post_data['updated_at'] = date('Y-m-d H:i:s');

					if ($this->SubCriteriaModel->update($post_data, array('id' => $this->input->post('id')))) {
						// Kalau sukses
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Nilai crips berhasil diupdate..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('subcriteria');
					} else {
						// Kalau gagal
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal mengupdate nilai crips..");
					}
				}
			} else {
				$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal validasi..");
			}

		}

		$criterias = $this->CriteriaModel->getActiveCriteria();

		$data = array(
			'data' => $this->SubCriteriaModel->getWhere(array('id' => $this->uri->segment(3)))->row_array(),
			'alert' => $this->alert,
			'criterias' => $criterias
		);

		$this->template('sub-criteria/form', $data);
	}

	public function delete()
	{
		if ($this->uri->segment(3)) {
			if ($this->SubCriteriaModel->delete(array('id' => $this->uri->segment(3)))) {
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
