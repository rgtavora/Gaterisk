<h3><img src="lib/iconza/asterisk_32x32.png" style="vertical-align:sub;"/> Cadastrar novo Ramal SIP</h3>
<?php
	if(isset($_POST["username"])) {
		$msg = "";
		$ramal_livre = true;
		
		$ramais = parse_ini_file($local."sip.conf", true);
		
		foreach($ramais as $r) {
			if($r == $ramais["general"]) {
				continue;
			}else if($r["username"] == $_POST["username"]) {
				$ramal_livre = false;
				$msg = "ERRO: Ramal SIP de número ".$_POST["username"]." já ocupado por outro usuário!";
				break;
			}
		}
		
		if($ramal_livre) {
//			if($_POST["username"] >= 8000 && $_POST["username"] <= 8999) {
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
					$msg = "SUCESSO: Ramal SIP número ".$_POST["username"]." cadastrado!";
					shell_exec("/usr/sbin/asterisk -rx 'module reload'");
				}else {
					$msg = "ERRO: Não foi possível cadastrar Ramal SIP número ".$_POST["username"].". Tente novamente!";
				}
//			}else {
//				$msg = "ERRO: Ramal SIP de número ".$_POST["username"]." fora da variação (8000 ~ 8999)!";
//			}
		}
?>
<div style="text-align: center;">
	<?php echo $msg; ?>
</div><br />
<a href="?p=sip_lst">&lt;&lt; Voltar para Lista de Ramais</a>
<?php
	}else {
?>
<form action="?p=sip_cad" method="post">
	<table id="form-table">
		<tr>
			<td id="form-table-title">Ramal:</td>
			<td id="form-table-field"><input type="text" id="username" name="username" /></td>
		</tr>
		<tr>
			<td id="form-table-title">Usuário:</td>
			<td id="form-table-field"><input type="text" id="callerid" name="callerid" /></td>
		</tr>
		<tr>
			<td id="form-table-title">Senha:</td>
			<td id="form-table-field"><input type="password" id="secret" name="secret" /></td>
		</tr>
		<tr>
			<td id="form-table-title">Contexto:</td>
			<td id="form-table-field">
				<select name="context" >
					<?php
						$contexts = get_context($local);
						foreach($contexts as $context) {
					?>
					<option value="<?php echo $context; ?>"><?php echo $context; ?></option>
					<?php
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center;">
				<br />
				<input type="submit" value="Cadastrar novo Ramal SIP" />
			</td>
		</tr>
	</table>
</form>
<?php
	}
?>
