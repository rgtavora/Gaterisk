<h3><img src="lib/iconza/sound_32x32.png" style="vertical-align:sub;"/> Caixas Postais</h3>
<table id="arc-table">
	<tr>
		<td colspan="6">
			<div align="center">
				<a href="?p=cxp_cad">
					<img src="lib/iconza/add_32x32.png" style="padding:4px; vertical-align:middle;"/>
					Cadastrar nova Caixa Postal
				</a>
			</div>
		</td>
	</tr>
	<tr id="arc-table-header">
		<th>Contexto</th>
		<th>Ramal</th>
		<th>Usuário</th>
		<th>E-mail</th>
		<th>Editar</th>
		<th>Remover</th>
	</tr>
	<?php
		$vms = parse_ini_file($local."voicemail.conf", true);
		
		foreach(array_keys($vms) as $contexto) {
			if($contexto == "general") {
				continue;
			}else if($contexto == "zonemessages") {
				continue;
			}else {
				foreach(array_keys($vms[$contexto]) as $ramal) {
					$conf = explode(",", $vms[$contexto][$ramal]);
	?>
	<tr>
		<td><?php echo $contexto; ?></td>
		<td><?php echo $ramal; ?></td>
		<td><?php echo $conf[1]; ?></td>
		<td><?php echo $conf[2]; ?></td>
		<td style="text-align:center;">
			<a href="?p=cxp_edt&amp;username=<?php echo $ramal; ?>">
				<img src="lib/iconza/edit_32x32.png">
			</a>
		</td>
		<td style="text-align:center;">
			<a href="?p=cxp_rem&amp;username=<?php echo $ramal; ?>">
				<img src="lib/iconza/cancel_32x32.png">
			</a>
		</td>
	</tr>
	<?php
				}
			}
		}
	?>
</table>
