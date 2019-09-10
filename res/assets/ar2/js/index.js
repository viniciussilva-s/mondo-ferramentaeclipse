$(document).ready(function () {
	$("#btnFiltros").on('click', function () {
		$(this).toggleClass('active');
		$(".filtros").slideToggle(200);
	});

	$(".nav-steps ul li.disabled .nav-link").click(function (e) {
		e.preventDefault();
	});

	var tags = [];

	// $(".caminhos__info li:not(.caminhos__btn-alterar), .solicit__info li").hover(function () {
	// 	var textWidth = $(this)[0].scrollWidth,
	// 		liWidth = $(this).width();

	// 	var isOverflowed = textWidth > liWidth ? true : false;

	// 	if (isOverflowed && $(this).text() != '-') {
	// 		$(this).append('<div class="list-tooltip">' + $(this).text() + '</div>');
	// 	}
	// }, function () {

	// 	if ($('.list-tooltip').length) {
	// 		$(this).find('.list-tooltip').remove();
	// 	}
	// });

	$("#alternativasCadastro").on('keypress', function (event) {
		var keycode = (event.keyCode ? event.keyCode : event.which);
		var field = $(this);

		if (keycode == 13 || keycode == 44) {
			event.preventDefault();
			addTag(field);
		}
	});

	$("body").on('click', '.input-block__tags-input i', function () {
		removeTag($(this).parent());
	});

	$("#cadastrarOpcao").on('click', function () {
		var nameGrupo = $("#nomeGrupo").val()
		if (!(nameGrupo)) {
			nameGrupo = $("#id_option option:selected").val()
		}

		var alternativas = {
			grupo: nameGrupo,
			tags: tags
		}

		// ALTERNATIVAS
		sendAlternativas("http://catalogoclaro.comercial.ws/mondo/index.php/admin/config-alt/claro/post", alternativas);
	});

	// MODAL APROVAR
	$(".solicit__btn-aprovar").on('click', function () {
		var userId = $(this).data('userid');
		aprovarUsuario(userId);
	});

	// MODAL PERMISSIONAMENTO
	$(".solicit__btn-permissao").on('click', function () {
		var userId = $(this).data('userid');
		aprovarUsuario(userId);
	});

	// MODAL RESETAR SENHA
	$(".solicit__btn-reset").on('click', function () {
		var userId = $(this).data('userid');
		aprovarUsuario(userId);
	});

	function addTag(field) {
		var value = field.val().trim();

		if (value) {
			tags.push(value);
			field.val('');
			refreshTags(tags);
		}
	}

	function removeTag(elm) {
		var index = elm.data('index');
		tags.splice(index, 1);
		refreshTags(tags);
	}

	function refreshTags(tags) {
		var tagUl = $(".input-block__tags-input ul");
		var tagDOM = "";

		tags.forEach(function (tag, i) {
			tagDOM += "<li data-index='" + i + "'><span>" + tag + "</span><i class='far fa-times'></i></li>";
		});

		tagUl.html(tagDOM);
		$(".step-cont__opcoes p span").html(tags.join(', '));
	}
	$('.classdeletElement').on('click', function () {

		deletElement(
			$(this).data('idelement'),
			$(this).data('typeelement'),
			$(this).data('location')
		);
	});
	function deletElement(id_element, typeElement, location) {
		var brnDeleteElement = document.getElementById('brnDeleteElement');
		if (typeElement == 'pageseconds') {
			brnDeleteElement.setAttribute('href', "/mondo/index.php/admin/way/pageseconds/delete/" + parseInt(id_element) + "?location=" + location + "");
		}
		else if (typeElement == 'links') {

			brnDeleteElement.setAttribute('href', "/mondo/index.php/admin/way/links/delete/" + parseInt(id_element) + "?location=" + location + "");
		}
		else if (typeElement == 'way') {
			brnDeleteElement.setAttribute('href', "/mondo/index.php/admin/way/delete/" + parseInt(id_element) + "?location=" + location + "");
		}
	}

});