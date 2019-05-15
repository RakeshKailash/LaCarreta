<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model("m_config");
		$this->load->library("Parserlib");
		$this->load->library("Scripts_loader", "", "sl");
	}

	function index() {
		// $loads = $this->m_config->getLoads(1);
		// $loads = $this->parserlib->clearr($loads, "src");
		// $site = array("loads" => $this->sl->setScripts($loads));

		// $this->load->view("site/home", $site);
	}
}