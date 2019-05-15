<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model("M_config");
		$this->load->library("Scripts_loader", "", "sl");
	}

	function index() {
		$loads = $this->M_config->getLoads(1);
		$loads = $this->parserlib->clearr($loads, "src");

		$data_topo = array("loads" => $this->sl->setScripts($loads));

		$this->load->view("site/topo", $data_topo);
		$this->load->view("site/home");
		$this->load->view("site/fim");
	}
}