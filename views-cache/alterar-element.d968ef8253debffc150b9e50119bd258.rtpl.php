<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="step-cont mt-2">
	<div class="row">
		<div class="col">
			<!-- <div class="step-cont__atual pt-3 pb-2">
				2.1. Alterar Caminho
			</div> -->
			<div class="step-cont__titulo">
				<h1><?php echo htmlspecialchars( $title, ENT_COMPAT, 'UTF-8', FALSE ); ?></h1>
			</div>
		</div>
	</div>	
			<?php echo getInformation_record(); ?>

			<?php if( $layout=='alt-pageseconds' ){ ?>

			<form action="/mondo/index.php/admin/way/edit/pageseconds/<?php echo htmlspecialchars( $secpagesdata['0']["id_sec"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="POST">
				<!-- <?php echo htmlspecialchars( $title, ENT_COMPAT, 'UTF-8', FALSE ); ?> -->
				<?php if( $secpagesdata!='' ){ ?>

				<?php echo getMenuAlternativasAlterarPageSec($secpagesdata); ?>

				<div class="row py-5">
					<div class="col">
						<div class="input-block">
							<div class="input-block__cont">
								<div class="input-block__text-input">
									<label for="#name_sec">Nome</label>
									<input type="text" id="name_sec" name="name_sec" placeholder="Pagamento da Fatura" value="<?php echo htmlspecialchars( $secpagesdata['0']["name_sec"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- <?php echo htmlspecialchars( $title, ENT_COMPAT, 'UTF-8', FALSE ); ?> -->

				<div class="row">
					<div class="col center-column py-5">
						<div class="btn-cont py-3">
							<button class="btn-default bg-confirm" type="submit"><?php echo htmlspecialchars( $title, ENT_COMPAT, 'UTF-8', FALSE ); ?></button>
						</div>
					</div>
				</div>
				<?php } ?>				
			</form>
			<?php } ?>



			<?php if( $layout=='alt-links' ){ ?>

			<form action="/mondo/index.php/admin/way/edit/links/<?php echo htmlspecialchars( $datalink['0']["id_link"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="POST">
				<!-- <?php echo htmlspecialchars( $title, ENT_COMPAT, 'UTF-8', FALSE ); ?> -->
				<?php if( $datalink!='' ){ ?>

				<?php echo getMenuAlternativesAlterLink($datalink); ?>

				<div class="row py-5">
					<div class="col">
						<div class="input-block">
							<div class="input-block__cont">
								<div class="input-block__text-input">
									<label for="#namelink">Nome</label>
									<input type="text" id="namelink" name="namelink" placeholder="Pagamento da Fatura" value="<?php echo htmlspecialchars( $datalink['0']["namelink"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- <?php echo htmlspecialchars( $title, ENT_COMPAT, 'UTF-8', FALSE ); ?> -->
				<div class="row">
					<div class="col center-column py-5">
						<div class="btn-cont py-3">
							<button class="btn-default bg-confirm" type="submit"><?php echo htmlspecialchars( $title, ENT_COMPAT, 'UTF-8', FALSE ); ?></button>
						</div>
					</div>
				</div>
				<?php } ?>				
			</form>
			<?php } ?>


			<?php if( $layout=='alt-way' ){ ?>


			<form action="/mondo/index.php/admin/way/edit/<?php echo htmlspecialchars( $dataway['0']["id_way"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="POST">
				<!-- <?php echo htmlspecialchars( $title, ENT_COMPAT, 'UTF-8', FALSE ); ?> -->
				<?php if( $dataway!='' ){ ?>

				<?php echo getMenuAlternativesWay($dataway); ?>

				<div class="row py-5">
					<div class="col">
						<div class="input-block">
							<div class="input-block__cont">
								<div class="input-block__text-input">
									<label for="#wayname">Nome</label>
									<input type="text" id="wayname" name="wayname" placeholder="Pagamento da Fatura" value="<?php echo htmlspecialchars( $dataway['0']["wayname"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- <?php echo htmlspecialchars( $title, ENT_COMPAT, 'UTF-8', FALSE ); ?> -->
				<div class="row">
					<div class="col center-column py-5">
						<div class="btn-cont py-3">
							<button class="btn-default bg-confirm" type="submit"><?php echo htmlspecialchars( $title, ENT_COMPAT, 'UTF-8', FALSE ); ?></button>
						</div>
					</div>
				</div>
				<?php } ?>				
			</form>
			<?php } ?>

</div>