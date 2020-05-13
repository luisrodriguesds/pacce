<?php 
	if (isset($_POST['cpf'])) {
		$cpf					= GetPost('cpf');
		$form['funcao1']		= GetPost('funcao1');
		$form['funcao2']		= GetPost('funcao2');
		$form['justificativa']	= GetPost('justificativa');

		$npacce 			= DBread('bolsistas', "WHERE cpf = '".$cpf."'", 'npacce, cpf, campus');
		$form['npacce'] 	= $npacce[0]['npacce'];
		$form['campus']		= $npacce[0]['campus'];
		$form['status'] 	= 1;
		$form['registro'] 	= date('Y-m-d H:i:s');

		if (DBread('ren_insc', "WHERE npacce = '".$form['npacce']."'")) {
			alertaLoad('Você já está cadastrado no processo de renovação! \nAtt PACCE \n\n Developed by Luis Rodrigues.', URLBASE.'login');
		}else{
			if (DBcreate('ren_insc', $form)) {
				alertaLoad('!!!!!!!!!!!!!!!Parabéns!!!!!!!!!!!!!!! \n Sua inscrição foi efetuada com sucesso! \n Fique atento nas datas citadas no edital. \nAguarde e-mail de confirmação. Será enviado em até 3 dias úteis. \n\n Att PACCE. \n\n Developed by Luis Rodrigues.', URLBASE.'login');
			}
		}
	}
?>

<hr>
<form method="post" name="pacce-veteranos" id="pacce-veteranos">
  <div class="form-divider text-center">
    Inscrição PACCE - VETERANOS
  </div>
  <hr>
  <div class="form-divider">
    Dados Pessoais
  </div>
  <div class="row">
  	<div class="form-group col-6">
      <label for="cpf" class="black">CPF</label>
      <label></label>
      <input id="cpf" type="text" class="form-control field-required" name="cpf" autocomplete="off">
    </div>
    <div class="form-group col-6">
      <label for="npacce" class="black">Número PACCE</label>
      <label></label>
      <input id="npacce" type="text" class="form-control field-required" disabled="" name="npacce" autocomplete="nope">
    </div>
    <div class="form-group col-12">
      <label for="nome" class="black">Nome Completo</label>
      <label></label>
      <input id="nome" type="text" class="form-control field-required" disabled="" name="nome" autocomplete="nope">
    </div>

    <div class="form-group col-6">
      <label class="black">Função 1</label>
      <label>Selecione a primeira opção que deseja concorrer.</label>
      <select class="form-control field-required" name="funcao1">
        <option value="">Selecione uma função ...</option>
        <?php 
			$comissoes = DBread('comissoes', "WHERE status = true AND comissaoSlug != 'ceo' ORDER BY comissao ASC");
			for ($i=0; $i < count($comissoes); $i++) { 
			?>
			<option <?php echo printSelect(GetPost('funcao1'), $comissoes[$i]['comissao']); ?> value="<?php echo $comissoes[$i]['comissao']; ?>"><?php echo $comissoes[$i]['comissao']; ?></option>
			<?php 
			}
		?>
      </select>
    </div>
    <div class="form-group col-6">
      <label class="black">Função 2</label>
      <label>Selecione a segunda opção que deseja concorrer.</label>
      <select class="form-control field-required" name="funcao2">
        <option value="">Selecione uma função ...</option>
			<?php 
				$comissoes = DBread('comissoes', "WHERE status = true AND comissaoSlug != 'ceo' ORDER BY comissao ASC");
				for ($i=0; $i < count($comissoes); $i++) { 
				?>
				<option value="<?php echo $comissoes[$i]['comissao']; ?>"><?php echo $comissoes[$i]['comissao']; ?></option>
				<?php 
			}
			?>
      </select>
    </div>
    <div class="form-group col-12">
      <label for="justificativa" class="black">Justificativa</label>
      <label>Justifique sua renovação da bolsa em termos de ações desenvolvidas durante o ano em que você foi bolsista. No máximo 500 caracteres </label>
      <textarea name="justificativa" class="form-control field-required" placeholder=""></textarea>
    </div>
  </div>
  <div class="form-divider">
    Histórico e Edital
  </div>
  <div class="row">
      <div class="form-group col-12">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" name="historico" class="custom-control-input field-required" id="historico">
          <label class="custom-control-label" for="historico">Estou ciente que preciso enviar meu Histórico Escolar conforme item 5.3.a do Edital após o envio deste formulário.</label>
        </div>
      </div>
      <div class="form-group col-12">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" name="lidoEdital" class="custom-control-input field-required" id="lidoEdital">
          <label class="custom-control-label" for="lidoEdital">Declaro ter lido e estar de acordo com o Edital de Seleção.</label>
        </div>
      </div>
      <div class="form-group col-12">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" name="usodeimagem" class="custom-control-input field-required" id="usodeimagem">
          <label class="custom-control-label" for="usodeimagem">Declaro que o programa pode fazer uso da minha imagem dentro de seu sistema e suas redes sociais.</label>
        </div>
      </div>
      <div class="form-group col-12">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" name="bia" class="custom-control-input field-required" id="bia">
          <label class="custom-control-label" for="bia">Estou ciente que preciso fazer/ter feito minha inscrição na BIA para, se aprovado no edital da BIA, ser efetivado e receber uma bolsa.</label>
        </div>
      </div>
  </div>
  <div class="form-group">
    <button type="submit" name="enviar" class="btn btn-primary btn-block">Enviar</button>
  </div>
</form>