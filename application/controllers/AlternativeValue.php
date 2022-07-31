<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AlternativeValue extends CI_Controller
{

	public $js_default = 'js_datatable';

	public $css_default = 'css_datatable';


	private $alert = '';

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('AlternativeValueModel');
		$this->load->model('AlternativeValueDetailModel');
		$this->load->model('AlternativeModel');
		$this->load->model('PeriodModel');
		$this->load->model('CriteriaModel');
		$this->load->model('SubCriteriaModel');
		if (empty($this->session->userdata("id"))) {
			redirect('login/index');
		}
	}

	private function alert($open_tag = null, $close_tag = null, $data = null)
	{
		if ($data != null) $data = $open_tag . $data . $close_tag;
		return $data;
	}


	private function template($content, $data = null)
	{
		$data['user_name'] = $this->session->userdata("name");
		$data['content'] = $this->load->view($content, $data, true);
		$data['access'] = $this->session->userdata("access");

		$this->load->view('template', $data);
	}

	public function index()
	{
		$start_date = isset($_REQUEST["start_date"]) ? $_REQUEST["start_date"] : "";
		$end_date = isset($_REQUEST["end_date"]) ? $_REQUEST["end_date"] : "";
		$period_id = isset($_REQUEST["period_id"]) ? $_REQUEST["period_id"] : "";
		$alternative_name = isset($_REQUEST["alternative_name"]) ? $_REQUEST["alternative_name"] : "";

		$user_data_save = $this->session->flashdata('data');
		if (!empty($user_data_save)) {
			$data['user_save'] = $user_data_save;
		}

		$data['alternative_values'] = $this->AlternativeValueModel->all($start_date, $end_date, $period_id, $alternative_name);
		$data['periods'] = $this->PeriodModel->getActivePeriod();
		$this->template('alternative-value/list', $data);
	}

	public function get_detail_json()
	{
		header('Content-Type: application/json');

		$alternative_value_id = $this->input->get('id');
		$period_id = $this->input->get('period_id');

		$alternative_value = $this->AlternativeValueModel->get_detail($alternative_value_id, $period_id)->row();
		$alternative_value_detail = $this->AlternativeValueDetailModel->getWhere(array('alternative_value_id' => $alternative_value_id))->row();
		$data_array = array(
			'alternative_value' => $alternative_value,
			'alternative_value_detail' => $alternative_value_detail,
		);

		$data_json = json_encode($data_array);
		echo $data_json;
	}

	public function form()
	{
		if ($this->input->post('save')) {
			$post_data = array(
				'period_id' => $this->input->post('period_id'),
				'alternative_id' => $this->input->post('alternative_id'),
				'criteria_ids' => $this->input->post('criteria_ids'),
				'sub_criteria_ids' => $this->input->post('sub_criteria_ids'),
			);

			$this->form_validation->set_rules('period_id', 'Periode', 'required');
			$this->form_validation->set_rules('alternative_id', 'Alternatif', 'required');
//			$this->form_validation->set_rules('sub_criteria_id', 'Kriteria', 'required');
			if ($this->form_validation->run()) {
				if ($this->input->post('id') == '') {
					$period_detail = $this->PeriodModel->getWhere(array('id' => $post_data['period_id']))->result();
					$alternative_value_insert = array(
						'user_id' => $this->session->userdata('id'),
						'alternative_id' => $post_data['alternative_id'],
						'period_id' => $post_data['period_id'],
						'period_name' => empty($period_detail[0]->name) ? '' : $period_detail[0]->name,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),

					);
					$alternative_value_id = $this->AlternativeValueModel->insert($alternative_value_insert);
					if (!empty($alternative_value_id) || $alternative_value_id != 0 || $alternative_value_id != "") {
						foreach ($post_data['criteria_ids'] as $key => $value) {
							if ($value) {
								$criteria_detail = $this->CriteriaModel->getWhere(array('id' => $value))->result();
								$sub_criteria_detail = $this->SubCriteriaModel->getWhere(array('id' => $post_data['sub_criteria_ids'][$key]))->result();
								$alternative_value_detail_insert = array(
									'alternative_value_id ' => $alternative_value_id,
									'criteria_id' => $value,
									'criteria_name' => empty($criteria_detail[0]->name) ? '' : $criteria_detail[0]->name,
									'weight_criteria' => empty($criteria_detail[0]->weight) ? 0 : $criteria_detail[0]->weight,
									'sub_criteria_id' => empty($post_data['sub_criteria_ids'][$key]) ? null : $post_data['sub_criteria_ids'][$key],
									'sub_criteria_name' => empty($sub_criteria_detail[0]->name) ? '' : $sub_criteria_detail[0]->name,
									'point_sub_criteria' => empty($sub_criteria_detail[0]->point) ? '' : $sub_criteria_detail[0]->point,
									'created_at' => date('Y-m-d H:i:s'),
									'updated_at' => date('Y-m-d H:i:s'),

								);
								if (!$this->AlternativeValueDetailModel->insert($alternative_value_detail_insert)) {
									$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal menyimpan Nilai Alternatif..");

									$data = array(
										'alert' => $this->alert,
									);
									$this->session->set_flashdata('data', $data);
									redirect('alternativevalue');
								}
							}
						}
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Nilai Alternatif berhasil disimpan..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('alternativevalue');
					} else {
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal menyimpan Nilai Alternatif...");
					}
				}
			} else {
				$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal validasi..");
			}

		}

		$data = array(
			'criterias' => $this->CriteriaModel->getActiveCriteriaWithSubCriteria(),
			'alternative' => $this->AlternativeModel->getActiveAlternative(),
			'period' => $this->PeriodModel->getActivePeriod(),
			'data' => $this->AlternativeValueModel->getWhere(array('id' => $this->uri->segment(3)))->row_array(),
			'alert' => $this->alert,
		);

		$this->template('alternative-value/form', $data);
	}

	public function delete()
	{
		if ($this->uri->segment(3)) {
			$this->AlternativeValueModel->delete(array('id' => $this->uri->segment(3)));
			$this->AlternativeValueDetailModel->delete(array('alternative_value_id' => $this->uri->segment(3)));

			$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data nilai alternatif berhasil dihapus..");
			$data = array(
				'alert' => $this->alert,
			);
			$this->session->set_flashdata('data', $data);
			redirect('alternativevalue');
		}
	}
}

