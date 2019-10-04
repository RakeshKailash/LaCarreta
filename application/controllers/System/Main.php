<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model("M_config");
		$this->load->model("M_usuarios");
		$this->load->model("M_cupons");
		// $this->load->library("parserlib");
		$this->load->library("Scripts_loader", "", "sl");
	}

	function index()
	{
		if (! $this->M_usuarios->isLogged()) {
			return redirect(RAIZ.'sistema/login');
		}

		$loads = $this->M_config->getLoads(2);
		$loads = $this->parserlib->clearr($loads, "src");

		$data_topo = array("loads" => $this->sl->setScripts($loads));
		$data_topo['curpage'] = 0;

		$cupons = $this->M_cupons->getCoupon();

		$page_data = array('cupons' => $cupons);

		$this->load->view("sistema/topo", $data_topo);
		$this->load->view("sistema/home", $page_data);
		$this->load->view("sistema/fim");
	}

	public function login ()
	{
		if ($this->M_usuarios->isLogged()) {
			return redirect(RAIZ.'sistema');
		}

		$loads = $this->M_config->getLoads(2);
		$loads = $this->parserlib->clearr($loads, "src");

		$data_topo = array("loads" => $this->sl->setScripts($loads));

		$this->load->view("sistema/topo_login", $data_topo);
		$this->load->view("sistema/login");
		$this->load->view("sistema/fim_login");
	}

	public function logar ()
	{
		if ($this->M_usuarios->isLogged()) {
			return redirect(RAIZ.'sistema');
		}

		$user = $this->input->post('login');
		$password = $this->input->post('senha');

		if ($user == null || $password == null) {
			return redirect(RAIZ.'sistema/login');
		}

		$login = $this->M_usuarios->login($user, $password);

		if (isset($login['error'])) {
			$message = "Erro";

			switch ($login['error']) {
				case 1:
				$message = "Usuário não encontrado";
				break;
				case 2:
				$message = "A Senha digitada está incorreta";
				break;
				default:
				$message = "Erro desconhecido, tente novamente";
				break;
			}

			$this->session->set_flashdata('error', "<p>".$message."</p>");
			return redirect(RAIZ.'sistema/login');
		}

		return redirect(RAIZ.'sistema');
	}

	public function logout ($site=0)
	{
		$this->M_usuarios->logout();

		if ($site) {
			return redirect(RAIZ);
		}
		
		return redirect(RAIZ.'sistema/login');
	}

	function usecoupon($coupon_id=null)
	{
		if (! $this->M_usuarios->isLogged()) {
			return redirect(RAIZ.'sistema/login');
		}

		if (!$coupon_id) {
			return false;
		}

		return $this->M_cupons->markUsed($coupon_id);
	}

	function findcoupon($coupon_code=null)
	{
		if (! $this->M_usuarios->isLogged()) {
			return redirect(RAIZ.'sistema/login');
		}

		$retorno = array(
				'status' => 0,
				'cupom' => array()
		);

		if (!$coupon_code) {
			echo json_encode((object)$retorno);
			return;
		}

		$cupom = $this->M_cupons->getCoupon(array('codigo' => $coupon_code));

		if (!$cupom) {
			$retorno = array(
				'status' => 1,
				'cupom' => ''
			);
			echo json_encode((object)$retorno);
			return;
		}

		if (count($cupom) > 0) {
			$cupom[0]->data_utilizado = $this->parserlib->formatDatetime($cupom[0]->data_utilizado);
			$cupom[0]->data_geracao = $this->parserlib->formatDatetime($cupom[0]->data_geracao);
			$retorno = array(
				'status' => 1,
				'cupom' => $cupom[0]
			);
		}
		echo json_encode((object)$retorno);
		return;
	}

}