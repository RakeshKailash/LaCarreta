var p_sizes = [];

$(document).ready(function () {
	$("body.full_size").css("height", $("html").height()+"px");
	// setPSizes($("#texto_sec1"));
	// adjustElements();	
	initScrollto();
	initMasks();

	$("#btn_menu_mobile").click(function () {
		$(this).toggleClass("menu_aberto");
		$("#menu_mob").toggleClass("menu_on");

		if ($(this).hasClass("menu_aberto")) {
			showOverlay();
		} else {
			hideOverlay();
		}
	});

	$(".busca_cupom").click(function () {
		var codigo = $("#codigo_procurar").val();

		if (!codigo || codigo.length < 4) {
			Swal.fire({
			title: 'Erro',
			text: 'Digite um código de cupom válido!',
			type: 'warning'});
			$(".form_busca_cupom").find(".cupom").addClass('hide');
			return false;
		}

		codigo = codigo.toUpperCase();

		$.post(RAIZ+'sistema/findcoupon/'+codigo, function (result) {
			result = JSON.parse(result);

			if (result.status == 0) {
				Swal.fire({
					title: 'Erro',
					text: 'Erro ao buscar o cupom!',
					type: 'error'});
				$(".form_busca_cupom").find(".cupom").addClass('hide');
				return false;
			}

			if (result.cupom == "" || result.cupom.length < 1) {
				Swal.fire({
					title: 'Busca',
					text: 'Nenhum cupom encontrado para o código '+codigo,
					type: 'info'});
				$(".form_busca_cupom").find(".cupom").addClass('hide');
				return false;
			}

			var el_cupom = $(".form_busca_cupom").find(".cupom");
			$(el_cupom).find('.nome_cupom').html(result.cupom.nome);
			$(el_cupom).find('.codigo_cupom').html(result.cupom.codigo);
			$(el_cupom).find('.usuario_cupom').html('['+result.cupom.id_usuario+'] '+result.cupom.nome_usuario);
			if (result.cupom.utilizado == 1) {
				$(el_cupom).find('.status_cupom').html('Utilizado em: '+result.cupom.data_utilizado);
				$(el_cupom).find('.usar_cupom').attr('data-id', '');
				$(el_cupom).find('.usar_cupom').addClass('hide');
				$(el_cupom).addClass('utilizado');
			} else {
				$(el_cupom).removeClass('utilizado');
				$(el_cupom).find('.status_cupom').html('Disponível para uso');
				$(el_cupom).find('.usar_cupom').attr('data-id', result.cupom.id_cupom);
				$(el_cupom).find('.usar_cupom').removeClass('hide');
			}

			$(el_cupom).removeClass('hide');
			return true;
		});
	});

	$(".cupons").on('click', '.usar_cupom', function() {
		var id_cupom = $(this).data('id');

		if (!id_cupom || id_cupom == "") {
			Swal.fire({
				title: 'Erro',
				text: 'Erro ao utilizar o cupom!',
				type: 'error'
			});
			return false;
		}

		Swal.fire({
			title: 'Marcar cupom como usado',
			text: 'Deseja marcar o cupom como utilizado?',
			type: 'question',
			confirmButtonText: 'Sim, marcar',
			cancelButtonText: 'Cancelar',
			showCancelButton: true
		}).then((result) => {
			if (result.value) {
				$.post(RAIZ+'sistema/usecoupon/'+id_cupom, function () {
					return document.location.reload(true);
				});
			}
		});
	});

	$(".box_lanche").click(function () {
		if($(this).find(".ingredientes_lanche").hasClass('active')) {
			$(".ingredientes_lanche").removeClass("active");
		} else {
			$(".ingredientes_lanche").removeClass("active");
			$(this).find(".ingredientes_lanche").addClass("active");
		}
	})

	$(".item_menu_mob, #custom_overlay, #logo").click(function () {
		$("#btn_menu_mobile").removeClass("menu_aberto");
		$("#menu_mob").removeClass("menu_on");
		hideOverlay();
	});

	$(".reset_form").click(function () {
		$(this).parents("form")[0].reset();
	});

	$(".submit_form").click(function () {
		$(this).parents("form")[0].submit();
	});
});

// $(window).resize(function() {
// 	adjustElements();
// });

function initScrollto() {
	$(".scrollto").click(function (e) {
		e.preventDefault();
		var href, top;
		href = $(this).attr("href");
		top = $(href).offset().top;

		$(window).scrollTop((top - 60));
		return true;
	});
}

// function adjustElements() {
// 	var font = 0;

// 	if ($(window).innerWidth() <= 600) {
// 		font = 60;
// 	}

// 	if ($(window).innerWidth() > 600 && $(window).innerWidth() <= 992) {
// 		font = 80;
// 	}

// 	scaleP($("#texto_sec1"), font);
// }

// function scaleP(container, value) {
// 	var font_size = 0;
// 	var ps = $(container).find("p");
// 	for (var i=0; i < $(ps).length; i++) {
// 		font_size = p_sizes[i];

// 		if (value != 0) {
// 			font_size = font_size / 100 * value;
// 		}

// 		$($(ps)[i]).css("fontSize", font_size+"px");
// 	};
// }

// function setPSizes(container) {
// 	var font_size = 0;
// 	var ps = $(container).find("p");
// 	for (var i=0; i < $(ps).length; i++) {
// 		font_size = $($(ps)[i]).css("fontSize");
// 		p_sizes[i] = font_size.substring(0, font_size.length - 2);

// 	}

// }

function showOverlay () {
	$("#custom_overlay").stop(true, true).fadeIn({duration: "fast"});
}

function hideOverlay () {
	$("#custom_overlay").fadeOut({duration: "fast"});
}

function initMasks() {
	$(".phone_mask").mask("(00)00000-0000");
	$(".date_mask").mask("00/00/0000");
	$(".cpf_mask").mask("000.000.000-00");
	$(".cep_mask").mask("00000-000");
	$(".money_mask").mask('###.##0,00', {reverse: true});
}