<div id="PageHeader">
	<h2>Voluntários</h2>
</div>
<strong>
	<p style="font-size: 14px;">Se deseja manisfestar interesse em participar do programa nesse ano como voluntário basta digitar seu CPF.
	Lembrando que o participante pode ser afetivado a qualquer momento dependendo ditados pelo programa.(Alterar o texto se necessário)</p>
</strong>
<script type="text/javascript">
	$(function(){
		$('#cpf').mask("999.999.999-99");
	});
</script>
<div>
	<form method="post">
		<label style="color: #069;"><strong>CPF:</strong></label><br>
		<input type="text" name="cpf" id="cpf" placeholder="Digite seu CPF" autocomplete="off">
		<br><br>
		<input type="submit" name="enviar" value="Enviar">
	</form>
</div>