<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- STEPS MENU -->
<?php echo htmlspecialchars( $stepsmenu, ENT_COMPAT, 'UTF-8', FALSE ); ?>


<!-- / STEPS MENU -->
<div class="step-cont mt-2">
	<div class="row">
		<div class="col">
			<div class="step-cont__titulo">
				<h1>Detalhes</h1>
			</div>
		</div>
	</div>

	<!-- <div class="row py-3">
		<div class="col">
			<div class="step-cont__datas">
				<p>Criação: <span>25/05/2019</span></p>
				<p>Ultima Aprovação: <span>25/05/2019</span></p>
			</div>
		</div>
	</div> -->

	<div id="view-details" class="row py-4">
		<div class="col">
			<!-- Menu original -->
			<?php if( $prevregisters!='' ){ ?>

			<div class="caminhos--pai pb-5">
				<div class="caminhos__legenda">
					<span>Menu Origem</span>

					<hr>
				</div>

				<div class="caminhos__col-titulo">
					<ul>

						<li><?php echo quebraLinha('Menu original'); ?> </li>
						<li><?php echo quebraLinha('Localização original'); ?> </li>
						<li>Nome </li>
						<li>Criador</li>
						<li>Data</li>

					</ul>
				</div>

				<div class="caminhos__row ">
					<ul class="caminhos__info">

						<li> <?php echo htmlspecialchars( $prevregisters["original_menu"], ENT_COMPAT, 'UTF-8', FALSE ); ?> </li>
						<li> <?php echo htmlspecialchars( $prevregisters["original_local"], ENT_COMPAT, 'UTF-8', FALSE ); ?> </li>
						<li> <?php echo htmlspecialchars( $prevregisters["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?> </li>
						<li> <?php echo htmlspecialchars( $prevregisters["username"], ENT_COMPAT, 'UTF-8', FALSE ); ?> </li>
						<li> <?php echo htmlspecialchars( $prevregisters["datePrev"], ENT_COMPAT, 'UTF-8', FALSE ); ?> </li>

						<!-- <li class="caminhos__btn-alterar">
							<a href="#">
								<i class="fas fa-pen"></i>
							</a>
						</li> -->
					</ul>

				</div>
			</div>

			<?php } ?>

			<!-- / Menu original -->

			<!-- Caminhos Principal -->
			<?php if( $getListAllWay!='' ){ ?>

			<?php $counter1=-1;  if( isset($getListAllWay) && ( is_array($getListAllWay) || $getListAllWay instanceof Traversable ) && sizeof($getListAllWay) ) foreach( $getListAllWay as $key1 => $value1 ){ $counter1++; ?>

			<div class="caminhos--pai pb-5">
				<div class="caminhos__legenda">
					<span>Local de guarda</span>

					<hr>
				</div>

				<div class="caminhos__col-titulo">
					<ul>

						<?php $counter2=-1;  if( isset($listAllOptions) && ( is_array($listAllOptions) || $listAllOptions instanceof Traversable ) && sizeof($listAllOptions) ) foreach( $listAllOptions as $key2 => $value2 ){ $counter2++; ?>

						<li><?php echo quebraLinha($value2["name"]); ?> </li>

						<?php } ?>

						<li>Nome</li>

					</ul>
				</div>

				<!-- ROW -->
				<div class="caminhos__row ">
					<ul class="caminhos__info">
						<?php $counter2=-1;  if( isset($value1["val"]) && ( is_array($value1["val"]) || $value1["val"] instanceof Traversable ) && sizeof($value1["val"]) ) foreach( $value1["val"] as $key2 => $value2 ){ $counter2++; ?>


						<li><?php echo emptyData($value2["name"]); ?></li>
						<?php } ?>

						<li><?php echo emptyData($value1["name"]); ?></li>
						<li class="caminhos__btn-alterar">
							<a href="/mondo/index.php/admin/way/edit/<?php echo htmlspecialchars( $value1["id_way"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
								<i class="fas fa-pen"></i>
							</a>
						</li>
					</ul>
					<?php if( $mmodify!='' ){ ?>

					<a class="caminhos__btn-vizualizar bg-cancel px-5 classdeletElement" data-toggle="modal"
						data-idelement="<?php echo htmlspecialchars( $value1["id_way"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" data-typeelement="way"
						data-location="/relatorio/claro/<?php echo htmlspecialchars( $mmodify, ENT_COMPAT, 'UTF-8', FALSE ); ?>/way" data-target="#modalDeletElement">Exluir</a>
					<?php }else{ ?>

					<a class="caminhos__btn-vizualizar bg-cancel px-5 classdeletElement" data-toggle="modal"
						data-idelement="<?php echo htmlspecialchars( $value1["id_way"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" data-typeelement="way" data-location="/claro/way/relatorio"
						data-target="#modalDeletElement">Exluir</a>
					<?php } ?>


				</div>
				<!-- / ROW -->
			</div>
			<!-- / Caminhos Principal -->

			<?php if( $value1["pageseconds"]!='' ){ ?>


			<!--  Paginas secundarias  -->
			<div class="caminhos--sub pb-5">
				<div class="caminhos__legenda">
					<span>Paginas Secudarias - &quot;<?php echo htmlspecialchars( $value1["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?>&quot;</span>

					<hr>
				</div>

				<div class="caminhos__col-titulo">
					<ul>

						<?php $counter2=-1;  if( isset($listAllOptions) && ( is_array($listAllOptions) || $listAllOptions instanceof Traversable ) && sizeof($listAllOptions) ) foreach( $listAllOptions as $key2 => $value2 ){ $counter2++; ?>

						<li><?php echo quebraLinha($value2["name"]); ?> </li>

						<?php } ?>

						<li>Nome</li>

					</ul>
				</div>

				<?php $counter2=-1;  if( isset($value1["pageseconds"]) && ( is_array($value1["pageseconds"]) || $value1["pageseconds"] instanceof Traversable ) && sizeof($value1["pageseconds"]) ) foreach( $value1["pageseconds"] as $key2 => $value2 ){ $counter2++; ?>

				<!-- ROW -->
				<div class="caminhos__row ">
					<ul class="caminhos__info">
						<?php $counter3=-1;  if( isset($value2['0']["val"]) && ( is_array($value2['0']["val"]) || $value2['0']["val"] instanceof Traversable ) && sizeof($value2['0']["val"]) ) foreach( $value2['0']["val"] as $key3 => $value3 ){ $counter3++; ?>


						<li><?php echo emptyData($value3["name"]); ?></li>
						<?php } ?>

						<li><?php echo emptyData($value2['0']["name"]); ?></li>

						<li class="caminhos__btn-alterar">
							<a href="/mondo/index.php/admin/way/edit/pageseconds/<?php echo htmlspecialchars( $value2['0']["id_sec"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
								<i class="fas fa-pen"></i>
							</a>
						</li>
					</ul>
					<?php if( $mmodify!='' ){ ?>

					<a class="caminhos__btn-vizualizar bg-cancel px-5 classdeletElement" data-toggle="modal"
						data-idelement="<?php echo htmlspecialchars( $value2['0']["id_sec"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" data-typeelement="pageseconds"
						data-location="/relatorio/claro/<?php echo htmlspecialchars( $mmodify, ENT_COMPAT, 'UTF-8', FALSE ); ?>/way" data-target="#modalDeletElement">Exluir</a>
					<?php }else{ ?>

					<a class="caminhos__btn-vizualizar bg-cancel px-5 classdeletElement" data-toggle="modal"
						data-idelement="<?php echo htmlspecialchars( $value2['0']["id_sec"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" data-typeelement="pageseconds"
						data-location="/claro/way/relatorio" data-target="#modalDeletElement">Exluir</a>
					<?php } ?>


				</div>
				<!-- / ROW -->

				<?php } ?>

			</div>
			<!--  / Paginas secundarias  -->
			<?php } ?>



			<?php if( $value1["links"]!='' ){ ?>


			<!--  Paginas secundarias  -->
			<div class="caminhos--sub pb-5">
				<div class="caminhos__legenda">
					<span>Menus - &quot;<?php echo htmlspecialchars( $value1["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?>&quot;</span>

					<hr>
				</div>

				<div class="caminhos__col-titulo">
					<ul>

						<?php $counter2=-1;  if( isset($listAllOptions) && ( is_array($listAllOptions) || $listAllOptions instanceof Traversable ) && sizeof($listAllOptions) ) foreach( $listAllOptions as $key2 => $value2 ){ $counter2++; ?>

						<li><?php echo quebraLinha($value2["name"]); ?> </li>

						<?php } ?>

						<li>Nome</li>

					</ul>
				</div>

				<?php $counter2=-1;  if( isset($value1["links"]) && ( is_array($value1["links"]) || $value1["links"] instanceof Traversable ) && sizeof($value1["links"]) ) foreach( $value1["links"] as $key2 => $value2 ){ $counter2++; ?>

				<!-- ROW -->
				<div class="caminhos__row ">
					<ul class="caminhos__info">
						<?php $counter3=-1;  if( isset($value2['0']["val"]) && ( is_array($value2['0']["val"]) || $value2['0']["val"] instanceof Traversable ) && sizeof($value2['0']["val"]) ) foreach( $value2['0']["val"] as $key3 => $value3 ){ $counter3++; ?>


						<li><?php echo emptyData($value3["name"]); ?></li>
						<?php } ?>

						<li><?php echo emptyData($value2['0']["namelink"]); ?></li>

						<li class="caminhos__btn-alterar">
							<a href="/mondo/index.php/admin/way/edit/links/<?php echo htmlspecialchars( $value2['0']["id_link"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
								<i class="fas fa-pen"></i>
							</a>
						</li>
					</ul>
					<?php if( $mmodify!='' ){ ?>

					<a class="caminhos__btn-vizualizar bg-cancel px-5 classdeletElement" data-toggle="modal"
						data-idelement="<?php echo htmlspecialchars( $value2['0']["id_link"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" data-typeelement="links"
						data-location="/relatorio/claro/<?php echo htmlspecialchars( $mmodify, ENT_COMPAT, 'UTF-8', FALSE ); ?>/way" data-target="#modalDeletElement">Exluir</a>
					<?php }else{ ?>

					<a class="caminhos__btn-vizualizar bg-cancel px-5 classdeletElement" data-toggle="modal"
						data-idelement="<?php echo htmlspecialchars( $value2['0']["id_link"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" data-typeelement="links"
						data-location="/claro/way/relatorio" data-target="#modalDeletElement">Exluir</a>
					<?php } ?>


				</div>
				<!-- / ROW -->
				<?php } ?>

			</div>
			<!--  / Paginas secundarias  -->
			<?php } ?>




			<?php } ?>


			<?php } ?>

		</div>
	</div>

	<div class="row">
		<div class="col center-column py-5">
			<div class="btn-cont">
				<button class="btn-default bg-cancel mx-3" type="button" onclick="window.print()">Exportar PDF</button>
			</div>
		</div>
	</div>