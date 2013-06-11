<h3><img src="lib/iconza/sound_32x32.png" style="vertical-align:sub;"/> Remover Caixa Postal</h3>
<?php
	if(isset($_GET["username"])) {
?>
<div style="text-align: center;">
	Deseja realmente remover Caixa Postal de Ramal número <?php echo $_GET["username"]; ?>?
	<br /><br />
	<form action="?p=cxp_rem" method="post">
		<input type="hidden" name="username" value="<?php echo $_GET["username"]; ?>" />
		<input type="submit" value="Remover Caixa Postal" />
	</form>
</div>
<?php
	}else if(isset($_POST["username"])) {
		$msg = "";
		
		$voicemails = parse_ini_file($local."voicemail.conf", true);
		
		foreach(array_keys($voicemails) as $contexto) {
			if($contexto == "general") {
				continue;
			}else if($contexto == "zonemessages") {
				continue;
			}else {
				foreach(array_keys($voicemails[$contexto]) as $ramal) {
					if($_POST["username"] == $ramal) {
						$context = $contexto;
						break;
					}
				}
			}
		}
		
		unset($voicemails[$context][$_POST["username"]]);
		
		if(write_ini_file($voicemails, $local."voicemail.conf")) {
			$msg = "SUCESSO: Caixa Postal de Ramal número ".$_POST["username"]." removida!";
			shell_exec("/usr/sbin/asterisk -rx 'module reload'");
		}else {
			$msg = "ERRO: Não foi possível remover Caixa Postal para Ramal número ".$_POST["username"].". Tente novamente!";
		}
?>
<div style="text-align: center;">
	<?php echo $msg; ?>
</div><br />
<a href="?p=cxp_lst">&lt;&lt; Voltar para Lista de Caixas Postais</a>
<?php
	}
?>
