<h2 class="titulo_sistema_usuarios">Olá, <?=$this->session->userdata('nome')?>!</h2>

<form action="#" method="post" class="form_busca_cupom">
	<div class="row">
		<div class="input-field col s4">
			<input type="text" name="codigo" id="codigo_procurar">
			<label for="codigo_procurar">Código do Cupom</label>
		</div>
		<div class="input-field col s4">
			<a href="javascript:void(0)" class="busca_cupom btn_sistema">Buscar</a>
		</div>
	</div>
	<div class="cupons row">
		<div class="cupom hide">
			<p class="nome_cupom"></p>
			<p class="codigo_cupom"></p>
			<p class="usuario_cupom"></p>
			<p class="status_cupom"></p>
			<a href="javascript:void(0)" class="usar_cupom btn_sistema" data-id="">Marcar como usado</a>
		</div>
	</div>
</form>

<?php if (count($cupons) > 0): ?>
	<p>Estes são os últimos cupons gerados</p>
	<?php else: ?>
		<p>Atualmente, não existem cupons gerados.</p>
	<?php endif ?>

	<div class="cupons row">
		<?php foreach ($cupons as $cupom): ?>
			<div class="cupom col s4 <?=$cupom->utilizado ? 'utilizado' : ''?>">
				<div class="cupom_inside">
					<p class="nome_cupom"><?=$cupom->nome?></p>
					<p class="codigo_cupom"><?=$cupom->codigo?></p>
					<p class="usuario_cupom"><?='['.$cupom->id_usuario.'] '.$cupom->nome_usuario?></p>
					<p class="status_cupom"><?=$cupom->utilizado ? 'Utilizado em: '.$this->parserlib->formatDatetime($cupom->data_utilizado) : 'Disponível para uso'?></p>
					<?php if (!$cupom->utilizado): ?>
						<a href="javascript:void(0)" class="usar_cupom btn_sistema" data-id="<?=$cupom->id_cupom?>">Marcar como usado</a>
					<?php endif ?>
				</div>
			</div>
		<?php endforeach ?>
	</div>