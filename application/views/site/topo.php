<!DOCTYPE html>
<html>
<head>
	<title>La Carreta: Panchos y Típicos</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
	<!-- <link rel="shortcut icon" type="imagem/x-icon" href="<?=RAIZ?>img/favicon.png"/> -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<?=$loads?>
	<script>
		var RAIZ = "<?=RAIZ?>";
	</script>
</head>
<body>
	<div id="custom_overlay"></div>
	<header id="cabecalho">
		<div class="container">
			<div class="row">
				<div class="col m2 s2">
					<a id="logo" href="<?=RAIZ?>"><img src="<?=RAIZ?>img/logo_claro.png"></img></a>
				</div>
				<div class="col m10 s10" style="position: relative">
					<a href="#" id="btn_menu_mobile" class="hide-on-large-only">
						<span class="material-icons icone_menu">menu</span>
						<span class="material-icons icone_fechar">close</span>
					</a>
					<ul id="menu_desk" class="hide-on-med-and-down">
						<li class="item_menu_desk"><a href="<?=RAIZ?>">Home</a></li><!-- 
						 --><li class="item_menu_desk"><a href="<?=RAIZ?>sobrenos">Sobre nós</a></li><!-- 
						--><li class="item_menu_desk"><a href="<?=RAIZ?>contato">Contato</a></li>
					</ul>

				</div>
			</div>
		</div>
	</header>
	<ul id="menu_mob" class="hide-on-large-only">
		<li class="item_menu_mob"><a href="<?=RAIZ?>">Home</a></li><!-- 
		 --><li class="item_menu_mob"><a href="<?=RAIZ?>sobrenos">Sobre nós</a></li><!-- 
		--><li class="item_menu_mob"><a href="<?=RAIZ?>contato">Contato</a></li>
	</ul>