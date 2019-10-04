<?php
$config=array(
	'cadastro_site' => array(
		array(
			'field' => 'nome',
			'label' => 'nome completo',
			'rules' => 'required'
		),
		array(
			'field' => 'telefone',
			'label' => 'telefone/whatsapp',
			'rules' => 'required|is_unique[usuarios_site.telefone]'
		),
		array(
			'field' => 'email',
			'label' => 'e-mail',
			'rules' => 'required|valid_email|is_unique[usuarios_site.email]',
			'errors'=> array('is_unique'=>'E-mail já cadastrado')
		),
		array(
			'field' => 'senha',
			'label' => 'senha',
			'rules' => 'trim|required|min_length[6]'
		),
		array(
			'field' => 'repita_senha',
			'label' => 'repita a senha',
			'rules' => 'trim|required|matches[senha]'
		)
	),
	'info_usuario_site' => array(
		array(
			'field' => 'cep',
			'label' => 'cep/código postal',
			'rules' => 'required'
		),
		array(
			'field' => 'cidade',
			'label' => 'cidade',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'bairro',
			'label' => 'bairro',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'endereco',
			'label' => 'endereço',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'numero',
			'label' => 'número',
			'rules' => 'required|numeric'
		)
	)
);