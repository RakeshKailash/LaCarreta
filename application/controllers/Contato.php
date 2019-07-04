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

	function enviar()
	{
		$this->load->config('email');
        $config = array(
		    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
		    'smtp_host' => 'smtp.hostinger.com', 
		    'smtp_port' => 587,
		    'smtp_user' => 'formulario@lacarretapanchos.com.br',
		    'smtp_pass' => 'cNo8xH!;l=~C#oIN;x',
		    'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
		    'mailtype' => 'html', //plaintext 'text' mails or 'html'
		    'smtp_timeout' => '10', //in seconds
		    'charset' => 'utf-8',
		    'wordwrap' => TRUE
		);

        $this->load->library('email', $config);
        $from = $this->config->item('smtp_user');
        $to = $this->config->item('to');
        $subject = "Nova mensagem | ".$this->input->post('nome');
        $message = $this->load->view('site/email', $_POST, true);

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to('contato@lacarretapanchos.com.br');
        $this->email->subject($subject);
        $this->email->message($message);
        // $this->email->smtp_auth(TRUE);

        if ($this->email->send()) {
            $this->session->set_flashdata('success', "Mensagem enviada com sucesso!");
        } else {
            $this->session->set_flashdata('error', "Erro a enviar sua mensagem");
        }

        redirect(RAIZ.'#secao_contato');
	}

}