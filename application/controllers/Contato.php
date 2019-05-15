<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contato extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model("M_config");
		$this->load->library("parserlib");
		$this->load->library("Scripts_loader", "", "sl");
	}

	function index() {
		$loads = $this->M_config->getLoads(1);
		$loads = $this->parserlib->clearr($loads, "src");
		$site = array("loads" => $this->sl->setScripts($loads));

		$this->load->view("site/contato", $site);
	}

}