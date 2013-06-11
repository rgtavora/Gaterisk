<h3><img src="lib/iconza/asterisk_32x32.png" style="vertical-align:sub;"/> Ramais IAX</h3>
<table id="arc-table">
	<tr>
		<td colspan="5">
			<div align="center">
				<a href="?p=iax_cad">
					<img src="lib/iconza/add_32x32.png" style="padding:4px; vertical-align:middle;"/>
					Cadastrar novo Ramal IAX
				</a>
			</div>
		</td>
	</tr>
	<tr id="arc-table-header">
		<th>Ramal</th>
		<th>Usuário</th>
		<th>Context</th>
		<th>Editar</th>
		<th>Remover</th>
	</tr>
	<?php
		$ramais = parse_ini_file($local."iax.conf", true);
		
		foreach($ramais as $ramal) {
			if($ramal == $ramais["general"]) {
				continue;
			}else {
	?>
	<tr>
		<td><?php echo $ramal["username"]; ?></td>
		<td><?php echo $ramal["callerid"]; ?></td>
		<td><?php echo $ramal["context"]; ?></td>
		<td style="text-align:center;">
			<a href="?p=iax_edt&amp;username=<?php echo $ramal["username"]; ?>">
				<img src="lib/iconza/edit_32x32.png">
			</a>
		</td>
		<td style="text-align:center;">
			<a href="?p=iax_rem&amp;username=<?php echo $ramal["username"]; ?>">
				<img src="lib/iconza/cancel_32x32.png">
			</a>
		</td>
	</tr>
	<?php
			}
		}
	?>
</table>