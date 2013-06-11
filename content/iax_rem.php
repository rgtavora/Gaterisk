<h3><img src="lib/iconza/asterisk_32x32.png" style="vertical-align:sub;"/> Remover Ramal IAX</h3>
<?php
	if(isset($_GET["username"])) {
?>
<div style="text-align: center;">
	Deseja realmente remover Ramal IAX número <?php echo $_GET["username"]; ?>?
	<br /><br />
	<form action="?p=iax_rem" method="post">
		<input type="hidden" name="username" value="<?php echo $_GET["username"]; ?>" />
		<input type="submit" value="Remover Ramal IAX" />
	</form>
</div>
<?php
	}else if(isset($_POST["username"])) {
		$msg = "";
		
		$ramais = parse_ini_file($local."iax.conf", true);
		
		unset($ramais[$_POST["username"]]);
		
		if(write_ini_file($ramais, $local."iax.conf")) {
			$msg = "SUCESSO: Ramal IAX número ".$_POST["username"]." removido com sucesso!";
			shell_exec("/usr/sbin/asterisk -rx 'module reload'");
		}else {
			$msg = "ERRO: Não foi possível remover Ramal IAX número ".$_POST["username"].". Tente novamente!";
		}
?>
<div style="text-align: center;">
	<?php echo $msg; ?>
</div><br />
<a href="?p=iax_lst">&lt;&lt; Voltar para Lista de Ramais</a>
<?php
	}
?>
