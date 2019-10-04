	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class M_cupons extends CI_Model {
		function __construct() {
			parent::__construct();
			$this->load->database();
			$this->load->library('session');
		}

	public function getCoupon ($opts=array())
	{
		$this->db->select("cupons.id_cupom, cupons.id_usuario, cupons.data_geracao, cupons.codigo, cupons.utilizado, cupons.tipo, cupons.data_utilizado");

		if (isset($opts['id'])) {
			$this->db->where('cupons.id_cupom', $opts['id']);
		}

		if (isset($opts['id_usuario'])) {
			$this->db->where('cupons.id_usuario', $opts['id_usuario']);
		}

		if (isset($opts['codigo'])) {
			$this->db->where('cupons.codigo', $opts['codigo']);
		}

		$this->db->order_by("utilizado", "asc");
		$this->db->order_by("data_geracao", "desc");
		$result = $this->db->get('cupons')->result();

		foreach ($result as &$cupom) {
			$this->db->select('nome_tipo');
			$this->db->where('id_tipo', $cupom->tipo);
			$tipo = $this->db->get('tipos_cupons')->result()[0];
			$cupom->nome = $tipo->nome_tipo;

			$this->db->select('nome');
			$this->db->where('id_usuario', $cupom->id_usuario);
			$usuario = $this->db->get('usuarios_site')->result()[0];
			$cupom->nome_usuario = $usuario->nome;
		}
		return $result;
	}

	function markUsed($couponId=null)
	{
		if (!$couponId) {
			return false;
		}

		date_default_timezone_set('America/Sao_Paulo');
		$this->db->where('id_cupom', $couponId);
		$this->db->set(array(
			'utilizado' => '1',
			'data_utilizado' => date("Y-m-d H:i:s")
		));
		return !!$this->db->update('cupons');
	}

	// function getUserCoupons($userId=null)
	// {
	// 	if (!$userId) {
	// 		return false;
	// 	}
	// }

	public function createCoupon ($userId=0, $type=null)
	{
		if (!$userId || $userId < 1 || $type < 1 || !$this->checkAvailable($type)) {
			return false;
		}

		if (!$this->userExists($userId)) {
			return false;
		}

		$insert_data = array(
			'id_usuario' => $userId,
			'codigo' => $this->generateCouponCode(),
			'tipo' => $type
		);

		if (!$this->db->insert('cupons', $insert_data)) {
			return false;
		}

		return $this->db->insert_id();
	}

	function generateCouponCode()
	{
		$unique = false;
		$code = "";

		while ($unique == false) {
			$code = $this->randStrGenerate(4);
			$this->db->select("*");
			$this->db->where("codigo", $code);
			$cupom = $this->db->get("cupons");
			if (!$cupom) {
				return false;
			}

			if (count($cupom->result()) < 1) {
				$unique = true;
			}
		}

		return $code;
	}

	function userExists($id=null)
	{
		if (!$id) {
			return false;
		}

		$this->db->select('*');
		$this->db->where('id_usuario', $id);
		$user = $this->db->get('usuarios_site');

		if (!$user || count($user->result()) < 1) {
			return false;
		}

		return true;
	}

	function checkAvailable($type=null)
	{
		if (!$type || $type < 1) {
			return false;
		}

		$this->db->select("*");
		$this->db->where('id_tipo', $type);
		$tipo = $this->db->get('tipos_cupons');

		if (!$tipo || count($tipo->result()) < 1) {
			return false;
		}

		return !!$tipo->result()[0]->ativo;
	}

	// function update ($id=null, $usuario=null)
	// {
	// 	if (! $usuario || empty($usuario['nome']) || empty($usuario['email']) || empty($usuario['data_nascimento']) || empty($usuario['telefone']))
	// 	{
	// 		$result = array('warning' => '<p>Todos os campos devem ser preenchidos para atualizar o usuário!</p>');
	// 		return $result;
	// 	}

	// 	if (! $id)
	// 	{
	// 		$result = array('error' => '<p>Ocorreu um erro. Tente novamente.</p>');
	// 		return $result;
	// 	}

	// 	$result = array('success' => '<p>Usuário atualizado com sucesso!</p>');

	// 	$this->db->where('id_cupom', $id);
	// 	if (! $this->db->update('cupons', $usuario))
	// 	{
	// 		$result = array('error' => '<p>Ocorreu um erro. Tente novamente.</p>');
	// 	}

	// 	return $result;
	// }

	// function deleteUser ($userId)
	// {
	// 	if (! $userId || empty($userId) || ! is_numeric($userId)) {
	// 		return false;
	// 	}

	// 	$this->db->where("id_cupom = $userId");

	// 	if (! $this->db->delete('cupons')) {
	// 		return false;
	// 	}

	// 	return true;
	// }

	private function randStrGenerate ($length=4)
	{
		$charList = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$randStr = "";
		$randIndex = null;
		$prevIndex = null;

		for ($i=0; $i < $length; $i++) {
			$randIndex = rand(0, 35);

			while ($randIndex == $prevIndex)
			{
				$randIndex = rand(0, 35);
			}

			$randStr .= $charList[$randIndex];
			$prevIndex = $randIndex;
		}

		return $randStr;
	}
}