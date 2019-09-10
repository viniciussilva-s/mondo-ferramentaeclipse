<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- STEPS MENU -->

<?php echo htmlspecialchars( $stepsmenu, ENT_COMPAT, 'UTF-8', FALSE ); ?>



<!-- / STEPS MENU -->

<div class="step-cont mt-2">
	<div class="row">
		<div class="col">
			<!-- <div class="step-cont__atual pt-3 pb-2">
					2. Definir Caminho
				</div> -->
			<div class="step-cont__titulo">
				<h1>Definir local de guarda</h1>
			</div>
		</div>
	</div>
	<?php echo getInformation_record(); ?>



	<div class="row py-4">
		<div class="col">
			<!-- Caminhos Principal -->
			<?php if( $way!='' ){ ?>

			<div class="caminhos--principal pb-5">
				<div class="caminhos__legenda">
					<span>Locais de guarda já criados </span>
					<hr>
				</div>

				<div class="caminhos__col-titulo">
					<ul>
						<?php $counter1=-1;  if( isset($listAllOptions) && ( is_array($listAllOptions) || $listAllOptions instanceof Traversable ) && sizeof($listAllOptions) ) foreach( $listAllOptions as $key1 => $value1 ){ $counter1++; ?>

						<li><?php echo htmlspecialchars( $value1["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?></li>

						<?php } ?>

						<li>Nome</li>

					</ul>
				</div>


				<?php $counter1=-1;  if( isset($way) && ( is_array($way) || $way instanceof Traversable ) && sizeof($way) ) foreach( $way as $key1 => $value1 ){ $counter1++; ?>


				<!-- ROW -->
				<div class="caminhos__row ">
					<ul class="caminhos__info">
						<?php $counter2=-1;  if( isset($value1["val"]) && ( is_array($value1["val"]) || $value1["val"] instanceof Traversable ) && sizeof($value1["val"]) ) foreach( $value1["val"] as $key2 => $value2 ){ $counter2++; ?>


						<li><?php echo emptyData($value2["name"]); ?></li>
						<?php } ?>

						<li><?php echo emptyData($value1["name"]); ?></li>

						<li class="caminhos__btn-alterar">
							<!-- <a href="#">
									<i class="fas fa-pen"></i>
								</a> -->
						</li>
					</ul>


					<a class="bg-cancel z-1" href="/mondo/index.php/admin/claro/way/<?php echo htmlspecialchars( $value1["id_way"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/pageseconds">Páginas
						Secundárias</a>


					<a class="bg-confirm" href="/mondo/index.php/admin/way/claro/<?php echo htmlspecialchars( $value1["id_way"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/links">Menus</a>
				</div>
				<!-- / ROW -->

				<?php } ?>


				<!-- <div class="caminhos__row">
					<ul class="caminhos__info">

						<li>Claro</li>
						<li>Claro</li>
						<li>Claro</li>
						<li data-toggle="tooltip" data-placement="top" title="Tooltip on top">Assunto Geral</li>
						<li>Claro</li>
						<li>Assunto Especifico</li>
						<li>Claro</li>

						<li class="caminhos__btn-alterar">
						</li>
					</ul>


					<a class="bg-cancel z-1" href="/mondo/index.php/admin/claro/way/<?php echo htmlspecialchars( $value["id_way"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/pageseconds">Páginas
						Secundárias</a>


					<a class="bg-confirm" href="/mondo/index.php/admin/way/claro/<?php echo htmlspecialchars( $value["id_way"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/links">Menus</a>
				</div> -->

				<form id="idform" method="post" action="/mondo/index.php/admin/<?php echo htmlspecialchars( $mmodify, ENT_COMPAT, 'UTF-8', FALSE ); ?>/duplicate">

					<?php echo getMenuAlternativesDisabled($way); ?>

					<div class="row py-5">
						<div class="col">
							<div class="input-block">
								<div class="input-block__cont">
									<div class="input-block__text-input">
										<label for="name">Nome</label>
										<input type="text" id="name" name="name" placeholder="Pagamento da Fatura"
											required="true">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col center-column py-5">
							<p class="radio-message">Esse caminho possui <strong>página secundária?</strong></p>
							<div class="radio-block pt-3 pb-4">
								<div class="radio-group confirm">
									<input type="radio" name="pageseconds" id="secPageSim" checked="true" value="1">
									<label for="secPageSim">Sim</label>
								</div>
								<div class="radio-group cancel">
									<input type="radio" name="pageseconds" id="secPageNao" value="0">
									<label for="secPageNao">Não</label>
								</div>
							</div>
							<div class="btn-cont py-3">
								<button class="btn-default bg-confirm" type="submit">Criar Caminho</button>
								<button class="btn-default bg-cancel mx-3" type="button">Definir Links</button>
								<button class="btn-default bg-relatorio" type="button">Finalizar e Gerar Relatório</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			<?php }else{ ?>

			<!-- / Caminhos -->
		</div>
	</div>

	<form id="idform" method="post" action="/mondo/index.php/admin/<?php echo htmlspecialchars( $mmodify, ENT_COMPAT, 'UTF-8', FALSE ); ?>/created-way">

		<?php echo getMenuAlternatives(); ?>


		<div class="row py-5">
			<div class="col">
				<div class="input-block">
					<div class="input-block__cont">
						<div class="input-block__text-input">
							<label for="name">Nome</label>
							<input type="text" id="name" name="name" placeholder="Pagamento da Fatura" required="true">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col center-column py-5">
				<p class="radio-message">Esse caminho possui <strong>página secundária?</strong></p>
				<div class="radio-block pt-3 pb-4">
					<div class="radio-group confirm">
						<input type="radio" name="pageseconds" id="secPageSim" checked="true" value="1">
						<label for="secPageSim">Sim</label>
					</div>
					<div class="radio-group cancel">
						<input type="radio" name="pageseconds" id="secPageNao" value="0">
						<label for="secPageNao">Não</label>
					</div>
				</div>
				<div class="btn-cont py-3">
					<button class="btn-default bg-confirm" type="submit">Criar Caminho</button>
				</div>
			</div>
		</div>
	</form>



	<?php } ?>



</div>