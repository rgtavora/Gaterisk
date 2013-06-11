<?php
	//$local = "asterisk/";
	$local = "/etc/asterisk/";

	include_once 'lib/php/functions.php';
	if(isset($_GET["p"])) {
		$p = $_GET["p"];
	}else {
		$p = "inicio";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Gaterisk</title>
<link type="text/css" rel="stylesheet" href="lib/css/gaterisk.css"/>
<script type="text/javascript" src="lib/js/jquery-1.10.1.min.js"></script>
</head>
<body>
	<div id="wrapper">
		<div id="header"></div>
		<div id="top-menu">
			<div id="top-menu-item"><a href="?p=inicio">Início</a></div>
			<div id="top-menu-rule"></div>
			<div id="top-menu-item"><a href="?p=sip_lst">Ramais SIP</a></div>
			<div id="top-menu-rule"></div>
			<div id="top-menu-item"><a href="?p=iax_lst">Ramais IAX</a></div>
			<div id="top-menu-rule"></div>
			<div id="top-menu-item"><a href="?p=cxp_lst">Caixas Postais</a></div>
			<div id="top-menu-rule"></div>
			<div id="top-menu-item"><a href="?p=plan_disc">Plano de Discagem</a></div>
			<div id="top-menu-rule"></div>
			<div id="top-menu-item"><a href="?p=monitor">Monitoramento</a></div>
		</div>
		<div id="content">
			<?php
				include_once 'content/'.$p.'.php';
			?>
			<br /><br />
		</div>
		<div id="footer">
			Redes Convergentes - 2013.1<br />
			Prof.: <a href="http://www.g4flex.com.br/" target="_blank" >Geneflides Silva</a><br />
			Alunos: Marília Feitoza & <a href="http://rodrigogato.com.br" target="_blank" >Rodrigo Gato</a>
		</div>
	</div>
</body>
</html>
