<h3><img src="lib/iconza/asterisk_32x32.png" style="vertical-align:sub;"/> Remover Ramal SIP</h3>
<?php
	if(isset($_GET["username"])) {
?>
<div style="text-align: center;">
	Deseja realmente remover Ramal SIP n�mero <?php echo $_GET["username"]; ?>?
	<br /><br />
	<form action="?p=sip_rem" method="post">
		<input type="hidden" name="username" value="<?php echo $_GET["username"]; ?>" />
		<input type="submit" value="Remover Ramal SIP" />
	</form>
</div>
<?php
	}else if(isset($_POST["username"])) {
		$msg = "";
		
		$ramais = parse_ini_file($local."sip.conf", true);
		
		unset($ramais[$_POST["username"]]);
		
		if(write_ini_file($ramais, $local."sip.conf")) {
			$msg = "SUCESSO: Ramal SIP n�mero ".$_POST["username"]." removido com sucesso!";
			shell_exec("/usr/sbin/asterisk -rx 'module reload'");
		}else {
			$msg = "ERRO: N�o foi poss�vel remover Ramal SIP n�mero ".$_POST["username"].". Tente novamente!";
		}
?>
<div style="text-align: center;">
	<?php echo $msg; ?>
</div><br />
<a href="?p=sip_lst">&lt;&lt; Voltar para Lista de Ramais</a>
<?php
	}
?>
