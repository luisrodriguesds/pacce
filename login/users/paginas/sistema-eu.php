<?php 
	require_once '../../../sistema/system.php';
	AcessPrivate();
	$dataUser 	= GetUser();
	$user 		= $dataUser[0];
	$semana 	= GetSemana();
	$way 		= URL_PAINEL.$user['tipoSlug'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sistema - Encontros Universitário</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="<?php echo URLBASE;?>/images/pacce_icon.png" type="imgen/png">
	<link rel="stylesheet" type="text/css" href="<?php echo URL_PAINEL.'dist/css/bootstrap.css'; ?>">
	<script type="text/javascript" src="<?php echo URL_PAINEL.'js/jquery-3.1.1.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo URLBASE.'lib/angular/angular.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo URLBASE.'lib/app-eu.js'; ?>"></script>
	<script src="<?php echo URL_PAINEL; ?>/dist/js/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="<?php echo URL_PAINEL; ?>/dist/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	<style type="text/css">
		.jumbotron{
			margin: 20px auto;
			padding: 50px 20px;
			background: #e8e8e8;
		}
		#corpo{
			margin-top: 20px;
		}
		.title{
			border-bottom: 1px #ccc solid;
		}
		.form-group .col-form-label{
			font-weight: bold;
		}
		a{
			color: #337ab7;
		}
		.selecionado{
			 background-color: #dc3545 !important;
			 color: white;
		}
		.selecionado a{
			color: white;
		}
		.display_off{
			display: none;
		}
		.display_on{
			display: block;
		}
	</style>
</head>
<body ng-app="App">
<div class="container-fluid" ng-controller="AppCtrl">

<!-- Modal ADICIONAR EVENTO -->
<div class="modal fade" id="addEvento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adicionar Evento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary">Salvar Alterações</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal ADICIONAR EVENTO -->

<!-- Modal ADICIONAR ESTUDANTE -->
<div class="modal fade" id="addEstudante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adicionar Estudante</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal ADICIONAR ESTUDANTE -->

<!-- Modal ADICIONAR RETORNO MENSAGEM -->
<div class="modal fade" id="retorno" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmação de Presença</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="model_retorno_msg">
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="close_modal" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal ADICIONAR RETORNO MENSAGEM -->

	<div class="row">
		<div class="col-md-3">
		</div>
		<div class="col-12 col-sm-12 col-md-6">
			<div class="jumbotron">
				<div class="title" align="center"><h3><a href="<?php echo URL_PAINEL.'paginas/sistema-eu.php'; ?>">Encontros Universitários - UFC</a></h3></div>	
				
				<div class="row">
					
					<div class="col-md-12 col-12" id="corpo">
						<?php 
							if (isset($_GET['page']) && $_GET['page'] != '') {
								$id = DBescape($_GET['page']);
								$evento = DBread('eu_eventos', "WHERE codigo = '".$id."'");
								if ($evento == false) {		
									echo '<div class="alert alert-danger">Evento não encontrado.</div>';
								}else{
									$evento = $evento[0];
						?>
							<div class="title" align="center" style="margin-bottom: 20px;"><h3>Turno</h3></div>
							
							<div class="form-row">
								<div class="form-group col-sm-12 col-md-2 col-12">
									<label class="col-form-label"><strong>Código:</strong></label>
									<div id="codigo"><?php echo $evento['codigo']; ?></div>
								</div>
								<div class="form-group col-sm-12 col-md-4 col-12">
									<label class="col-form-label"><strong>Turno:</strong></label>
									<div><?php echo $evento['evento']; ?></div>
								</div>
								<div class="form-group col-sm-12 col-md-5 col-12">
									<label class="col-form-label"><strong>Local:</strong></label>
									<div><?php echo $evento['local']; ?></div>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-sm-12 col-md-4 col-12">
									<label class="col-form-label"><strong>Data e hora:</strong></label>
									<div><?php echo date('d/m/y', strtotime($evento['data'])).' - <span id="inicio">'.date('H:i', strtotime($evento['inicio'])).'</span> às <span id="fim">'.date('H:i', strtotime($evento['fim'])).'</span>'; ?></div>
								</div>
								<div class="form-group col-sm-12 col-md-3 col-5">
									<label class="col-form-label"><strong>Presença:</strong></label>
									<div id="status_presenca"><?php if($evento['presenca'] == 1){ echo '<div style="color: green">Liberada</div>'; }else{ echo '<div style="color: red;">Broqueada</div>'; } ?></div>
								</div>
								<div class="form-group col-sm-12 col-md-3 col-3">
									<label class="col-form-label"><strong>Status:</strong></label>
									<div><?php if($evento['status'] == 1){ echo '<div style="color: green">Ativo</div>'; }else{ echo '<div style="color: red;">Inativo</div>'; } ?></div>
								</div>
							</div>
							<?php 
								if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico') {
							?>
							<hr>
							<div class="form-row">
								<div class="form-group">
									<?php 
										if ($evento['presenca'] == 0) {
											echo '<a href="#" id="btn_presenca" class="btn btn-primary">Liberar presença</a>';
										}else{
											echo '<a href="#" id="btn_presenca" class="btn btn-danger">Bloquear presença</a>';
										}
									?>
									
									<a href="#" class="btn btn-success">Ativar</a>
									<a href="#" class="btn btn-dark">Editar</a>
								</div>
							</div>
							<?php } ?>
							<hr>						
							<div class="form-row" id="wrap_buscador">
								<div class="form-group col-md-12 col-12">
									<label class="col-form-label" style="color: #069; font-size: 20px;"><strong>Buscador:</strong></label>
									<input type="number" class="form-control" id="buscador" nome="buscardor" ng-model="estudante"  placeholder="Digite o número de Matrícula do estudante" name="">
								</div>
								
								<div class="col-md-12 col-12" id="buscadorRes">

									<table class="table table-striped table-responsive">
										<thead>
											<tr>
												<th>Matrícula</th>
												<th>Nome</th>
												<th>Curso</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												
											</tr>
										</tbody>
									</table>
									<div class="alert alert-danger display_off">Nada encontrado!</div>
								</div>
								<div class="col-md-2 col-12">
									<button class="btn btn-success display_off btn-block" id="confirmar" style="cursor: pointer;">Confirmar</button>
									<!-- para disparar a janela modal -->
									<button class="display_off" id="modal_click" data-toggle="modal" data-target="#retorno"></button>
								</div>
							</div>
							
							
							<div class="alert alert-danger" id="aviso_presenca" style="display: none;">
								A presença está desativada, por favor vá para outro turno ou espere esse começar.
							</div>
							<div class="alert alert-danger" id="nada_enc" style="display: none;">
								Nada Encontrado.
							</div>
							<hr>
							<div class="form-row" style="margin-top: 50px;">
								<div class="form-group col-md-12 col-12" id="participantes">
									<label class="col-form-label" style="color: #069; font-size: 20px;"><strong>Participantes:</strong></label>
									<table class="table table-striped table-responsive">
										<thead>
											<tr>
												<th>Matrícula</th>
												<th>Nome</th>
												<th>Curso</th>
												<th>Entrada</th>
												<th>Saída</th>
											</tr>
										</thead>
										<tbody>
											<?php 
												$part = DBread('eu_eventos_pres', "WHERE codigo = '".$_GET['page']."'");
												if ($part ==true) {
													for($i=0; $i < count($part); $i++){
											?>
											<tr>
												<td><?php echo $part[$i]['matricula']; ?></td>
												<td><?php echo $part[$i]['nome']; ?></td>
												<td><?php echo $part[$i]['curso']; ?></td>
												<td><?php echo date('H:i', strtotime($part[$i]['entrada'])); ?></td>
												<td><?php echo date('H:i', strtotime($part[$i]['saida'])); ?></td>
											</tr>
											<?php } } ?>
										</tbody>
									</table>
								</div>
							</div>
						<?php
									
								}
							}else{	
						?>
						<div class="form-group">
							<label class="col-form-label">Pesquisa</label>
								<input type="text" ng-model="pesquisar" placeholder="Digite o evento que deseja" class="form-control" name="">	
								<?php 
									if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico') {
								?>
								<script type="text/javascript">
									$(function(){
										$("#teste").click(function(event) {
											//$("#addEvento").addClass('show').css('display', 'block');
										});
									});
								</script>
								<button  data-toggle="modal" data-target="#addEvento" class="btn btn-primary" style="margin-top: 5px; cursor: pointer;">Add Evento</button>
								<button id="teste" data-toggle="modal" data-target="#addEstudante" class="btn btn-dark" style="margin-top: 5px; cursor: pointer;">Add Estudante</button>
								<button class="btn btn-danger" ng-if="isEvento(eventos)" style="margin-top: 5px; cursor: pointer;">Apagar</button>
								<?php } ?>
						</div>
						<table class="table table-striped table-responsive" ng-show="eventos.length > 0">
							<thead>
								<tr>
									<th></th>
									<th><a href="#" ng-click="ordenarPor('evento')">Nome</a></th>
									<th><a href="#" ng-click="ordenarPor('local')">Local</a></th>
									<th> <a href="#" ng-click="ordenarPor('data')">Data</a></th>
									<th>Início</th>
									<th>Fim</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="evento in eventos | filter:pesquisar | orderBy:ordenacao:direcao" ng-class="{selecionado: evento.selecionado}">
									<td><input type="checkbox" ng-model="evento.selecionado" name=""></td>
									<td><a href="?page={{evento.codigo}}">{{evento.evento}}</a></td>
									<td>{{evento.local}}</td>
									<td>{{evento.data | date:'dd/MM/yy' }}</td>
									<td>{{evento.inicio}}</td>
									<td>{{evento.fim}}</td>
								</tr>
							</tbody>
						</table>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo URL_PAINEL.'js/functions-eu.js' ?>"></script>
<div align="center"><h5>Developed by <a href="https://www.facebook.com/luisitaloar">Luis Rodrigues</a></h5></div>
</body>
</html>