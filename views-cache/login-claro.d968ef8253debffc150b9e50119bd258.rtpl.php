<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	

	<?php echo getFaviconSite(); ?>

	<title>Login Eclipse</title>
	
	<?php echo getFormatcss2(); ?>


	<link rel='stylesheet' href="http://catalogoclaro.comercial.ws/mondo/res/assets/ar2/css/login.css"  >

</head>

<body>

	<div class="bg-login">
		<div class="bg-login__foto"></div>
		<div class="bg-login__gradiente"></div>
	</div>

	<div class="form-content">
		<?php if( $enabled=='login' ){ ?>

		<form action="http://catalogoclaro.comercial.ws/mondo/index.php/admin/login" method="post" class="form-content__login">

			<div class="form-content__header">
				<img src="../../res/assets/ar2/assets/images/brand_claro_login.png">
			</div>
			<?php echo getInformation(); ?>

			


			<div class="input-block">
				<input type="email" name="login" id="login" placeholder="joao.sila@gmail.com">
				<label class="input-block__icon" for=""><i class="far fa-user"></i></label>
			</div>

			<div class="input-block">
				<input type="password" name="despassword" id="despassword" placeholder="**********">
				<label class="input-block__icon" for=""><i class="far fa-lock-alt"></i></label>
			</div>

			<div class="form-ctrl">
				<div class="form-content__check">
					<input type="checkbox" name="" id="">
					<label for="">Lembra-me</label>
				</div>
				<!-- <a href="">Esqueci minha senha</a> -->
			</div>

			<button class="bg-red" type="submit">Entrar</button>
			
				<a class="bg-red-dark mt-3 btn-criar-conta"  href="http://catalogoclaro.comercial.ws/mondo/index.php/admin/nuser">Criar Conta</a>
			</form>
			<?php } ?>

			<?php if( $enabled=='created' ){ ?>

			<form class="form-content__cadastro" action="http://catalogoclaro.comercial.ws/mondo/index.php/admin/nuser" method="post">
				<div class="form-content__header justify-content-start">
					<a href="http://catalogoclaro.comercial.ws/mondo/index.php/admin/login"><i class="far fa-chevron-left"></i></a>
					<h2>Criar Conta</h2>
				</div>
				

				<?php echo getInformation(); ?>

				<div class="input-block">
					<label class="input-block__label" for="name">Nome</label>
					<input type="text" name="name" id="name" placeholder="João da Silva">
					<label class="input-block__icon" for=""><i class="far fa-user"></i></label>
				</div>
				
				<div class="input-block">
					<label class="input-block__label" for="email">E-mail</label>
					<input type="email" name="email" id="email" placeholder="joao.sila@gmail.com">
					<label class="input-block__icon" for=""><i class="far fa-at"></i></label>
				</div>
				<div class="input-block">
					<label class="input-block__label" for="despassword">Senha</label>
					<input type="password" name="despassword" id="despassword" placeholder="**********" minlength="8">
					<label class="input-block__icon" for=""><i class="far fa-lock-alt"></i></label>
				</div>

				<button class="bg-red mt-5" type="submit">Finalizar</button>
			</form>
			<?php } ?>		
		<!-- <form class="form-content__loading" action="">
			<p class="m-0 pl-3 loading-text">Carregando...</p>
			<button class="bg-red" type="button"><i class="fal fa-redo"></i></button>
		</form> -->
		<?php if( $enabled=='usernull' ){ ?>


		<form class="form-content__cadastro" action="">
			<div class="form-content__header">
				<img src="../../res/assets/ar2/assets/images/verified.png">
			</div>

			<div class="form-content__sucesso d-flex flex-column align-items-center">
				<h2>Sucesso</h2>
				<!-- <p class="text-center">Agora é só entrar com a sua conta para <br>começar a usar a nossa ferramenta</p> -->
				<p class="text-center">Aguarde a autorização do administrador para <br>começar a usar a nossa ferramenta</p>
			</div>

			<!-- <button class="bg-red mt-4" type="button">Entrar com a minha conta <i class="far fa-chevron-right ml-2"></i></button> -->
			<button class="bg-red mt-4"  type="button"><a href="http://catalogoclaro.comercial.ws/mondo/index.php/admin/login">Acessar outra contra</a> <i class="far fa-chevron-right ml-2"></i></button>
		</form>
		<?php } ?>

	</div>

	
	<?php echo getFormatjs2(); ?>

</body>

</html>