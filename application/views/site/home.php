<?php 
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
$success = isset($_SESSION['success']) ? $_SESSION['success'] : null;
$warning = isset($_SESSION['warning']) ? $_SESSION['warning'] : null;
?>
<div class="col s12" id="banner_home">
</div>
<section id="secao_cardapio">
	<div class="container">
		<div class="section_header">
			<p class="section_title_img"><img src="<?=RAIZ?>img/menu.svg"></p>
		</div>
		<div id="cardapio_container" class="row no-margin">
			<p class="section_p center"><b>Clique no lanche para ver os ingredientes</b></p>
			<div class="row_header">
				<p class="row_title">Panchos</p>
			</div>
			<div class="row row_lanches" id="row_pancho">
				<div class="col s12 m4 box_lanche">
					<p class="titulo_lanche">Pancho Uruguaio</p>
					<img src="<?=RAIZ?>img/lanches/pancho/pancho_1.png" class="img_lanche">
					<p class="ingredientes_lanche">Salsicha Frankfurter e condimentos</p>
				</div>
				<div class="col s12 m4 box_lanche">
					<p class="titulo_lanche">Pancho + Queijo</p>
					<img src="<?=RAIZ?>img/lanches/pancho/pancho_2.png" class="img_lanche">
					<p class="ingredientes_lanche">Salsicha Frankfurter, mussarela derretida e condimentos</p>
				</div>
				<div class="col s12 m4 box_lanche">
					<p class="titulo_lanche">Pancho + Queijo + Bacon</p>
					<img src="<?=RAIZ?>img/lanches/pancho/pancho_3.png" class="img_lanche">
					<p class="ingredientes_lanche">Salsicha Frankfurter, mussarela derretida, bacon e condimentos</p>
				</div>
			</div>
			<div class="row_header">
				<p class="row_title">Chivitos</p>
			</div>
			<div class="row row_lanches" id="row_pancho">
				<div class="col s12 m4 box_lanche">
					<p class="titulo_lanche">Chivito La Carreta</p>
					<img src="<?=RAIZ?>img/lanches/chivito/chivito_1.png" class="img_lanche">
					<p class="ingredientes_lanche">Pão artesanal, filé de entrecot, bacon, ovo cozido, queijo mussarela, provolone, presunto, alface, tomate, palmito e azeitona</p>
				</div>
				<div class="col s12 m4 box_lanche">
					<p class="titulo_lanche">Chivito Costela</p>
					<img src="<?=RAIZ?>img/lanches/chivito/chivito_2.png" class="img_lanche">
					<p class="ingredientes_lanche">Pão artesanal, hambúrguer de costela 200g, bacon, ovo cozido, queijo mussarela, provolone, presunto, alface, tomate e pimentão assado</p>
				</div>
				<div class="col s12 m4 box_lanche">
					<p class="titulo_lanche">Chivito República</p>
					<img src="<?=RAIZ?>img/lanches/chivito/chivito_3.png" class="img_lanche">
					<p class="ingredientes_lanche">Pão artesanal, hambúrguer de cordeiro 160g, bacon, ovo cozido, queijo mussarela, provolone, presunto, alface, tomate e pimentão assado.</p>
				</div>
			</div>
			<div class="row_header">
				<p class="row_title">Choripans</p>
			</div>
			<div class="row row_lanches" id="row_pancho">
				<div class="col s12 m6 box_lanche">
					<p class="titulo_lanche">Choripan Cordeiro</p>
					<img src="<?=RAIZ?>img/lanches/choripan/choripan_1.png" class="img_lanche">
					<p class="ingredientes_lanche">Pão artesanal, alface, tomate, linguiça de cordeiro, queijo mussarela, provolone, pimentão assado e chimichurri</p>
				</div>
				<div class="col s12 m6 box_lanche">
					<p class="titulo_lanche">Choripan Suíno</p>
					<img src="<?=RAIZ?>img/lanches/choripan/choripan_2.png" class="img_lanche">
					<p class="ingredientes_lanche">Pão artesanal, alface, tomate, linguiça suína, queijo mussarela, provolone, pimentão assado e chimichurri</p>
				</div>
			</div>
		</div>
	</div>
</section>
<section id="secao_sobrenos">
	<div class="container">
		<div class="section_header">
			<p class="section_title_img"><img src="<?=RAIZ?>img/sobrenos.svg"></p>
		</div>
		<div class="row no-margin">
			<p class="section_p">Seguindo à risca a tradição uruguaia, preparamos nossos lanches utilizando ingredientes e receitas típicos dessa <i>pátria hermana</i>, de modo a oferecer a nossos clientes um sabor incomparável, inigualável e irresistível: Um pedaço do Uruguai no Brasil.</p>
			<p class="section_p"><b>O verdadeiro pancho uruguaio, em Pelotas, é só no La Carreta!</b></p>
			<div class="section_img">
				<img src="<?=RAIZ?>img/logo_claro.png" alt="">
			</div>
		</div>
	</div>
</section>
<section id="secao_contato">
	<div class="container">
		<div class="section_header">
			<p class="section_title_img"><img src="<?=RAIZ?>img/contato.svg"></p>
		</div>
		<div class="row row_contato no-margin">
			<form method="post" action="<?=RAIZ?>contato/enviar" class="col s12 m6 l6">
				<div class="row">
					<div id="login_errors">
						<?php if ($error) : ?>
							<p class="inline_error_msg">
								<strong>Erro</strong> <?php echo $error; ?>
							</p>
						<?php endif; ?>
						<?php if ($success) : ?>
							<p class="inline_success_msg">
								<strong>Sucesso</strong> <?php echo $success; ?>
							</p>
						<?php endif; ?>
						<?php if ($warning) : ?>
							<p class="inline_att_msg">
								<strong>Atenção</strong> <?php echo $warning; ?>
							</p>
						<?php endif; ?>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s6">
						<input id="nome_form_contato" type="text" name="nome">
						<label for="nome_form_contato">Nome</label>
					</div>
					<div class="input-field col s6">
						<input id="telefone_form_contato" type="text" name="telefone">
						<label for="telefone_form_contato">Telefone</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input id="email_form_contato" type="text" name="email">
						<label for="email_form_contato">E-mail</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<textarea id="msg_form_contato" class="materialize-textarea" name="mensagem"></textarea>
						<label for="msg_form_contato">Mensagem</label>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<a class="waves-effect waves-light btn submit_form">Enviar</a>
						<a class="waves-effect waves-light btn reset_form" href="javascript:void(0)">Limpar</a>
					</div>
				</div>
			</form>
			<div class="col s12 m6 l6 col_mapa">
				<iframe id="mapa_google" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3392.350544834229!2d-52.34293778529471!3d-31.760923720178464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9511b5dd65ad452f%3A0x952af11c9038ded0!2sLa+Carreta+-+Panchos+y+Tipicos!5e0!3m2!1spt-BR!2sbr!4v1558485753793!5m2!1spt-BR!2sbr" frameborder="0" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</section>