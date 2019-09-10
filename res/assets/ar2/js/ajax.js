function sendAlternativas(url, data) {
	var ajax = $.ajax({
		url: url,
		method: "POST",
		data: {
			grupo: data.grupo,
			tags: data.tags
		}

	});

	ajax.done(function (res) {
		window.location.href = "http://catalogoclaro.comercial.ws/mondo/index.php/admin/list/config-alt/claro/onlyAdmin";

	});
}

function aprovarUsuario(id) {
	var url = "./admin/release/" + id + "/access";

	var ajax = $.ajax({
		url: url,
		method: 'GET'
	});

	// ajax.done(function (res) {
	// 	$("#modalAprovar").modal();
	// });
}

function mudarPermissionamento(id) {
	var url = "./admin/alter/" + id + "/permission";

	var ajax = $.ajax({
		url: url
	});

	ajax.done(function (res) {
		$("#modalPermissao").modal();
	})
}

function resetPass(id) {
	var url = "./admin/reset/" + id + "/password";

	var ajax = $.ajax({
		url: url
	});

	ajax.done(function (res) {
		$("#modalResetSenha").modal();
	})
}