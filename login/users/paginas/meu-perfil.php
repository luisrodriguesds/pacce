<?php 
	if (isset($_POST['salvar'])) {
		$form['disc'] = GetPost('disc');
		if (!empty($form['disc'])) {
			if (DBUpDate('bolsistas', $form, "npacce = '".$user['npacce']."'")) {
				load($way.'/meu-perfil');
			}
		}
	}
?>
<div id="preload" class=""></div>
<!-- CORTAR IMAGEM -->
<button type="button" class="btn btn-primary btn-window-crop" id="callCrop" data-toggle="modal" hidden="" data-target="#window-crop"></button>
<!-- Modal -->
<div class="modal fade" id="window-crop" tabindex="-1" role="dialog" aria-labelledby="window-cropTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleCrop">Janela de corte</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="image-holder"><img src="" class="thumb-image"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="crop" data-dismiss="modal">Cortar</button>
      </div>
    </div>
  </div>
</div>

<div class="title"><h2>Meu Perfil</h2></div>

<div id="divCenter">
	<div class="foto-single" style="float: left;">
		<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$user['foto']; ?>"><br></span>
		<div class="nome"><?php echo GetName($user['nome'], $user['nomeUsual']); ?></div>
	</div>
	<div class="form" style="float: left; width: 40%;">
		<form method="post" enctype="multipart/form-data" id="meu-perfil">
			<label>Foto</label><span style="color: red;">*</span> <br>
			<p style="color: red;">Somente nos formatos jpg, jpeg, png</p><br>
			<input type="file" name="imagem" id="imagem"><br><br>
			<div style="display: none;" id="url"><?php echo URL_PAINEL; ?></div>
			<div style="display: none;" id="url2"><?php echo $way; ?></div>
			<div style="display: none;" id="width">150</div>
			<div style="display: none;" id="height">150</div>
			<div style="display: none;" id="npacce"><?php echo $user['npacce']; ?></div>

			<label>Descrição Pessoal</label>
			<textarea placeholder="Digite sua descrição(Campo não obrigatório)" name="disc"><?php echo $user['disc']; ?></textarea>
			<center>
				<input type="submit" name="salvar" value="Salvar">
			</center>
		</form>
	</div>
	<div id="clear"></div>
</div>