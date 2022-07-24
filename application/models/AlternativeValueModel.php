<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AlternativeValueModel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function all($start_date = "", $end_date = "", $period_id = "", $alternative_name = "")
	{
		$where = "av.deleted_at is null ";
		if ($start_date && $end_date != "") {
			$where .= "AND 
					DATE(av.created_at) BETWEEN '$start_date' AND '$end_date' ";
		}
		if ($alternative_name != "") {
			$where .= "AND a.name like '%$alternative_name%'";
		}
		if ($period_id != "") {
			$where .= "AND av.period_id = $alternative_name";
		}

		return $this->db->select('av.*, a.name `alternative_name`, u.name `user_name`, p.name `period_name`')
			->join('alternative a', 'a.id = av.alternative_id')
			->join('users u', 'u.id = av.user_id')
			->join('period p', 'p.id = av.period_id')
			->where($where)
			->order_by('av.id desc')
			->get('alternative_value av');
	}

	public function getWhere($where)
	{
		$this->db->where($where);
		return $this->db->get('alternative_value');
	}

	public function insert($data)
	{
		return $this->db->insert('alternative_value', $data);
	}

	public function update($data, $where)
	{
		$this->db->where($where);
		return $this->db->update('alternative_value', $data);
	}

	public function delete($where)
	{
		$data = array(
			'deleted_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		);

		$this->db->where($where);
		return $this->db->update('alternative_value', $data);
	}
}
