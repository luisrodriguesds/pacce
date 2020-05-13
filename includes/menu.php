<script type="text/javascript">
	$(function(){
		$(".responsivo").click(function(){
			$(this).siblings("#mostra-nav").toggle("slow");
		});
		$(".responsivo").click(function(){
			$(this).siblings("#social").toggle("slow");
		});
		$(".commented").click(function(){
			$(this).siblings("#show-edit").toggle("slow");
		});
		
	});
</script>
<div id="headerwrap">
	
		<header id="header" class="pagewidth">
			<hgroup>
				<a href="<?php echo URLBASE;?>">
				<img src="<?php echo URLBASE;?>login/dist/img/pacce.png">
				</a>
			</hgroup>

			<div class="responsivo">&#9776;</div>
			<nav id="mostra-nav">
				<ul id="main-nav" class="main-nav clearfix">
					<li>
						<a href="<?php echo URLBASE; ?>">Home</a>
					</li>
					<li><a href="#">Sobre</a>
						<ul class="children">
							<li><a href="<?php echo URLBASE; ?>metodologia">Metodologia</a></li>
						</ul>
					</li>
					<?php 
						$comissao = DBread('comissoes', "WHERE status = true AND comissaoSlug != 'articulador-de-celula'");
						if(!$comissao){
						}else{
					?>
					<li><a href="comissoes">Comissões</a>
						<ul class="children">
							<?php 
								for ($i=0; $i < count($comissao); $i++) { 
									echo '<li><a href="'.URLBASE.$comissao[$i]['comissaoSlug'].'">'.$comissao[$i]['comissao'].'</a></li>';
								}
							?>
						</ul>
					</li>
					<?php }?>
					<li><a href="<?php echo URLBASE; ?>celulas">Células</a></li>
					<li><a href="<?php echo URLBASE; ?>historia">História de Vida</a></li>
					<li><a href="<?php echo URLBASE; ?>oficina">Oficinas</a></li>
					<li><a href="<?php echo URLBASE; ?>Newsletter">Newsletter</a></li>
					<li><a href="<?php echo URLBASE; ?>documentos">Documentos</a></li>
					
					


					<?php
						if(!IsLogged()) {
					 ?>
					<li><a href="<?php echo URLBASE; ?>login">Login</a></li>
					<?php 
						}else{
					?>
					<li><a href="<?php echo URL_PAINEL; ?>">Meu Perfil</a></li>
					<li><a href="?logout">Sair</a></li>
					<?php } ?>
					<li>
					<form method="get" id="searchform" action="">
					<input value="<?php if(isset($_GET['s'])){ echo $_GET['s'];} ?>" class="placeholder" name="s" id="s" placeholder="Search" type="text">
					</form>
					</li>
				</ul><!-- /#main-nav --> 
			</nav>
			

			<div id="social" class="social-widget">
				<div class="facebook"><a href="http://www.facebook.com/pacceufc/"  target="_blank"></a>
				<div class="youtube"><a href="https://www.youtube.com/user/CofacUFC"  target="_blank"></a>
				<div class="twitter"><a href="http://twitter.com/pacceufc/"  target="_blank"></a>
				<div class="instagram"><a href="http://instagram.com/pacceufc"  target="_blank"></a>
				<div class="rss"><a href="#"></a>
			</div>
			<!-- /.social-widget -->

		</header>
		<!-- /#header -->
				
	</div>