<h4>Canais</h4>
<table id="arc-table">
	<tr id="arc-table-header">
		<th>Channel</th>
		<th>Location</th>
		<th>State</th>
		<th>Application(Data)</th>
	</tr>
	<?php
		$tam = 0;
		$result = shell_exec("/usr/sbin/asterisk -rx 'core show channels'");
		$result = str_split($result, 81);
		for($i = 1; $i < sizeof($result) - 1; $i++) {
			if($result[$i] != "") {
				$tam++;
	?>
	<tr>
		<td><?php echo trim(substr($result[$i], 0, 21)); ?></td>
		<td><?php echo trim(substr($result[$i], 21, 21)); ?></td>
		<td><?php echo trim(substr($result[$i], 42, 8)); ?></td>
		<td><?php echo trim(substr($result[$i], 50, 30)); ?></td>
	</tr>
	<?php
			}
		}
		if($tam == 0) {
	?>
	<tr>
		<td colspan="4" align="center" >Nenhuma chamada ativa :'(</td>
	</tr>
	<?php
		}
	?>	
</table>
<table id="arc-table">
	<tr id="arc-table-header">
		<th>active channels</th>
		<th>active calls</th>
		<th>calls processed</th>
	</tr>
	<tr>
		<td align="center" >
			<?php
				$p = str_replace(" active channels", "", shell_exec("/usr/sbin/asterisk -rx 'core show channels' | grep 'active channels'"));
				$s = str_replace(" active channels", "", shell_exec("/usr/sbin/asterisk -rx 'core show channels' | grep 'active channel'"));
				echo $p + $s;
			?>
		</td>
		<td align="center" >
			<?php
				$p = str_replace(" active calls", "", shell_exec("/usr/sbin/asterisk -rx 'core show channels' | grep 'active calls'"));
				$s = str_replace(" active call", "", shell_exec("/usr/sbin/asterisk -rx 'core show channels' | grep 'active call'"));
				echo $p + $s;
			?>
		</td>
		<td align="center" >
			<?php
				$p = str_replace(" calls processed", "", shell_exec("/usr/sbin/asterisk -rx 'core show channels' | grep 'calls processed'"));
				$s = str_replace(" call processed", "", shell_exec("/usr/sbin/asterisk -rx 'core show channels' | grep 'call processed'"));
				echo $p + $s;
			?>
		</td>
	</tr>
</table>
<h4>SIP Users</h4>
<table id="arc-table">
	<tr id="arc-table-header">
		<th>Username</th>
		<th>Secret</th>
		<th>Accountcode</th>
		<th>Def.context</th>
		<th>ACL</th>
		<th>ForcePort</th>
	</tr>
	<?php      
		$result = shell_exec("/usr/sbin/asterisk -rx 'sip show users'");
		$result = str_split($result, 94);
		for($i = 1; $i < sizeof($result); $i++) {
	?>
	<tr>
		<td><?php echo trim(substr($result[$i], 0, 27)); ?></td>
		<td><?php echo trim(substr($result[$i], 27, 17)); ?></td>
		<td><?php echo trim(substr($result[$i], 44, 17)); ?></td>
		<td><?php echo trim(substr($result[$i], 61, 17)); ?></td>
		<td><?php echo trim(substr($result[$i], 78, 5)); ?></td>
		<td><?php echo trim(substr($result[$i], 83, 10)); ?></td>
	</tr>
	<?php
		}
	?>
</table>
<h4>SIP Peers</h4>
<table id="arc-table">
	<tr id="arc-table-header">
		<th>Name/Username</th>
		<th>Host</th>
		<th>Dyn</th>
		<th>Forcerport</th>
		<th>ACL</th>
		<th>Port</th>
		<th>Status</th>
	</tr>
	<?php
		$result = shell_exec("/usr/sbin/asterisk -rx 'sip show peers'");
		$result = str_split(" ".$result, 108);
		for($i = 1; $i < sizeof($result) - 1; $i++) {
	?>
	<tr>
		<td><?php echo trim(substr($result[$i], 0, 27)); ?></td>
		<td><?php echo trim(substr($result[$i], 27, 40)); ?></td>
		<td><?php echo trim(substr($result[$i], 67, 4)); ?></td>
		<td><?php echo trim(substr($result[$i], 71, 11)); ?></td>
		<td><?php echo trim(substr($result[$i], 82, 4)); ?></td>
		<td><?php echo trim(substr($result[$i], 86, 9)); ?></td>
		<td><?php echo trim(substr($result[$i], 95, 11)); ?></td>
	</tr>
	<?php
		}
	?>
	<tr>
		<td colspan="7" align="center"><?php echo $result[$i]; ?></td>
	</tr>
</table>
<h4>IAX Users</h4>
<table id="arc-table">
	<tr id="arc-table-header">
		<th>Username</th>
		<th>Secret</th>
		<th>Authen</th>
		<th>Def.context</th>
		<th>A/C</th>
		<th>Codec Pref</th>
	</tr>
	<?php
		$result = shell_exec("/usr/sbin/asterisk -rx 'iax2 show users'");
		$result = str_split(substr($result, 91), 86);
		for($i = 0; $i < sizeof($result); $i++) {
	?>
	<tr>
		<td><?php echo trim(substr($result[$i], 0, 17)); ?></td>
		<td><?php echo trim(substr($result[$i], 17, 22)); ?></td>
		<td><?php echo trim(substr($result[$i], 39, 17)); ?></td>
		<td><?php echo trim(substr($result[$i], 56, 17)); ?></td>
		<td><?php echo trim(substr($result[$i], 73, 7)); ?></td>
		<td><?php echo trim(substr($result[$i], 80, 5)); ?></td>
	</tr>
	<?php
		}
	?>
</table>
<h4>IAX Peers</h4>
<table id="arc-table">
	<tr id="arc-table-header">
		<th>Name/Username</th>
		<th>Host</th>
		<th>Mask</th>
		<th>Port</th>
		<th>Status</th>
	</tr>
	<?php
		$result = shell_exec("/usr/sbin/asterisk -rx 'iax2 show peers'");
		$result = str_split(" ".$result, 81);
		for($i = 1; $i < sizeof($result) - 1; $i++) {
	?>
	<tr>
		<td><?php echo trim(substr($result[$i], 0, 17)); ?></td>
		<td><?php echo trim(substr($result[$i], 17, 21)); ?></td>
		<td><?php echo trim(substr($result[$i], 38, 17)); ?></td>
		<td><?php echo trim(substr($result[$i], 55, 14)); ?></td>
		<td><?php echo trim(substr($result[$i], 69, 11)); ?></td>
	</tr>
	<?php
		}
	?>
	<tr>
		<td colspan="5" align="center"><?php echo $result[$i]; ?></td>
	</tr>
</table>
<h4>Voicemail Users</h4>
<table id="arc-table">
	<tr id="arc-table-header">
		<th>Context</th>
		<th>Mbox</th>
		<th>User</th>
		<th>Zone</th>
		<th>NewMsg</th>
	</tr>
	<?php
		$result = shell_exec("/usr/sbin/asterisk -rx 'voicemail show users'");
		$result = str_split(" ".$result, 61);
		for($i = 1; $i < sizeof($result) - 1; $i++) {
	?>
	<tr>
		<td><?php echo trim(substr($result[$i], 0, 11)); ?></td>
		<td><?php echo trim(substr($result[$i], 11, 6)); ?></td>
		<td><?php echo trim(substr($result[$i], 17, 26)); ?></td>
		<td><?php echo trim(substr($result[$i], 43, 11)); ?></td>
		<td><?php echo trim(substr($result[$i], 54, 7)); ?></td>
	</tr>
	<?php
		}
	?>
	<tr>
		<td colspan="5" align="center"><?php echo $result[$i]; ?></td>
	</tr>
</table>