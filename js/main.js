var p_sizes = [];

$(document).ready(function () {
	$("body.full_size").css("height", $("html").height()+"px");
	// setPSizes($("#texto_sec1"));
	// adjustElements();	
	initScrollto();

	$("#btn_menu_mobile").click(function () {
		$(this).toggleClass("menu_aberto");
		$("#menu_mob").toggleClass("menu_on");

		if ($(this).hasClass("menu_aberto")) {
			showOverlay();
		} else {
			hideOverlay();
		}
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