<?php if(!class_exists('Rain\Tpl')){exit;}?>

		<!--  Modal Delete -->
<div class="modal fade" id="modalDeletElement">
	<div class="modal-dialog modal-dialog-centered d-flex justify-content-center">
		<div class="modal-content">
			
				<div class="content content--sucesso">
					<img src="/mondo/res/assets/ar2/assets/images/verified.png"> 
					<div class="content__header text-center py-5">
						<h2>Excluir </h2>
						<p>Tem certeza que deseja excluir?</p>
						<div class="input-block flex-fill">
							<label id="nameAlternativa" class="input-block__label" for=""></label>

						</div>
					</div>
					<div class="row justify-content-center w-100">
						<button class="btn-default bg-confirm flex-fill mr-2" data-dismiss="modal" type="button">Fechar</button>
						<a id="brnDeleteElement" class="btn-default bg-cancel flex-fill" >Excluir</a>
					</div>
				</div>
			
		</div>
	</div>
</div>

		
		</div>
	</main>

	<?php echo getFormatjs2(); ?>

</body>

</html>