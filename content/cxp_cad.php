<h3><img src="lib/iconza/sound_32x32.png" style="vertical-align:sub;"/> Cadastrar nova Caixa Postal</h3>
<?php
	if(isset($_POST["username"])) {
		$msg = "";
		$vm_livre = true;
		
		$voicemails = get_voicemails($local);
		
		foreach($voicemails as $vm) {
			if($vm == $_POST["username"]) {
				$vm_livre = false;
				$msg = "ERRO: Ramal de número ".$_POST["username"]." já possui Caixa Postal!";
				break;
			}
		}
		
		$voicemails = parse_ini_file($local."voicemail.conf", true);
		
		if($vm_livre) {
			$voicemail = ">".$_POST["secret"].",".$_POST["callerid"].",".$_POST["email"];
			
			$voicemails[$_POST["context"]][$_POST["username"]] = $voicemail;
			
			if(write_ini_file($voicemails, $local."voicemail.conf")) {
				$msg = "SUCESSO: Caixa Postal cadastrada para Ramal número ".$_POST["username"]."!";
				shell_exec("/usr/sbin/asterisk -rx 'module reload'");
			}else {
				$msg = "ERRO: Não foi possível cadastrar Caixa Postal para Ramal número ".$_POST["username"].". Tente novamente!";
			}
		}
?>
<div style="text-align: center;">
	<?php echo $msg; ?>
</div><br />
<a href="?p=cxp_lst">&lt;&lt; Voltar para Lista de Caixas Postais</a>
<?php
	}else {
?>
<form action="?p=cxp_cad" method="post">
	<table id="form-table">
		<tr>
			<td id="form-table-title">Ramal:</td>
			<td id="form-table-field">
				<select name="username" >
					<?php
						$iax_extensions = get_iax_extensions($local);
						foreach($iax_extensions as $ie) {
					?>
					<option value="<?php echo $ie; ?>"><?php echo $ie." (IAX)"; ?></option>
					<?php
						}
						$sip_extensions = get_sip_extensions($local);
						foreach($sip_extensions as $se) {
					?>
					<option value="<?php echo $se; ?>"><?php echo $se." (SIP)"; ?></option>
					<?php
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td id="form-table-title">Usuário:</td>
			<td id="form-table-field"><input type="text" id="callerid" name="callerid" /></td>
		</tr>
		<tr>
			<td id="form-table-title">E-mail:</td>
			<td id="form-table-field"><input type="text" id="email" name="email" /></td>
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
				<input type="submit" value="Cadastrar nova Caixa Postal" />
			</td>
		</tr>
	</table>
</form>
<?php
	}
?>
