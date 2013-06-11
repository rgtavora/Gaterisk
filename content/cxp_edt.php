<h3><img src="lib/iconza/sound_32x32.png" style="vertical-align:sub;"/> Editar Caixa Postal</h3>
<?php
	if(isset($_GET["username"])) {
		$vms = parse_ini_file($local."voicemail.conf", true);
		
		foreach(array_keys($vms) as $contexto) {
			if($contexto == "general") {
				continue;
			}else if($contexto == "zonemessages") {
				continue;
			}else {
				foreach(array_keys($vms[$contexto]) as $ramal) {
					if($_GET["username"] == $ramal) {
						$conf = explode(",", $vms[$contexto][$ramal]);
						$context = $contexto;
						break;
					}
				}
			}
		}
?>
<form action="?p=cxp_edt" method="post">
	<table id="form-table">
		<tr>
			<td id="form-table-title">Contexto:</td>
			<td id="form-table-field"><input type="text" value="<?php echo $context; ?>" disabled /></td>
		</tr>
		<tr>
			<tr>
			<td id="form-table-title">Ramal:</td>
			<td id="form-table-field"><input type="text" value="<?php echo $ramal; ?>" disabled /></td>
		</tr>
		</tr>
		<tr>
			<td id="form-table-title">Usuário:</td>
			<td id="form-table-field"><input type="text" id="callerid" name="callerid" value="<?php echo $conf[1]; ?>" /></td>
		</tr>
		<tr>
			<td id="form-table-title">E-mail:</td>
			<td id="form-table-field"><input type="text" id="email" name="email" value="<?php echo $conf[2]; ?>" /></td>
		</tr>
		<tr>
			<td id="form-table-title">Senha:</td>
			<td id="form-table-field"><input type="password" id="secret" name="secret" value="<?php echo substr($conf[0], 1); ?>" /></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center;">
				<br />
				<input type="hidden" id="username" name="username" value="<?php echo $ramal; ?>" />
				<input type="hidden" id="context" name="context" value="<?php echo $context; ?>" />
				<input type="submit" value="Editar Caixa Postal" />
			</td>
		</tr>
	</table>
</form>
<?php
	}else if(isset($_POST["username"])) {
		$msg = "";
		
		$voicemails = parse_ini_file($local."voicemail.conf", true);
		
		$voicemail = ">".$_POST["secret"].",".$_POST["callerid"].",".$_POST["email"];
		
		$voicemails[$_POST["context"]][$_POST["username"]] = $voicemail;
		
		if(write_ini_file($voicemails, $local."voicemail.conf")) {
			$msg = "SUCESSO: Caixa Postal cadastrada para Ramal número ".$_POST["username"]."!";
			shell_exec("/usr/sbin/asterisk -rx 'module reload'");
		}else {
			$msg = "ERRO: Não foi possível cadastrar Caixa Postal para Ramal número ".$_POST["username"].". Tente novamente!";
		}
?>
<div style="text-align: center;">
	<?php echo $msg; ?>
</div><br />
<a href="?p=cxp_lst">&lt;&lt; Voltar para Lista de Caixas Postais</a>
<?php
	}
?>
