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
		<h2 id="titulo_login">Cadastre-se</h2>
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
		<form method="post" action="<?=RAIZ?>cadastrar">
			<input type="text" class="custom_text_login" name="nome" placeholder="nome completo">
			<input type="text" class="custom_text_login" name="email" placeholder="e-mail">
			<input type="text" class="custom_text_login date_mask" name="data_nascimento" placeholder="data de nascimento">
			<div class="row row_sexo_criar">
				<p class="radio_sexo_criar">
					<label>
			        	<input name="sexo" type="radio" value="0" checked />
			        	<span>Homem</span>
			      	</label>
    			</p>
    			<p class="radio_sexo_criar">
					<label>
			        	<input name="sexo" type="radio" value="1" />
			        	<span>Mulher</span>
			      	</label>
    			</p>
			</div>
			<input type="text" class="custom_text_login phone_mask" name="telefone" placeholder="telefone/whatsapp">
			<input type="password" class="custom_text_login" name="senha" placeholder="senha (min. 6 caracteres)">
			<input type="password" class="custom_text_login" name="repita_senha" placeholder="repita a senha">
			<input type="submit" class="btn_form" value="Enviar">
		</form>

		<!-- Recupera senha -->
		<div class="form_section">
			<p class="form_subtitle">Já tem cadastro? Acesse sua conta, e bem-vindo de volta!</p>
			<a class="btn_form" href="<?=RAIZ?>login');?>">Fazer login</a>
		</div>
		<div id="formFooter">
			<a class="underlineHover" href="#">Esqueceu a senha?</a>
		</div>

	</div>
</div>