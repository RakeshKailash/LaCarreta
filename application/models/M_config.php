<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_config extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function getLoads($place=4)
	{
		$where = $place == 4 ? "" : "place = '{$place}' OR place = '3'";
		$this->db->select("src");
		$this->db->where($where);

		$result = $this->db->get("loadfiles")->result_array();
		return $result;
	}

}