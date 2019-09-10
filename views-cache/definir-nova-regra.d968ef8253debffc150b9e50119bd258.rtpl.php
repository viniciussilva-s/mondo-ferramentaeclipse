<?php if(!class_exists('Rain\Tpl')){exit;}?>

			<?php echo htmlspecialchars( $stepsmenu, ENT_COMPAT, 'UTF-8', FALSE ); ?>

			<!-- / STEPS MENU -->
			<div class="step-cont mt-2">
				<div class="row">
					<div class="col">
						<div class="step-cont__atual pt-3 pb-2">
							<!-- 1. Criação de Nova Regra -->
						</div>
						<div class="step-cont__titulo">
							<h1>Cadastro</h1>
						</div>
					</div>
				</div>
				<?php echo getInformation_record(); ?>

				<form id="formNewRule" method="post" action="http://catalogoclaro.comercial.ws/mondo/index.php/admin/claro-create"> 
					<div class="row py-5">
						<div class="col">
							<div class="input-block">
								<div class="input-block__cont">
									<div class="input-block__text-input">
										<label for="name">Nome</label>
										<input type="text" name="name" id="name" placeholder="Pagamento da Fatura">
									</div>
								</div>
							</div>
						</div>

						<div class="col">
							<div class="input-block">
								<div class="input-block__cont">
									<div class="input-block__text-input">
										<label for="original_menu">Menu Atual</label>
										<input type="text" id="original_menu" name="original_menu"  placeholder="https://claro.com.br/loremipsum/consectetur">
									</div>
								</div>
							</div>
						</div>

						<div class="col">
							<div class="input-block">
								<div class="input-block__cont">
									<div class="input-block__text-input">
										<label for="original_local">Localização Atual</label>
										<input type="text" id="original_local" name="original_local" placeholder="C:/Lorem Ipsum/Consectatur/Amet">
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row py-5">
						<div class="col d-flex ">
							<button id="btnnewruleDescription" onclick="openModalForm()" class="btn-default bg-confirm mr-3" type="button" data-toggle="modal" data-target="#modalnewrule" >Não Manter Conteúdo</button>
							<button id="btnnewrule" class="btn-default bg-cancel" type="submit">Manter Conteúdo</button>
						</div>
					</div>
					


<!--  Modal Resetar Senha -->
	<div class="modal fade" id="modalnewrule">
		<div class="modal-dialog modal-dialog-centered d-flex justify-content-center">
			<div class="modal-content">

				<div class="content content--senha">
					<div class="content__header align-self-baseline pb-2">
						<h3  class="modal-title" for="#description" >Porque deseja excluir?</h3>
						<a   onclick="closeModalForm()" data-dismiss="modal"><i class="far fa-times"></i></a>
					</div>
					<div class="content__textfield w-100 mt-3 mb-4">
						<textarea name="description" id="description"></textarea>
					</div>
					<div class="btn-cont">
						<button id="btnsaveNewRule" class="btn-default bg-confirm w-25" type="button" >Finalizar</button>
					</div>
				</div>

				<!-- <div class="content content--sucesso">
					<img src="./assets/images/verified.png">
					<div class="content__header text-center py-5">
						<h2>Sucesso</h2>
						<p>Esse documento foi excluído</p>
						<a href="#" data-dismiss="modal"><i class="far fa-times"></i></a>
					</div>
					<button class="btn-default bg-cancel" type="button" data-dismiss="modal">Voltar para a Inclusão de
						Documento</button>
				</div> -->

			</div>
		</div>
	</div>
	<!-- / Modal Resetar Senha -->


					<!-- Modal -->
					<!-- <div class="modal fade" id="modalnewrule" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">


								<div class="modal-header">


									<h5><label class="modal-title" for="description">Descreva o motivo</label></h5>
									<button type="button" onclick="closeModalForm()" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="col">
										<div class="form-group">
											<textarea class="form-control" name="description" id="description" rows="3"></textarea>
										</div>
									</div>
									<div class="modal-footer">
										<button  id="btnsaveNewRule" type="button" class="btn btn-primary">Gravar</button>
									</div>
								</div>
							</div>
						</div>	 -->

					</form>
				</div>

<script type="text/javascript">
	function openModalForm(){

   var formNewRule = document.getElementById('formNewRule');
   var btnnewrule = document.getElementById('btnnewrule');
   var btnsaveNewRule = document.getElementById('btnsaveNewRule');



	formNewRule.setAttribute('action','http://catalogoclaro.comercial.ws/mondo/index.php/admin/dontkeep/claro-create');
	btnnewrule.setAttribute('type','button');
	btnsaveNewRule.setAttribute('type','submit');

	}

	function closeModalForm(){

   var formNewRule = document.getElementById('formNewRule');
   var btnnewrule = document.getElementById('btnnewrule');
   var btnsaveNewRule = document.getElementById('btnsaveNewRule');



	formNewRule.setAttribute('action','http://catalogoclaro.comercial.ws/mondo/index.php/admin/claro-create');
	btnnewrule.setAttribute('type','submit');
	btnsaveNewRule.setAttribute('type','button');

	}

</script>