<?php if(!class_exists('Rain\Tpl')){exit;}?>			<div class="step-cont mt-2">
				<div class="row">
					<div class="col">
						<div class="step-cont__titulo d-flex align-items-center pt-5 pb-3">
							<h1>Lista de Opções</h1>
							<a class="btn-default bg-default ml-5 w-auto px-5"  href="http://catalogoclaro.comercial.ws/mondo/index.php/admin/config-alt/claro/onlyAdmin"><i
									class="far fa-plus mr-3"></i>
								Cadastro de Opções</a>
						</div>
					</div>
				</div>

				<div class="row py-4">
					<div class="col">
						<!-- Caminho Pai -->
						<div class="caminhos--pai caminhos--opcoes pb-5">

							<div class="caminhos__col-titulo">
								<ul>
									<li>Nome</li>
									<li>Opções</li>
								</ul>
							</div>

							<!-- ROW -->
							<?php $counter1=-1;  if( isset($listOption) && ( is_array($listOption) || $listOption instanceof Traversable ) && sizeof($listOption) ) foreach( $listOption as $key1 => $value1 ){ $counter1++; ?>

							<div class="caminhos__row ">
								<ul class="caminhos__info">
									<li><?php echo htmlspecialchars( $value1["opt"], ENT_COMPAT, 'UTF-8', FALSE ); ?></li>
									<li><?php $counter2=-1;  if( isset($value1["val"]) && ( is_array($value1["val"]) || $value1["val"] instanceof Traversable ) && sizeof($value1["val"]) ) foreach( $value1["val"] as $key2 => $value2 ){ $counter2++; ?> <?php echo htmlspecialchars( $value2["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?>,<?php } ?></li>
									<li class="caminhos__btn-alterar">
										<a href="http://catalogoclaro.comercial.ws/mondo/index.php/admin/config-alt/<?php echo htmlspecialchars( $value1["id_option"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/claro/onlyAdmin">

											<i class="fas fa-pen"></i>
										</a>
									</li>
								</ul>
							</div>
							<!-- / ROW -->
							<?php } ?>

							
							
						</div>
						<!-- / Caminho Pai -->
					</div>
				</div>
			</div>
	