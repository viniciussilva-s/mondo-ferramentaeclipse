<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="step-cont mt-2">
	<div class="row pt-5">
		<div class="col">
			<div class="step-cont__titulo">
				<h1>Locais de guarda não mantidos</h1>
			</div>
		</div>
	</div>

	<form action="http://catalogoclaro.comercial.ws/mondo/index.php/admin/claro/naomantidos" method="get">
		<!--  -->
		<div class="row pt-5">
			<div class="col d-flex">
				<div class="input-block flex-fill">
					<label class="input-block__label" for="">Pesquisar</label>
					<div class="d-flex flex-fill">
						<div class="input-block__cont small-input-text flex-fill">
							<div class="input-block__text-input">
								<input type="text" id="search" name="search" placeholder="Pagamento da Fatura">
							</div>
						</div>
						<button class="btn-default bg-default ml-3" type="submit" id="btnFiltros">
							<i class="far fa-search mr-3"></i>
							Procurar</button>
					</div>
				</div>
			</div>
		</div>
	</form>

	<!--  -->
	<div class="row pb-3 pt-5">
		<div class="col d-flex justify-content-center">
			<div class="lista-caminhos w-25">

				<a class="btn-lista bg-default"
					href=http://catalogoclaro.comercial.ws/mondo/index.php/admin/claro/wayall>Mantidos </a> <a
					class="btn-lista bg-default active"
					href="http://catalogoclaro.comercial.ws/mondo/index.php/admin/claro/naomantidos">Não Mantidos</a>

			</div>
		</div>
	</div>

	<div class="row py-4">
		<div class="col">
			<!-- Caminhos Principal -->
			<div class="caminhos--principal pb-5">
				<div class="caminhos__col-titulo caminhos--lista">
					<ul>

						<li>Menu <br> original</li>
						<li>Localização <br> original</li>
						<li>Nome</li>
						<li>Motivo</li>
						<li>Criador</li>
						<li>Data</li>
					</ul>
				</div>

				<?php if( $prev_registers==false ){ ?>



				<div class="caminhos__row">
					<ul class="caminhos__info">
						<li>-</li>
						<li>-</li>
						<li>Não encontrado</li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>

					</ul>

				</div>

				<?php }else{ ?>

				<?php $counter1=-1;  if( isset($prev_registers) && ( is_array($prev_registers) || $prev_registers instanceof Traversable ) && sizeof($prev_registers) ) foreach( $prev_registers as $key1 => $value1 ){ $counter1++; ?>

				<!-- ROW -->
				<div class="caminhos__row">
					<ul class="caminhos__info">
						<!-- <li><?php echo htmlspecialchars( $value1["id_register"], ENT_COMPAT, 'UTF-8', FALSE ); ?></li> -->
						<li><?php echo emptyData($value1["original_menu"]); ?></li>
						<li><?php echo emptyData($value1["original_local"]); ?></li>
						<li><?php echo emptyData($value1["name"]); ?></li>
						<li><?php echo emptyData($value1["description"]); ?></li>
						<li><?php echo emptyData($value1["nameUser"]); ?></li>
						<li><?php echo emptyData($value1["datePrev"]); ?></li>

					</ul>
					<a class="caminhos__btn-vizualizar bg-confirm px-4"
						href="http://catalogoclaro.comercial.ws/mondo/index.php/admin/<?php echo htmlspecialchars( $value1["id_register"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/way">Criar
						caminho</a>
					<!-- 		<a class="caminhos__btn-vizualizar bg-confirm px-4" href="#">Criar caminho</a> -->
				</div>

				<!-- / ROW -->
				<?php } ?>


				<?php } ?>


			</div>
			<!-- / Caminhos -->
		</div>
	</div>

	<style type="text/css">
		body {
			overflow: auto !important;

		}
	</style>
</div>