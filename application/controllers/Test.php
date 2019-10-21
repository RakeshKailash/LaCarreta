<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model("m_config");
		$this->load->model("M_cupons");
		$this->load->library("Parserlib");
		$this->load->library("Scripts_loader", "", "sl");
	}

	function index() {
		
	}
}