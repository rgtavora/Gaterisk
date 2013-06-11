<h3><img src="lib/iconza/asterisk_32x32.png" style="vertical-align:sub;"/> Editar Ramal SIP</h3>
<?php
	if(isset($_GET["username"])) {
		$ramal = null;
		$ramais = parse_ini_file($local."sip.conf", true);
		foreach($ramais as $r) {
			if($r == $ramais["general"]) {
				continue;
			}else if($r["username"] == $_GET["username"]) {
				$ramal = $r;
				break;
			}
		}
?>
<form action="?p=sip_edt" method="post">
	<table id="form-table">
		<tr>
			<td id="form-table-title">Ramal:</td>
			<td id="form-table-field"><input type="text" id="username" name="username" maxlength="4" value="<?php echo $ramal["username"]; ?>" disabled /></td>
		</tr>
		<tr>
			<td id="form-table-title">Usuário:</td>
			<td id="form-table-field"><input type="text" id="callerid" name="callerid" value="<?php echo $ramal["callerid"]; ?>" /></td>
		</tr>
		<tr>
			<td id="form-table-title">Senha:</td>
			<td id="form-table-field"><input type="password" id="secret" name="secret" value="<?php echo $ramal["secret"]; ?>" /></td>
		</tr>
		<tr>
			<td id="form-table-title">Contexto:</td>
			<td id="form-table-field">
				<select name="context" >
					<?php
						$contexts = get_context($local);
						foreach($contexts as $context) {
							if($context == $ramal["context"]) {
					?>
					<option value="<?php echo $context; ?>" selected><?php echo $context; ?></option>
					<?php
							}else {
					?>
					<option value="<?php echo $context; ?>" ><?php echo $context; ?></option>
					<?php
							}
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center;">
				<br />
				<input type="hidden" name="username" value="<?php echo $ramal["username"]; ?>" />
				<input type="submit" value="Editar Ramal SIP" />
			</td>
		</tr>
	</table>
</form>
<?php
	}else if(isset($_POST["username"])) {
		$msg = "";
		
		$ramais = parse_ini_file($local."sip.conf", true);
		
		$ramal = array(
			"callerid" => $_POST["callerid"],
			"type" => "friend",
			"username" => $_POST["username"],
			"secret" => $_POST["secret"],
			"canreinvite" => "no",
			"host" => "dynamic",
			"context" => $_POST["context"],
			"dtmfmode" => "rfc2833",
			"call-limit" => "2",
			"nat" => "no"
		);
		$ramais[$_POST["username"]] = $ramal;
		
		if(write_ini_file($ramais, $local."sip.conf")) {
			$msg = "SUCESSO: Ramal SIP número ".$_POST["username"]." editado com sucesso!";
			shell_exec("/usr/sbin/asterisk -rx 'module reload'");
		}else {
			$msg = "ERRO: Não foi possível editar Ramal SIP número ".$_POST["username"].". Tente novamente!";
		}
?>
<div style="text-align: center;">
	<?php echo $msg; ?>
</div><br />
<a href="?p=sip_lst">&lt;&lt; Voltar para Lista de Ramais</a>
<?php
	}
?>
