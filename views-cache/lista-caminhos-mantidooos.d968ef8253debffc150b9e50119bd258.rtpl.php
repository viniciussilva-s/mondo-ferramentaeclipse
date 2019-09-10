<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="step-cont mt-2">
	<div class="row pt-5">
		<div class="col">
			<div class="step-cont__titulo">
				<h1>Lista de Caminhos </h1>
			</div>
		</div>
	</div>

	<form action="http://catalogoclaro.comercial.ws/mondo/index.php/admin/claro/wayall" method="GET">
		<!--  -->
		<div class="row pt-5">
			<div class="col d-flex">
				<div class="input-block flex-fill">
					<label class="input-block__label" for="">Pesquisar</label>
					<div class="d-flex flex-fill">
						<div class="input-block__cont small-input-text flex-fill">
							<div class="input-block__text-input">
								<input type="text" id="search" name="search" placeholder="Nome do caminho">
							</div>
						</div>
						<button class="btn-default bg-default ml-3" type="submit" id="btnFiltros">
							<i class="far fa-search mr-3"></i>
							Procurar</button>

					</div>
				</div>
			</div>
		</div>
		<!--  -->

		<div class="row pb-3 pt-5">
			<div class="col d-flex justify-content-center">
				<div class="lista-caminhos w-25">
					<a class="btn-lista bg-default active" href="wayall">Mantidos</a>
					<a class="btn-lista bg-default" href="naomantidos">Não Mantidos</a>
				</div>
			</div>
		</div>


	</form>

	<div class="row py-4">
		<div class="col">
			<!-- Caminhos Principal -->
			<div class="caminhos--principal pb-5">
				<div class="caminhos__col-titulo caminhos--lista">
					<ul>

						<?php $counter1=-1;  if( isset($listAllOptions) && ( is_array($listAllOptions) || $listAllOptions instanceof Traversable ) && sizeof($listAllOptions) ) foreach( $listAllOptions as $key1 => $value1 ){ $counter1++; ?>

						<li><?php echo quebraLinha($value1["name"]); ?></li>

						<?php } ?>

						<li>Nome</li>
						<li>Data</li>
					</ul>
				</div>
				<?php if( $way!='' ){ ?>

				<?php $counter1=-1;  if( isset($way) && ( is_array($way) || $way instanceof Traversable ) && sizeof($way) ) foreach( $way as $key1 => $value1 ){ $counter1++; ?>

				<!-- ROW -->
				<div class="caminhos__row ">
					<ul class="caminhos__info">
						<!--<li><?php echo htmlspecialchars( $value1["id_way"], ENT_COMPAT, 'UTF-8', FALSE ); ?></li-->
						<?php $counter2=-1;  if( isset($value1["val"]) && ( is_array($value1["val"]) || $value1["val"] instanceof Traversable ) && sizeof($value1["val"]) ) foreach( $value1["val"] as $key2 => $value2 ){ $counter2++; ?>

						<li><?php echo emptyData($value2["name"]); ?></li>
						<?php } ?>

						<li><?php echo emptyData($value1["wayname"]); ?></li>
						 <li><?php echo formatData($value1["created"]); ?></li> 

						<li class="caminhos__btn-alterar">
							<a href="http://catalogoclaro.comercial.ws/mondo/index.php/admin/<?php echo htmlspecialchars( $value1["id_register"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/way">
								<i class="fas fa-pen"></i>
							</a>
						</li>
					</ul>


					<a class="caminhos__btn-vizualizar bg-confirm px-4"
						href="http://catalogoclaro.comercial.ws/mondo/index.php/admin/relatorio/claro/<?php echo htmlspecialchars( $value1["id_register"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/way">Ver
						Mais</a>
				</div>
				<!-- / ROW -->
				<?php } ?>

				<?php }else{ ?>



				<div class="caminhos__row ">
					<ul class="caminhos__info">
						<li>-</li>
						<li>-</li>
						<li>Não encontrado</li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>

						<!-- <li class="caminhos__btn-alterar">
							<a href="#">
								<i class="fas fa-pen"></i>
							</a>
						</li> -->
					</ul>
					<!-- <a class="caminhos__btn-vizualizar bg-confirm px-4" href="#">Ver Mais</a> -->
				</div>
				<?php } ?>


			</div>
			<!-- / Caminhos -->
		</div>
	</div>

</div>