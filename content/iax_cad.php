<h3><img src="lib/iconza/asterisk_32x32.png" style="vertical-align:sub;"/> Cadastrar novo Ramal IAX</h3>
<?php
	if(isset($_POST["username"])) {
		$msg = "";
		$ramal_livre = true;
		
		$ramais = parse_ini_file($local."iax.conf", true);
		
		foreach($ramais as $r) {
			if($r == $ramais["general"]) {
				continue;
			}else if($r["username"] == $_POST["username"]) {
				$ramal_livre = false;
				$msg = "ERRO: Ramal IAX de número ".$_POST["username"]." já ocupado por outro usuário!";
				break;
			}
		}
		
		if($ramal_livre) {
//			if($_POST["username"] >= 4000 && $_POST["username"] <= 4999) {
				$ramal = array(
					"callerid" => $_POST["callerid"],
					"type" => "friend",
					"accountcode" => $_POST["username"],
					"username" => $_POST["username"],
					"secret" => $_POST["secret"],
					"context" => $_POST["context"],
					"host" => "dynamic",
					"auth" => "md5",
					"notransfer" => "yes"
				);

				$ramais[$_POST["username"]] = $ramal;
				
				if(write_ini_file($ramais, $local."iax.conf")) {
					$msg = "SUCESSO: Ramal IAX número ".$_POST["username"]." cadastrado!";
					shell_exec("/usr/sbin/asterisk -rx 'module reload'");
				}else {
					$msg = "ERRO: Não foi possível cadastrar Ramal IAX número ".$_POST["username"].". Tente novamente!";
				}
//			}else {
//				$msg = "ERRO: Ramal IAX de número ".$_POST["username"]." fora da variação (4000 ~ 4999)!";
//			}
		}
?>
<div style="text-align: center;">
	<?php echo $msg; ?>
</div><br />
<a href="?p=iax_lst">&lt;&lt; Voltar para Lista de Ramais</a>
<?php
	}else {
?>
<form action="?p=iax_cad" method="post">
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
				<input type="submit" value="Cadastrar novo Ramal IAX" />
			</td>
		</tr>
	</table>
</form>
<?php
	}
?>
