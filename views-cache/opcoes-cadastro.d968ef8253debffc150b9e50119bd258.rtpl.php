<?php if(!class_exists('Rain\Tpl')){exit;}?>

<div class="step-cont mt-2">

	<div class="row">
		<div class="col">
			<div class="step-cont__titulo d-flex align-items-center pt-5 pb-3">
				<h1>Cadastrar Opções</h1>
				<a class="btn-default bg-default ml-5 w-auto px-5" href="http://catalogoclaro.comercial.ws/mondo/index.php/admin/list/config-alt/claro/onlyAdmin"><i
					class="far fa-list-ul mr-3"></i>
				Lista de Opções</a>
			</div>
		</div>
	</div>



	<?php if( $layout=='cad' ){ ?>

	<div class="input-block">
		<label class="input-block__label" for="">Opções</label>
		<div class="input-block__cont">
			<select class="input-block__select-input" name="id_option" id="id_option" required="true">
				<option value="0" disabled selected>Selecione</option>
				<?php $counter1=-1;  if( isset($options) && ( is_array($options) || $options instanceof Traversable ) && sizeof($options) ) foreach( $options as $key1 => $value1 ){ $counter1++; ?>

				<option value=<?php echo htmlspecialchars( $value1["id_option"], ENT_COMPAT, 'UTF-8', FALSE ); ?>><?php echo htmlspecialchars( $value1["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>

				<?php } ?>

			</select>
		</div>
	</div>


	<div class="row py-4">
		<div class="col">
			<p class="pl-4">Agora insira as opções para esse grupo:</p>
		</div>
	</div>

	<div class="row pt-2 pb-4">
		<div class="col">
			<div class="input-block flex-fill">
				<label class="input-block__label" for="">Alternativas <span style="opacity: 0.5;">(Para separar as tags, utilize "," ou tecle enter)</span></label>
				<div class="d-flex flex-fill">
					<div class="input-block__cont small-input-text flex-fill">
						<div class="input-block__tags-input">
							<ul>
								<!-- JS -->
							</ul>
							<input type="text" id="alternativasCadastro" placeholder="Pagamento da Fatura">
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

								<!-- <div class="row py-3">
									<div class="col">
										<div class="step-cont__opcoes">
											<p>Nome do Grupo: <span>Marca</span></p>
											<p>Opções: <span>Lorem ipsum, Lorem Ipsum, Lorem Ipsum</span></p>
										</div>
									</div>
								</div> -->

								<div class="row my-4">
									<div class="btn-cont">
										<!-- data-toggle="modal" data-target="#modalCadastroOpcoes"  -->
										<button class="btn-default bg-cancel mx-3" type="button" id="cadastrarOpcao">Criar Novo Grupo</button>
									</div>
								</div>
							</div>
							<?php } ?>


							<?php if( $layout=='alt' ){ ?>


							<div class="row pt-4 pb-3">
								<div class="col">

									<div class="input-block flex-fill">
										<label class="input-block__label" for="">Nome do Grupo</label>
										<div class="d-flex flex-fill">
											<div class="input-block__cont small-input-text flex-fill">
												<div class="input-block__text-input">
													<input type="text" id="nomeGrupo" value="<?php echo htmlspecialchars( $options['0']["nameOption"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" disabled> 
												</div>
											</div>
										</div>
									</div>



								</div>
							</div>
							<div class="row pt-2 pb-4">
								<div class="col">
									<div class="input-block flex-fill">
										<label class="input-block__label" for="">Alternativas:</label>
									<!-- <div class="d-flex flex-fill">
										<div class="input-block__cont small-input-text flex-fill">
											<div class="input-block__tags-input">
												<ul>
													 JS -->
												<!-- </ul>
												<input type="text" id="alternativasCadastro" placeholder="Pagamento da Fatura">
											</div>
										</div>
									</div> --> 
								</div>
							</div>
						</div>
						<?php $counter1=-1;  if( isset($options) && ( is_array($options) || $options instanceof Traversable ) && sizeof($options) ) foreach( $options as $key1 => $value1 ){ $counter1++; ?>

						<div class="caminhos__row ">
							<ul class="caminhos__info">
								<li><?php echo htmlspecialchars( $value1["altname"], ENT_COMPAT, 'UTF-8', FALSE ); ?></li>
								<li class="caminhos__btn-alterar">
									<a href="#"  onclick="alteralternative(<?php echo htmlspecialchars( $value1["id_alt"], ENT_COMPAT, 'UTF-8', FALSE ); ?>, '<?php echo htmlspecialchars( $value1["altname"], ENT_COMPAT, 'UTF-8', FALSE ); ?>')" data-toggle="modal"
									data-target="#modalCadastroOpcoes" >
									<i class="fas fa-pen"></i>
								</a>
							</li>
						</ul>
						<a class="bg-cancel z-1" href="http://catalogoclaro.comercial.ws/mondo/index.php/admin/config-alt/claro/delete/<?php echo htmlspecialchars( $value1["id_alt"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">Deletar</a>
					</div>
					<?php } ?>


					<!-- <div class="row my-4">
						<div class="btn-cont">
							<button class="btn-default bg-cancel mx-3" type="button" id="cadastrarOpcao" href="http://catalogoclaro.comercial.ws/mondo/index.php/admin/list/config-alt/claro/onlyAdmin">
							Voltar a lista</button>
						</div>
					</div>
				</div> -->

			</div>
			<!--  Modal Aprovar -->
			<div class="modal fade" id="modalCadastroOpcoes">
				<div class="modal-dialog modal-dialog-centered d-flex justify-content-center">
					<div class="modal-content">
						<form id="form-alterAlternatives" method="post">
							<div class="content content--sucesso">
								<!-- <img src="./assets/images/verified.png"> -->
								<div class="content__header text-center py-5">
									<h2>Alterar alternativa</h2>
									<div class="input-block flex-fill">
										<label id="nameAlternativa" class="input-block__label" for=""></label>
										<div class="d-flex flex-fill">
											<div class="input-block__cont small-input-text flex-fill">
												<div class="input-block__text-input">
													<input type="text" id="nameAlt" name="nameAlt" placeholder="Digite o novo nome da alternativa" required="true"> 
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- data-dismiss="modal" -->
								<button class="btn-default bg-cancel" type="submit" >Gravar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<script>

				function alteralternative( id_alt , altname){

					document.getElementById('nameAlternativa').innerHTML= "Atual nome: "+ altname ;
					document.getElementById('form-alterAlternatives').setAttribute('action','http://catalogoclaro.comercial.ws/mondo/index.php/admin/config-alt/claro/edit/'+id_alt+'/onlyAdmin');
				}

			</script>
			<!-- / Modal Aprovar -->
			<?php } ?>		

