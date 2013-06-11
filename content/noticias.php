<h3><img src="../lib/img/iconza/newspaper_32x32.png" alt="Notícias" style="vertical-align:sub;"/> Notícias</h3>
<?php
	if(isset($_POST["acao"])) {
		$msg = "";
		if($_POST["acao"] == 1) {
			/*
			 * 
			 * INSERT
			 * 
			 */
			$sql = "INSERT INTO noticias(titulo, chamada, noticia, autor, datahora, views)
					VALUES('".$_POST["titulo"]."', '".$_POST["chamada"]."', '".$_POST["content"]."', ".$_SESSION["id"].", now(), 0)";
			mysql_query($sql);
			
			$sql = "SELECT id
					FROM noticias
					WHERE titulo LIKE '".$_POST["titulo"]."'
					AND chamada LIKE '".$_POST["chamada"]."'";
			$id = mysql_result(mysql_query($sql), 0, "id");
			
			$sql = "INSERT INTO log_admin(administrador, acao)
					VALUES(".$_SESSION["id"].", 'Cadastrou uma notícia (".$id.", ".$_POST["titulo"].")')";
			
			mysql_query($sql);
			
			$msg = "Notícia cadastrada com sucesso!";
		}else if($_POST["acao"] == 2) {
			/*
			 * 
			 * UPDATE
			 * 
			 */
			$sql = "UPDATE noticias
					SET titulo = '".$_POST["titulo"]."',
						chamada = '".$_POST["chamada"]."',
						noticia = '".$_POST["content"]."'
					WHERE id = ".$_POST["id"];
			
			mysql_query($sql);
			
			$sql = "INSERT INTO log_admin(administrador, acao)
					VALUES(".$_SESSION["id"].", 'Editou uma notícia (".$_POST["id"].", ".$_POST["titulo"].")')";
			mysql_query($sql);
			echo $sql;
			
			$msg = "Notícia editada com sucesso!";
		}else if($_POST["acao"] == 3) {
			/*
			 * 
			 * DELETE
			 * 
			 */
			$sql = "DELETE FROM noticias
					WHERE id = ".$_POST["id"];
			mysql_query($sql);
			
			$sql = "INSERT INTO log_admin(administrador, acao)
					VALUES(".$_SESSION["id"].", 'Excluiu uma notícia (".$_POST["id"].", ".$_POST["titulo"].")')";
			mysql_query($sql);
			
			$msg = "Notícia excluída com sucesso!";
		}
	}
	
	if(!isset($_GET["acao"])) {
		/*
		 * 
		 * ARQUIVO
		 * 
		 */
		if(isset($_POST["order1"]))
			$order1 = $_POST["order1"];
		else
			$order1 = "n.titulo";
			
		if(isset($_POST["order2"]))
			$order2 = $_POST["order2"];
		else
			$order2 = "ASC";
	
		$sql = "SELECT n.id, n.datahora, n.titulo, a.nome
				FROM noticias n, administradores a
				WHERE n.autor = a.id
				ORDER BY ".$order1." ".$order2;
		$rs = mysql_query($sql);
?>
<table id="arc-table">
	<tr>
		<td colspan="6">
			<div align="center">
				<a href="?p=noticias&amp;acao=1">
					<img src="../lib/img/iconza/add_32x32.png" alt="Nova Notícia" style="padding:4px; vertical-align:middle;"/>
					Cadastrar nova Notícia
				</a>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="6">
			<div align="right">
				<form action="?p=noticias" method="post">
					<select id="order1" name="order1">
						<option value="n.titulo" <?php if($order1 == "n.titulo") echo "selected"; ?> >Título</option>
						<option value="n.id" <?php if($order1 == "n.id") echo "selected"; ?> >ID</option>
						<option value="n.datahora" <?php if($order1 == "n.datahora") echo "selected"; ?> >Data/Hora</option>
						<option value="a.nome" <?php if($order1 == "a.nome") echo "selected"; ?> >Autor</option>
					</select>
					<select id="order2" name="order2">
						<option value="ASC" <?php if($order2 == "ASC") echo "selected"; ?> >Crescente</option>
						<option value="DESC" <?php if($order2 == "DESC") echo "selected"; ?> >Decrescente</option>
					</select>
					<input type="submit" value="Ordenar" />
				</form>
			</div>
		</td>
	</tr>
	<tr id="arc-table-header">
		<th>ID</th>
		<th>Título</th>
		<th>Data/Hora</th>
		<th>Autor</th>
		<th>Editar</th>
		<th>Excluir</th>
	</tr>
	<?php
		if(mysql_num_rows($rs)) {
			for($i = 0; $i <mysql_num_rows($rs); $i++) {
	?>
	<tr>
		<td style="text-align:center;"><?= mysql_result($rs, $i, "id") ?></td>
		<td><?= mysql_result($rs, $i, "titulo") ?></td>
		<td>
			<?= date("d/m/Y", strtotime(mysql_result($rs, $i, "datahora"))) ?>
			<?= date("H:i:s", strtotime(mysql_result($rs, $i, "datahora"))) ?>
		</td>
		<td><?= mysql_result($rs, $i, "nome") ?></td>
		<td style="text-align:center;">
			<a href="?p=noticias&amp;acao=2&amp;id=<?= mysql_result($rs, $i, "id") ?>">
				<img src="../lib/img/iconza/edit_32x32.png" alt="Editar">
			</a>
		</td>
		<td style="text-align:center;">
			<a href="?p=noticias&amp;acao=3&amp;id=<?= mysql_result($rs, $i, "id") ?>">
				<img src="../lib/img/iconza/cancel_32x32.png" alt="Desativar">
			</a>
		</td>
	</tr>
	<?php
			}
		}
	?>
</table>
<?php
	}else {
		$acao = $_GET["acao"];
		if($acao == 1) {
			/*
			 * 
			 * CADASTRAR
			 * 
			 */
?>
<script type="text/javascript" src="../lib/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
<!--
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,spellchecker,pagebreak,table,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,searchreplace,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
	
		// Theme options
		theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,forecolor,backcolor,|,insertdate,inserttime,preview",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,charmap,emotions",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resize_horizontal : false,
		theme_advanced_resizing : true,
	
		// Skin options
		skin : "o2k7"
	
	});

	function validar() {
		if(document.getElementById("titulo").value == "") {
			window.alert('Título obrigatório!');
			document.getElementById("titulo").focus();
			return false;
		}else if(document.getElementById("chamada").value == "") {
			window.alert('Chamada obrigatória!');
			document.getElementById("chamada").focus();
			return false;
		}else return true;
	}
//-->
</script>
<form action="?p=noticias" method="post" onsubmit="return validar();">
	<table id="form-table">
		<tr>
			<td id="form-table-title">Título:</td>
			<td id="form-table-field"><input type="text" id="titulo" name="titulo" maxlength="120" size="80" /></td>
		</tr>
		<tr>
			<td id="form-table-title">Chamada:</td>
			<td id="form-table-field"><input type="text" id="chamada" name="chamada" size="80" /></td>
		</tr>
		<tr>
			<td colspan="2"><textarea id="sobre" name="content" style="width:100%;"></textarea></td>
		</tr>
		<tr>
			<td id="form-table-title"></td>
			<td id="form-table-field">Não esqueça de citar a fonte da notícia!</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center;">
				<br />
				<input type="hidden" id="acao" name="acao" value="1" />
				<input type="submit" value="Cadastrar nova Notícia" />
			</td>
		</tr>
	</table>
</form>
<?php
		}else if($acao == 2) {
			/*
			 * 
			 * EDITAR
			 * 
			 */
			$sql = "SELECT id, titulo, chamada, noticia
					FROM noticias
					WHERE id =".$_GET["id"];
			$rs = mysql_query($sql);
?>
<script type="text/javascript" src="../lib/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
<!--
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,spellchecker,pagebreak,table,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,searchreplace,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
	
		// Theme options
		theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,forecolor,backcolor,|,insertdate,inserttime,preview",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,charmap,emotions",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resize_horizontal : false,
		theme_advanced_resizing : true,
	
		// Skin options
		skin : "o2k7"

	});

	function validar() {
		if(document.getElementById("titulo").value == "") {
			window.alert('Título obrigatório!');
			document.getElementById("titulo").focus();
			return false;
		}else if(document.getElementById("chamada").value == "") {
			window.alert('Chamada obrigatória!');
			document.getElementById("chamada").focus();
			return false;
		}else return true;
	}
//-->
</script>
<form action="?p=noticias" method="post" onsubmit="return validar();">
	<table id="form-table">
		<tr>
			<td id="form-table-title">ID:</td>
			<td id="form-table-field">
				<input type="text" value="<?= mysql_result($rs, 0, "id") ?>" disabled="disabled" />
				<input type="hidden" id="id" name="id" value="<?= mysql_result($rs, 0, "id") ?>" />
			</td>
		</tr>
		<tr>
			<td id="form-table-title">Título:</td>
			<td id="form-table-field"><input type="text" id="titulo" name="titulo" maxlength="120" size="80" value="<?= mysql_result($rs, 0, "titulo") ?>" /></td>
		</tr>
		<tr>
			<td id="form-table-title">Chamada:</td>
			<td id="form-table-field"><input type="text" id="chamada" name="chamada" size="80" value="<?= mysql_result($rs, 0, "chamada") ?>" /></td>
		</tr>
		<tr>
			<td colspan="2"><textarea id="sobre" name="content" style="width:100%;"><?= mysql_result($rs, 0, "noticia") ?></textarea></td>
		</tr>
		<tr>
			<td id="form-table-title"></td>
			<td id="form-table-field">Não esqueça de citar a fonte da notícia!</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center;">
				<br />
				<input type="hidden" id="acao" name="acao" value="2" />
				<input type="submit" value="Editar Notícia" />
			</td>
		</tr>
	</table>
</form>
<?php
		}else if($acao == 3) {
			/*
			 * 
			 * EXCLUIR
			 * 
			 */
			$sql = "SELECT *
					FROM noticias
					WHERE id = ".$_GET["id"];
			$rs = mysql_query($sql);
?>
<div style="text-align: center;">
	Deseja realmente excluir a notícia "<b><?= mysql_result($rs, 0, "titulo") ?></b>"
	e ID número <b><?= mysql_result($rs, 0, "id") ?></b>?<br />
	<div style="color:#F00;">Será gerada uma entrada no log para esta ação.</div>
	<br />	
	<form action="?p=noticias" method="post">
		<input type="hidden" id="acao" name="acao" value="3" />
		<input type="hidden" id="id" name="id" value="<?= mysql_result($rs, 0, "id") ?>" />
		<input type="hidden" id="titulo" name="titulo" value="<?= mysql_result($rs, 0, "titulo") ?>" />
		<input type="submit" value="Excluir Notícia" />
	</form>
</div>
<?php
		}
	}
?>