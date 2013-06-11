<h3><img src="lib/iconza/script_32x32.png" style="vertical-align:sub;"/> Plano de Discagem</h3>
<?php
	if(isset($_POST["extensions"])) {
		$msg = "";
		
		if(write_extensions($local, $_POST["extensions"])) {
			$msg = "SUCESSO: Plano de Discagem editado!";
			shell_exec("/usr/sbin/asterisk -rx 'module reload'");
		}else {
			$msg = "ERRO: Não foi possível editar Plano de Discagem. Tente novamente!";
		}
?>
<div style="text-align: center;">
	<?php echo $msg; ?>
</div><br />
<a href="?p=plan_disc">&lt;&lt; Voltar para Plano de Discagem</a>
<?php
	}else {
?>
<form action="?p=plan_disc" method="post">
	<table id="arc-table">
		<tr id="arc-table-header">
			<th>extensions.conf</th>
		</tr>
		<tr>
			<td align="center">
				<textarea style="resize:vertical; width:99%;" name="extensions" rows="40" ><?php echo read_extensions($local); ?></textarea>
				<br /><br />
				<input type="submit" value="Editar Plano de Discagem" />
			</td>
		</tr>
		<tr>
			<td>
				<div align="center">
					<img src="lib/iconza/warning_32x32.png" style="padding:4px; vertical-align:middle;"/>
					Cuidado! Só salve se tiver certeza! Qualquer alteração pode ser prejudicial!
				</div>
			</td>
		</tr>
	</table>
</form>
<?php
	}
?>
