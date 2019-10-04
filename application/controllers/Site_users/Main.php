<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model("M_config");
		$this->load->model("M_usuarios_site");
		$this->load->model("M_cupons");
		$this->load->library("Scripts_loader", "", "sl");
	}

	function index()
	{
		if (! $this->M_usuarios_site->isLogged()) {
			return redirect(RAIZ.'login');
		}

		$loads = $this->M_config->getLoads(2);
		$loads = $this->parserlib->clearr($loads, "src");

		$data_topo = array("loads" => $this->sl->setScripts($loads));
		$data_topo['curpage'] = 0;

		$this->load->view("usuarios_site/topo", $data_topo);
		$this->load->view("usuarios_site/home");
		$this->load->view("usuarios_site/fim");
	}

	public function cadastro ()
	{
		if ($this->M_usuarios_site->isLogged()) {
			return redirect(RAIZ.'minhaconta');
		}

		$loads = $this->M_config->getLoads(2);
		$loads = $this->parserlib->clearr($loads, "src");

		$data_topo = array("loads" => $this->sl->setScripts($loads));

		$this->load->view("usuarios_site/topo_cadastro", $data_topo);
		$this->load->view("usuarios_site/cadastro");
		$this->load->view("usuarios_site/fim_cadastro");
	}

	public function cadastrar ()
	{
		if ($this->M_usuarios_site->isLogged()) {
			return redirect(RAIZ.'minhaconta');
		}

		$dados = array(
			'nome' => $this->input->post('nome'),
			'email' => $this->input->post('email'),
			'sexo' => $this->input->post('sexo'),
			'data_nascimento' => $this->input->post('data_nascimento'),
			'telefone' => $this->input->post('telefone'),
			'senha' => $this->input->post('senha'),
			'repita_senha' => $this->input->post('repita_senha')
		);

		$this->form_validation->set_data($dados);
		if ($this->form_validation->run('cadastro_site') == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			return redirect(RAIZ.'cadastro');
		}

		unset($dados['repita_senha']);
		$dados['data_nascimento'] = $this->parserlib->unformatDate($dados['data_nascimento']);
		$dados['telefone'] = $this->parserlib->removeNumMasks($dados['telefone']);
		$dados['sexo'] = !!$dados['sexo'];

		$usuario_criar = $this->M_usuarios_site->createUser($dados);
		if ($usuario_criar == FALSE) {
			$this->session->set_flashdata('error', "<p>Erro ao cadastrar</p>");
			return redirect(RAIZ.'cadastro');
		}

		if ($this->M_cupons->checkAvailable(1)) {
			$this->M_cupons->createCoupon($usuario_criar, 1);
		}

		$this->session->set_flashdata('success', "<p>Cadastro realizado com sucesso! Acesse sua conta abaixo</p>");
		return redirect(RAIZ.'login');
	}

	public function login ()
	{
		if ($this->M_usuarios_site->isLogged()) {
			return redirect(RAIZ.'minhaconta');
		}

		$loads = $this->M_config->getLoads(2);
		$loads = $this->parserlib->clearr($loads, "src");

		$data_topo = array("loads" => $this->sl->setScripts($loads));

		$this->load->view("usuarios_site/topo_login", $data_topo);
		$this->load->view("usuarios_site/login");
		$this->load->view("usuarios_site/fim_login");
	}

	public function logar ()
	{
		if ($this->M_usuarios_site->isLogged()) {
			return redirect(RAIZ.'minhaconta');
		}

		$user = $this->input->post('login');
		$password = $this->input->post('senha');

		if ($user == null || $password == null) {
			return redirect(RAIZ.'login');
		}

		$login = $this->M_usuarios_site->login($user, $password);

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
			return redirect(RAIZ.'login');
		}

		return redirect(RAIZ.'minhaconta');
	}

	public function logout ($site=0)
	{
		$this->M_usuarios_site->logout();

		if ($site) {
			return redirect(RAIZ);
		}
		
		return redirect(RAIZ.'login');
	}

	public function minhaconta ()
	{
		if (! $this->M_usuarios_site->isLogged()) {
			return redirect(RAIZ.'login');
		}

		$loads = $this->M_config->getLoads(2);
		$loads = $this->parserlib->clearr($loads, "src");

		$data_topo = array("loads" => $this->sl->setScripts($loads));

		$cupons = $this->M_cupons->getCoupon(array('id_usuario' => $this->session->userdata('id_usuario')));

		$page_data = array('cupons' => $cupons);

		$this->load->view("usuarios_site/topo", $data_topo);
		$this->load->view("usuarios_site/minhaconta", $page_data);
		$this->load->view("usuarios_site/fim");
	}

}