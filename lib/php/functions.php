<?php
	function write_ini_file($assoc_arr, $path) {
		$content = "";
		
		foreach($assoc_arr as $key => $elem) {
			$content .= "[".$key."]\n";
			foreach($elem as $key2 => $elem2) {
				if(is_array($elem2)) {
					for($i = 0; $i < count($elem2); $i++) {
						$content .= $key2."[]=".$elem2[$i]."\n";
					}
				}
				else if($elem2 == "") $content .= $key2."=no\n";
				else if($elem2 == "1") $content .= $key2."=yes\n";
				else if($key2 == "format") $content .= $key2."=wav49|gsm|wav\n";
				else $content .= $key2."=".$elem2."\n";
			}
			$content .= "\n";
		}
		
		if(!$handle = fopen($path, 'w')) {
			return false;
		}
		if(!fwrite($handle, $content)) {
			return false;
		}
		fclose($handle);
		return true;
	}
	
	function get_context($local) {
		$context_array = array();
		
		$handle = @fopen($local."extensions.conf", "r");
		if ($handle) {
			while(($buffer = fgets($handle, 4096)) !== false) {
				if(strpos($buffer, '[') !== false && strpos($buffer, ']') !== false) {
					$context = substr($buffer, 1, -3);
					if($context == "general") {
						continue;
					}else if($context == "globals") {
						continue;
					}else if(strpos($context, "macro") !== false) {
						continue;
					}else {
						array_push($context_array, $context);
					}
				}
			}
			fclose($handle);
		}
		return $context_array;
	}
	
	function get_sip_extensions($local) {
		$extension_array = array();
		
		$ramais = parse_ini_file($local."sip.conf", true);
		
		foreach($ramais as $r) {
			if($r == $ramais["general"]) {
				continue;
			}else {
				array_push($extension_array, $r["username"]);
			}
		}
		
		return $extension_array;
	}
	
	function get_iax_extensions($local) {
		$extension_array = array();
		
		$ramais = parse_ini_file($local."iax.conf", true);
		
		foreach($ramais as $r) {
			if($r == $ramais["general"]) {
				continue;
			}else {
				array_push($extension_array, $r["username"]);
			}
		}
		
		return $extension_array;
	}
	
	function get_voicemails($local) {
		$voicemail_array = array();
		
		$voicemails = parse_ini_file($local."voicemail.conf", true);
		
		foreach(array_keys($voicemails) as $contexto) {
			if($contexto == "general") {
				continue;
			}else if($contexto == "zonemessages") {
				continue;
			}else {
				foreach(array_keys($voicemails[$contexto]) as $ramal) {
					array_push($voicemail_array, $ramal);
				}
			}
		}
		
		return $voicemail_array;
	}
	
	function read_extensions($local) {
		$extensions = "";
		
		$handle = @fopen($local."extensions.conf", "r");
		if ($handle) {
			while(($buffer = fgets($handle, 4096)) !== false) {
				$extensions .= $buffer;
			}
			fclose($handle);
		}
		return $extensions;
	}
	
	function write_extensions($local, $conf) {
		$extensions = fopen($local."extensions.conf", 'w');
		fwrite($extensions, $conf);
		fclose($extensions);
		return true;
	}
?>
