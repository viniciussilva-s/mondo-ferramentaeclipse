<?php if(!class_exists('Rain\Tpl')){exit;}?>


<!-- STEPS MENU -->
<?php echo htmlspecialchars( $stepsmenu, ENT_COMPAT, 'UTF-8', FALSE ); ?>


<!-- / STEPS MENU -->

<div class="step-cont mt-2">
	<div class="row">
		<div class="col">
			<!-- <div class="step-cont__atual pt-3 pb-2">
				4. Definir Links
			</div> -->
			<div class="step-cont__titulo">
				<h1>Definir menus</h1>
			</div>
		</div>
	</div>
	<?php echo getInformation_record(); ?>



	<div class="row py-4">
		<div class="col">
			<!-- Caminho Pai -->
			<?php if( $way!='' ){ ?>

			<div class="caminhos--pai pb-5">
				<div class="caminhos__legenda">
					<span>Local de guarda</span>
					<hr>
				</div>			
				<div class="caminhos__col-titulo">
					<ul>
						<?php $counter1=-1;  if( isset($listAllOptions) && ( is_array($listAllOptions) || $listAllOptions instanceof Traversable ) && sizeof($listAllOptions) ) foreach( $listAllOptions as $key1 => $value1 ){ $counter1++; ?>


						<li><?php echo quebraLinha($value1["name"]); ?> </li>
						<?php } ?>     
						<li>Nome</li>
					</ul>
				</div>
				<div class="caminhos__row m-0">
					<ul class="caminhos__info">
						<?php $counter1=-1;  if( isset($way) && ( is_array($way) || $way instanceof Traversable ) && sizeof($way) ) foreach( $way as $key1 => $value1 ){ $counter1++; ?> 
						<?php $counter2=-1;  if( isset($value1["val"]) && ( is_array($value1["val"]) || $value1["val"] instanceof Traversable ) && sizeof($value1["val"]) ) foreach( $value1["val"] as $key2 => $value2 ){ $counter2++; ?>


						<li><?php echo emptyData($value2["name"]); ?></li>
						<?php } ?>                   
						<li><?php echo emptyData($value1["name"]); ?></li>
						<!-- <li><?php echo htmlspecialchars( $value1["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?></li> -->
						
						<li class="caminhos__btn-alterar">
							<!-- <a  href="/desv/desenUserLogin/index.php/admin/way/<?php echo htmlspecialchars( $value1["id_way"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/edit" >
								<i class="fas fa-pen"></i>
							</a> -->
						</li>	
						<?php } ?>

					</ul>
				</div>



			</div>
			<?php } ?>

			<!-- / Caminho Pai -->

			<?php if( $dataLinks!='' ){ ?>


			<!-- Páginas Secundárias / Links -->
			<div class="caminhos--sub pb-5">
				<div class="caminhos__legenda">
					<span>Menus</span>
					<hr>
				</div>

				<div class="caminhos__col-titulo">
					<ul>
						<?php $counter1=-1;  if( isset($listAllOptions) && ( is_array($listAllOptions) || $listAllOptions instanceof Traversable ) && sizeof($listAllOptions) ) foreach( $listAllOptions as $key1 => $value1 ){ $counter1++; ?>

						<li><?php echo quebraLinha($value1["name"]); ?> </li>
						
						<?php } ?>     
						<li>Nome</li>
					</ul>
				</div>
				<?php $counter1=-1;  if( isset($dataLinks) && ( is_array($dataLinks) || $dataLinks instanceof Traversable ) && sizeof($dataLinks) ) foreach( $dataLinks as $key1 => $value1 ){ $counter1++; ?>

				<!-- ROW -->
				<div class="caminhos__row ">
					<ul class="caminhos__info">


						<?php $counter2=-1;  if( isset($value1["val"]) && ( is_array($value1["val"]) || $value1["val"] instanceof Traversable ) && sizeof($value1["val"]) ) foreach( $value1["val"] as $key2 => $value2 ){ $counter2++; ?>

						<li><?php echo emptyData($value2["name"]); ?></li>
						<?php } ?>

						<li><?php echo htmlspecialchars( $value1["namelink"], ENT_COMPAT, 'UTF-8', FALSE ); ?></li>
						<li class="caminhos__btn-alterar">
							<!-- <a href="#">
								<i class="fas fa-pen"></i>
							</a> -->
						</li>
					</ul>
					<?php if( $id_way!='' ){ ?>


						<a class="caminhos__btn-vizualizar bg-cancel px-5 classdeletElement" data-toggle="modal" data-idelement="<?php echo htmlspecialchars( $value1["id_link"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" data-typeelement="links" data-location="/way/claro/<?php echo htmlspecialchars( $id_way, ENT_COMPAT, 'UTF-8', FALSE ); ?>/links"
						data-target="#modalDeletElement">Exluir</a>
					<?php }else{ ?>

						<a class="caminhos__btn-vizualizar bg-cancel px-5 classdeletElement" data-toggle="modal" data-idelement="<?php echo htmlspecialchars( $value1["id_link"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" data-typeelement="links" data-location="/way/none/links"
						data-target="#modalDeletElement">Exluir</a>
					<?php } ?>

				</div>
				<!-- / ROW -->
				<?php } ?>


				<?php if( $id_way!='' ){ ?>



			<form  method="post" 	action="http://catalogoclaro.comercial.ws/mondo/index.php/admin/way/claro/duplicate/<?php echo htmlspecialchars( $id_way, ENT_COMPAT, 'UTF-8', FALSE ); ?>/links">
				<?php }else{ ?>

				<form  method="post" 	action="http://catalogoclaro.comercial.ws/mondo/index.php/admin/way/duplicate/none/links">
					<?php } ?>


					<?php echo getMenuAlternativesDisabled($way); ?>

					<!-- <?php echo getMenuAlternativesDisabledLinks($dataLinks); ?> -->

					<div class="row py-5">
						<div class="col">
							<div class="input-block">
								<div class="input-block__cont">
									<div class="input-block__text-input">
										<label for="name">Nome</label>
										<input type="text" id="name" name="name" placeholder="Pagamento da Fatura">
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--  -->

					<div class="row">
						<div class="col center-column py-5">
							<div class="btn-cont">
								<button class="btn-default bg-cancel mr-3" type="submit">Criar Link</button>
								<button class="btn-default bg-confirm" type="button">Resumir Decisão</button>
							</div>
						</div>
					</div>
				</form>
				<?php }else{ ?>

				<?php if( $id_way!='' ){ ?>

				

			<form  method="post" 	action="http://catalogoclaro.comercial.ws/mondo/index.php/admin/way/claro/<?php echo htmlspecialchars( $id_way, ENT_COMPAT, 'UTF-8', FALSE ); ?>/links">
				<?php }else{ ?>

				<form  method="post" action="http://catalogoclaro.comercial.ws/mondo/index.php/admin/way/none/links">
					<?php } ?>


				<?php echo getMenuAlternativesDisabled($way); ?>

					<!-- <?php echo getMenuAlternatives(); ?> -->

					<div class="row py-5">
						<div class="col">
							<div class="input-block">
								<div class="input-block__cont">
									<div class="input-block__text-input">
										<label for="name">Nome</label>
										<input type="text" id="name" name="name" placeholder="Pagamento da Fatura">
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--  -->

					<div class="row">
						<div class="col center-column py-5">
							<div class="btn-cont">
								<button class="btn-default bg-cancel mr-3" type="submit">Criar Link</button>
								<button class="btn-default bg-confirm" type="button">Resumir Decisão</button>
							</div>
						</div>
					</div>
				</form>
				<?php } ?>

			</div>
			<!-- / Páginas Secundárias / Links -->
		</div>
	</div>
</div>
