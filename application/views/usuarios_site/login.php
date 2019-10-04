<?php 
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
$success = isset($_SESSION['success']) ? $_SESSION['success'] : null;
$warning = isset($_SESSION['warning']) ? $_SESSION['warning'] : null;
?>

<div id="login_frm_wrapper">
	<div id="formContent">
		<!-- Titulo -->
		<div id="container_logo_login">
			<img src="<?=RAIZ?>img/logo_escuro.svg" alt="" id="logo_login">
		</div>
		<h2 id="titulo_login">Acesse sua Conta</h2>
		<div id="login_errors">
			<?php if ($error) : ?>
				<div class="inline_error_msg">
					<strong>Erro</strong> <?php echo $error; ?>
				</div>
			<?php endif; ?>
			<?php if ($success) : ?>
				<div class="inline_success_msg">
					<strong>Sucesso</strong> <?php echo $success; ?>
				</div>
			<?php endif; ?>
			<?php if ($warning) : ?>
				<div class="inline_att_msg">
					<strong>Atenção</strong> <?php echo $warning; ?>
				</div>
			<?php endif; ?>
		</div>
		<!-- Form de acesso -->
		<form method="post" action="<?=RAIZ?>logar">
			<input type="text" id="fld_login" class="custom_text_login" name="login" placeholder="usuário">
			<input type="password" id="fld_password" class="custom_text_login" name="senha" placeholder="senha">
			<input type="submit" class="btn_form" value="Acessar">
		</form>

		<!-- Recupera senha -->
		<div class="form_section">
			<p class="form_subtitle">Não é cadastrado ainda? Faça seu cadastro agora, e ganhe uma <b>DELICIOSA SURPRESA</b>!</p>
			<a class="btn_form" href="<?=RAIZ?>cadastro">Cadastre-se</a>
		</div>
		<div id="formFooter">
			<a class="underlineHover" href="#">Esqueceu a senha?</a>
		</div>

	</div>
</div>