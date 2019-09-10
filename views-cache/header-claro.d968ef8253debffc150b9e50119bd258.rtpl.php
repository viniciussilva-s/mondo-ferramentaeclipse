<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>Claro</title>

		<?php echo getFaviconSite(); ?>
		<?php echo getFormatcss2(); ?>
</head>

<body>
	<!-- NAVBAR PRINCIPAL -->
	<nav class="nav-principal navbar navbar-expand justify-content-between bg-light py-0">
		<div class="container align-items-end p-3">
			<a class="navbar-brand pt-0 pb-2" href="#">
				<img src="http://catalogoclaro.comercial.ws/mondo/res/assets/ar2/assets/images/brand_claro.png"  >
				 
				<!-- <img src="./assets/images/brand_claro.png"> -->
			</a>

			<ul class="navbar-nav">
				<li class="nav-item active">
					<span class="indicador"></span>
					<a class="nav-link px-3" href="/mondo/index.php/admin/claro-create"><i class="far fa-plus"></i> Iniciar cadastro</a>
				</li>
				<li class="nav-item">
					<span class="indicador"></span>
					<a class="nav-link px-3" href="/mondo/index.php/admin/claro/wayall"><i class="far fa-list-ul"></i> Locais de guarda</a>
				</li>
				
				
				<?php if( verify_OnlyAdmin() ){ ?>
				<li class="nav-item">
					<span class="indicador"></span>
					<a class="nav-link px-3" href="/mondo/index.php/admin/user/onlyAdmin"><i class="fal fa-user"></i> Novas Solicitações</a>
				</li>
				<li class="nav-item">
					<span class="indicador"></span>
					<!-- <a class="nav-link px-3" href="#"><i class="fal fa-cog"></i> Cadastrar Opções</a> -->
					<a class="nav-link px-3" href="/mondo/index.php/admin/config-alt/claro/onlyAdmin"><i class="fal fa-cog"></i> Cadastrar Opções</a>
				</li>
				<?php } ?>

				<li class="nav-item">
					<span class="indicador"></span>
					<a class="nav-link px-3"  href="/mondo/index.php/admin/logout"><i class="fal fa-power-off"></i> Sair</a>
				</li>
			</ul>
		</div>
	</nav>
	<!-- / NAVBAR PRINCIPAL -->

	<main>
		<div class="container">