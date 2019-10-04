	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class M_usuarios_site extends CI_Model {
		function __construct() {
			parent::__construct();
			$this->load->database();
			$this->load->library('session');
		}

	public function getUser ($id=null)
	{
		$this->db->select("usuarios_site.id_usuario, usuarios_site.nome, usuarios_site.email, usuarios_site.data_nascimento, usuarios_site.telefone");

		if ($id) {
			$this->db->where('usuarios_site.id_usuario', $id);
		}

		$result = $this->db->get('usuarios_site')->result();
		return $result;
	}

	public function getInfo($login, $password)
	{
		$this->db->where("email = '{$login}' OR telefone = '{$login}'");
		$query = $this->db->get('usuarios_site')->result_array()[0];

		$user_info =  isset($query['email']) ? $query : null;

		if ($user_info == null) {
			return array('error' => 1);
		}

		$verify = password_verify($password, $user_info['senha']);

		if ($verify != true) {
			return array('error' => 2);
		}

		$this->db->where(array(
			'email' => $login,
			'senha' => $user_info['senha']
			));

		$this->db->select("id_usuario, nome, email, data_nascimento, telefone");

		$result = $this->db->get('usuarios_site')->result_array()[0];
		$result['inicio'] = time();

		return $result;
	}

	public function createUser ($userData=null)
	{
		if (! $userData) {
			return false;
		}

		if (! $userData['senha']) {
			return false;
		}

		$userData['senha'] = $this->hash_password($userData['senha']);

		if (!$this->db->insert('usuarios_site', $userData)) {
			return false;
		}

		return $this->db->insert_id();
	}

	function hash_password ($password)
	{
		if (! $password) {
			return false;
		}

		$hashed_pass = password_hash($password, PASSWORD_BCRYPT);
		return $hashed_pass;
	}

	function verif_password ($userid, $password)
	{
		if (! $userid || !$password)
		{
			return 0; //Empty params
		}

		$this->db->where('id_usuario', $userid);
		$query = $this->db->get('usuarios_site')->result_array()[0];

		$user_info =  isset($query['email']) ? $query : null;

		if (! $user_info)
		{
			return false; //User not found
		}

		$verify = password_verify($password, $user_info['senha']);

		if (! $verify)
		{
			return false; //Old password doesn't match
		}

		return true;
	}


	// function updateUserType ($id, $newType)
	// {
	// 	if (! $newType || ! $id)
	// 	{
	// 		$result = array('warning' => '<p>Todos os campos devem ser preenchidos para atualizar o usuário!</p>');
	// 		return $result;
	// 	}

	// 	$this->db->set('tipoUsuario', $newType);
	// 	$this->db->where('id', $id);
	// 	if (!$this->db->update('usuarios_site'))
	// 	{
	// 		$result = array('error' => '<p>Ocorreu um erro. Tente novamente.</p>');
	// 		return $result;
	// 	}

	// 	$result = array('success' => '<p>Usuário atualizado com sucesso!</p>');
	// 	return $result;
	// }

	function update ($id=null, $usuario=null)
	{
		if (! $usuario || empty($usuario['nome']) || empty($usuario['email']) || empty($usuario['data_nascimento']) || empty($usuario['telefone']))
		{
			$result = array('warning' => '<p>Todos os campos devem ser preenchidos para atualizar o usuário!</p>');
			return $result;
		}

		if (! $id)
		{
			$result = array('error' => '<p>Ocorreu um erro. Tente novamente.</p>');
			return $result;
		}

		$result = array('success' => '<p>Usuário atualizado com sucesso!</p>');

		$this->db->where('id_usuario', $id);
		if (! $this->db->update('usuarios_site', $usuario))
		{
			$result = array('error' => '<p>Ocorreu um erro. Tente novamente.</p>');
		}

		return $result;
	}

	function deleteUser ($userId)
	{
		if (! $userId || empty($userId) || ! is_numeric($userId)) {
			return false;
		}

		$this->db->where("id_usuario = $userId");

		if (! $this->db->delete('usuarios_site')) {
			return false;
		}

		return true;
	}

	public function login($login, $password)
	{
		$userdata = $this->getInfo($login, $password);
		if (isset($userdata['error'])) {
			return $userdata;
		}

		$userdata['tipo'] = 0;

		$this->session->set_userdata($userdata);

		return $userdata;
	}

	public function isLogged ()
	{
		$user_logged = $this->session->userdata();
		if (isset($user_logged['email']) && $user_logged['email'] != null && $user_logged['tipo'] == 0) {
			return true;
		}

		return false;
	}

	public function logout ()
	{
		// if (! $this->sessions_model->refresh_info())
		// {
		// 	$this->session->sess_destroy();
		// 	return false;
		// }

		$this->session->sess_destroy();
		return true;
	}

	// public function viewNotifications ()
	// {
	// 	$userId = $_SESSION['id_usuario'];
	// 	$tempo = date("Y-m-d H:i:s", time());
	// 	$this->db->set('ultimaVerifNotif', $tempo);
	// 	$this->session->set_userdata('ultimaVerifNotif', $tempo);
	// 	$this->db->where('id_usuario', $userId);

	// 	if (! $this->db->update('usuarios'))
	// 	{
	// 		return array('status' => 'Erro');
	// 	}

	// 	return array('status' => 'Sucesso');
	// }

	public function refreshUserdata ()
	{
		$userdata = $this->getUserById($_SESSION['id_usuario']);

		if (!$userdata)
		{
			return false;
		}

		$_SESSION['id_usuario'] = $userdata['id_usuario'];
		$_SESSION['nome'] = $userdata['nome'];
		$_SESSION['email'] = $userdata['email'];
		$_SESSION['data_nascimento'] = $userdata['data_nascimento'];
		$_SESSION['telefone'] = $userdata['telefone'];

		return $userdata;
	}

	public function passRecoverCreate ($userid=null)
	{
		if (! $userid)
		{
			return false;
		}

		$this->db->select('disponivel');
		$this->db->where("usuario = ".$userid." AND disponivel = 1");
		$activeTokens = $this->db->get('recuperacao_senha')->result();

		if (count($activeTokens) > 0)
		{
			return false;
		}

		$user = $this->getUser($userid)[0];
		$passToken = $userid . $this->randStrGenerate();

		$email_config = $this->getDefaultEmail();

		$config = Array(
			'protocol' => $email_config[3]->valor,
			'smtp_host' => $email_config[2]->valor,
			'smtp_port' => $email_config[4]->valor,
			'smtp_user' => $email_config[0]->valor,
			'smtp_pass' => $email_config[1]->valor,
			'mailtype' => 'html',
			'charset' => 'utf8',
			'wordwrap' => TRUE);

		$dataHora = time();

		$mensagem = "";
		$mensagem .= "<h2 id='title'>Recuperação de Senha</h2>";
		$mensagem .= "<p class='p_mail'><b>De: </b> La Carreta</p>";
		$mensagem .= "<p class='p_mail'><b>Data: </b> ".date('d/m/Y\, \à\s H:i:s', $dataHora)."</p>";
		$mensagem .= "<h4>".$user->nome.", você solicitou a recuperação da sua senha. Clique no link abaixo para ser redirecionado à página de redefinição de senha.</h4><br><br>";
		$mensagem .= "<a href=".base_url('sistema/usuarios/password_recovery/' . $passToken)." title='Recuperar a Senha'>Recuperar minha senha</a>";

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from("contato@lacarretapanchos.com.br");
		$this->email->to($user->email);
		$this->email->subject("Recuperação de Senha - La Carreta");
		$this->email->message($mensagem);

		$result = array('status' => 'success', 'message' => '<p>Mensagem enviada com sucesso!</p>');
		if (! $this->email->send())
		{
			$result = array('status' => 'error', 'message' => '<p>'.show_error($this->email->print_debugger()).'</p>');
		}

		if (! $this->insertToken($passToken, $userid))
		{
			$result = array('status' => 'error', 'message' => '<p>Ocorreu um erro, tente novamente.</p>');
		}

		return $result;
	}

	public function retrieveToken ($token=null)
	{
		if (! $token)
		{
			return false;
		}


		$this->db->select('usuario, data_expira, disponivel');
		$this->db->where('token', $token);
		$tokenReg = $this->db->get('recuperacao_senha')->result();

		if (count($tokenReg) != 1)
		{
			$retorno = array('status' => 'error', 'message' => '<p>Não foi possível processar a solicitação, tente novamente.</p>');
			return $retorno;
		}

		if ($tokenReg[0]->disponivel == '0' || date('Y-m-d H:i:s', strtotime($tokenReg[0]->data_expira)) < date('Y-m-d H:i:s', time()))
		{
			$retorno = array('status' => 'warning', 'message' => '<p>Esta redefinição de senha já expirou, solicite uma nova.</p>');
			return $retorno;
		}

		$retorno = array('status' => 'success', 'message' => '<p>Solicitação processada com sucesso! Agora você pode redefinir sua senha.</p>', 'userid' => $tokenReg[0]->usuario);

		return $retorno;
	}

	private function insertToken ($token=null, $userid=null)
	{
		if (! $token || ! $userid)
		{
			return false;
		}

		$query = "INSERT INTO recuperacao_senha (
		token,
		data_criacao,
		data_expira,
		usuario
		)
		VALUES (
		'$token',
		CURRENT_TIMESTAMP,
		DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 24 HOUR),
		$userid
		)";

		if (! $this->db->query($query))
		{
			return false;
		}

		return true;
	}

	public function updateTokens ($user, $changes=null)
	{
		if (! $user || ! $changes)
		{
			return false;
		}

		$this->db->set($changes);
		$this->db->where('usuario', $user);

		if (! $this->db->update('recuperacao_senha'))
		{
			return false;
		}

		return true;
	}

	// public function getOnlineUsers ()
	// {
	// 	$query = "
	// 	SELECT
	// 	id,
	// 	IF (
	// 	FIND_IN_SET(
	// 	id,
	// 	CAST(
	// 	(SELECT
	// 	GROUP_CONCAT(usuarios_site.id_usuario) AS online
	// 	FROM
	// 	usuarios
	// 	JOIN sessions
	// 	ON sessions.`id_usuario` = usuarios_site.`id`
	// 	AND sessions.`id` =
	// 	(SELECT
	// 	MAX(id) AS id_m
	// 	FROM
	// 	sessions
	// 	WHERE id_usuario = usuarios_site.`id`)
	// 	AND TIMESTAMPDIFF(
	// 	SECOND,
	// 	FROM_UNIXTIME(sessions.`fim`),
	// 	CURRENT_TIMESTAMP
	// 	) < 15
	// 	WHERE sessions.`id_usuario` = usuarios_site.`id`) AS CHAR
	// 	)
	// 	),
	// 	1,
	// 	0
	// 	) AS `status`
	// 	FROM
	// 	usuarios
	// 	ORDER BY id ";

	// 	$onlineUsers = $this->db->query($query);

	// 	if (! $onlineUsers)
	// 	{
	// 		return false;
	// 	}

	// 	print json_encode($onlineUsers->result_array());
	// }

	private function getUserById ($id=null)
	{
		if (!$id)
		{
			return false;
		}

		$this->db->where('id', $id);

		$this->db->select("id_usuario, nome, email, data_nascimento, telefone");

		$query = $this->db->get('usuarios_site');

		if (! $query)
		{
			return false;
		}

		$result = $query->result_array()[0];

		return $result;
	}

	// private function replaceUserImage ($user=null,$field=null)
	// {
	// 	if (! $user)
	// 	{
	// 		return false;
	// 	}

	// 	$caminho_pasta = str_replace('\\', DIRECTORY_SEPARATOR, FCPATH);
	// 	if ($field) {
	// 		$this->load->library('ImageManipulation', '', 'img_manipulation');

	// 		$caminho_upload = $caminho_pasta . 'images/uploads/profile/temp/';

	// 		if (!is_dir($caminho_upload)) {
	// 			mkdir($caminho_upload, 0777);
	// 		}

	// 		$config_upload['upload_path'] = $caminho_upload;
	// 		$config_upload['allowed_types'] = 'gif|jpg|jpeg|png';
	// 		$config_upload['max_size'] = '0';
	// 		$config_upload['max_width'] = '0';
	// 		$config_upload['max_height'] = '0';
	// 		$config_upload['encrypt_name'] = true;

	// 		$this->load->library('upload', $config_upload);

	// 		if (! $this->upload->do_upload($field)) {
	// 			return false;
	// 		}

	// 		$info_img = $this->upload->data();

	// 		$origem = $caminho_upload.$info_img['file_name'];
	// 		$destino = $caminho_pasta.'images/uploads/profile/'.$info_img['file_name'];

	// 		$this->img_manipulation->compress($origem, $destino, 80);
	// 		$this->img_manipulation->squareCrop($destino, $destino);

	// 	} else {
	// 		$info_img = array('file_name' => 'user.png', 'file_size' => 0);
	// 	}

	// 	$this->db->select('imagem');
	// 	$this->db->from('usuarios');
	// 	$this->db->where('id', $user);

	// 	$img_anterior = $this->db->get()->result()[0];

	// 	if ($img_anterior->imagem != 'user.png')
	// 	{
	// 		unlink($caminho_pasta . 'images/uploads/profile/' . $img_anterior->imagem);
	// 	}

	// 	$info_retorno['imagem']['nome'] = $info_img['file_name'];
	// 	$info_retorno['imagem']['tamanho'] = $info_img['file_size'];
	// 	$info_retorno['imagem']['caminho'] = $info_img['file_name'] != null ? ('images/uploads/sections/' . $info_img['file_name']) : null;

	// 	$data_insert = array('imagem' => $info_img['file_name']);

	// 	$this->db->where('id', $user);
	// 	$update_img = $this->db->update('usuarios', $data_insert);

	// 	if ( ! $update_img) {
	// 		return false;
	// 	}

	// 	return $info_retorno;
	// }

	private function randStrGenerate ($length=32)
	{
		$charList = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		$randStr = "";
		$randIndex = null;
		$prevIndex = null;

		for ($i=0; $i < $length; $i++) {
			$randIndex = rand(0, 61);

			while ($randIndex == $prevIndex)
			{
				$randIndex = rand(0, 61);
			}

			$randStr .= $charList[$randIndex];
			$prevIndex = $randIndex;
		}

		return $randStr;
	}

	public function updatePassword ($userid=null, $password=null)
	{
		if (! isset($_SESSION['verif_user']) || ! $_SESSION['verif_user'])
		{
			return false;
		}

		if (! $this->changePassword($password, $userid))
		{
			return false;
		}

		return true;
	}

	private function getDefaultEmail ()
	{
		$query = "SELECT valor FROM	preferencias
		WHERE nome = 'default_email'
		OR nome = 'default_email_password'
		OR nome = 'default_email_host'
		OR nome = 'default_email_protocol'
		OR nome = 'default_email_port'";

		$result = $this->db->query($query);

		if (! $result)
		{
			return false;
		}

		return $result->result();
	}

	private function changePassword ($password=null, $userid=null)
	{
		if (! $userid || ! $password)
		{
			return false;
		}

		$newpass = password_hash($password, PASSWORD_BCRYPT);

		$this->db->set('senha', $newpass);
		$this->db->where('id_usuario', $userid);

		if (! $this->db->update('usuarios_site'))
		{
			return false;
		}

		return true;
	}
}