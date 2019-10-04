<h2 class="titulo_sistema_usuarios">Olá, <?=$this->session->userdata('nome')?>!</h2>

<?php if (count($cupons) > 0): ?>
	<p>Estes são os seus cupons ativos. Bom proveito!</p>
<?php else: ?>
	<p>Atualmente, você não tem nenhum cupom ativo.</p>
<?php endif ?>

<div class="cupons">
	<?php foreach ($cupons as $cupom): ?>
		<div class="cupom">
			<p class="nome_cupom"><?=$cupom->nome?></p>
			<p class="codigo_cupom"><?=$cupom->codigo?></p>
			<p class="status_cupom"><?=$cupom->utilizado ? 'Utilizado em: '.$this->parserlib->formatDatetime($cupom->data_utilizado) : 'Disponível para uso'?></p>
		</div>
	<?php endforeach ?>
</div>

<?php if (count($cupons) > 0): ?>
	<p>Apresente-os em qualquer unidade do La Carreta para obter seus benefícios!</p>
<?php endif ?>