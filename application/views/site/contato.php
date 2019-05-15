<!DOCTYPE html>
<html>
<head>
	<title>Drop: Web & Design</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<?=$loads?>
</head>
<body class="full_size">
	<div class="overlay hide"></div>
	<div class="row cabecalho cabecalho_retro">
		<div class="col s12 no-padding">
			<div id="topo_cabecalho" style="background-image: url(<?=base_url('img/cabecalho_retro2.svg')?>)">
				<div id="logo_container" class="col s10">
					<img id="logo_topo" src="<?=base_url('img/logo_branco.svg');?>">
				</div>
				<i class="material-icons hide-on-large-only col s3 right icone_menu_topo">menu</i>
				<div id="menu_container" class="hide-on-med-and-down">
					<ul id="menu_topo">
						<li><a href="#">Home</a></li>
						<li><a href="#">Quem somos?</a></li>
						<li><a href="#">Serviços</a></li>
						<li><a href="#">Contato</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div id="menu_mobile_container" class="hide-on-large-only col s12 no-padding">
		<ul id="menu_mobile_topo">
			<li><a href="#">Home</a></li>
			<li><a href="#">Quem somos?</a></li>
			<li><a href="#">Serviços</a></li>
			<li><a href="#">Contato</a></li>
		</ul>
		<img id="img_menu_mobile" src="<?=base_url('img/gotas_topo_menu.png');?>">
	</div>
	<div class="inner-wrapper">
		<div class="landscape"></div>
	</div>
	<div class="row">
		<div class="floating_section col s4">
			<form method="post" action="">
				<div class="row">
					<div class="form_group col s12">
						<label>Nome</label>
						<div class="input-field">
							<input type="text" autocomplete="off" name="nome">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form_group col s12">
						<label>E-mail</label>
						<div class="input-field">
							<input type="text" autocomplete="off" name="email">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form_group col s12">
						<label>Telefone</label>
						<div class="input-field">
							<input type="text" autocomplete="off" name="telefone">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form_group col s12">
						<label>Mensagem</label>
						<div class="input-field">
							<textarea name="mensagem" id="" cols="30" rows="10"></textarea>
						</div>
					</div>
				</div>
				<div class="row row_botoes_login">
					<div class="col s12">
						<div class="btn_retro"><p>Enviar</p><p class="hidden_txt">おく*る</p></div>
						<div class="btn_retro"><p>Limpar</p><p class="hidden_txt">けす</p></div>
					</div>
				</div>
			</form>
		</div>
	</div>
</body>
<script type="text/javascript">setup_drops()</script>
</html>