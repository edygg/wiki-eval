<?php
	include_once "./historyfunctions.php";
	$uid = checkLoggedToWiki();
	if ($uid == -1)
		header("location:error.php?ev=1");
	$con=mysqli_connect("localhost", "wikiphp", "Wixi+php2013", "iscwiki");
	if (mysqli_connect_errno($con)){
		header("location:error.php?ev=3306");
	}
	$so = checkSysOp($uid, $con);
	$uname = checkProfessor($uid, $con);
	if (! $so && $uname == "")
		header("location:error.php?ev=2");
	// A esta altura si sigue en esta pÃ¡gina significa:
	// 1. La sesiÃ³n estÃ¡ creada, en relaciÃ³n al wiki
	// 2. El usuario es sysop o un profesor registrado
	

	if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'delete'){
		removepage($_REQUEST['pageid']);
	}else if (isset($_REQUEST['command']) && $_REQUEST['command'] =='clear'){
		unset($_SESSION['pages']);
	}
?>

<html>
<META charset="UTF-8">
<head>
<title>Páginas Elegidas para Evaluación</title>
<script language="javascript">
	function del(pid){
		if (confirm('¿Está seguro que desea eliminar esta página de la lista de páginas a evaluar?')){
			document.form.pageid.value=pid;
			document.form.command.value='delete';
			document.form.submit();
		}
	}
	function clearpages(){
		if (confirm('¿Está seguro que desea eliminar todas las páginas de la lista de páginas a evaluar?')){
			document.form.command.value='clear';
			document.form.submit();
		}
	}
	function assess(){
		window.location="Parametros.php";
	}
</script>
</head>
<body>
<form name="form" method="post">
	<input type="hidden" name="pageid" />
	<input type="hidden" name="command" />
	<input type="button" value="Seguir Eligiendo Páginas" onclick="window.location='Paginas.php'" />
	<br />

<?php
	if ( is_array($_SESSION['pages']) ){
		echo '<table border="1">';
		echo '<tr>';
		echo '<td>Página</td><td>Acción</td>';
		echo '</tr>';
		$max = count($_SESSION['pages']);
		for ($i = 0; $i < $max; $i++){
			$pid = $_SESSION['pages'][$i];
			$pagename = str_replace("_", " ", getpagename($con, $pid));
			echo '<tr>';
			echo "<td>$pagename</td>";
			echo '<td><input type="button" value="Quitar" onclick="del(' . $pid . ')" /></td>';
			echo '</tr>';			
		}
		echo '</table>';
		echo '<br /><input type="button" value="Quitar Todas" onclick="clearpages()" /><br />';
		echo '<input type="button" value="Establecer Parámetros" onclick="assess()" /><br />';
	}else{
		echo 'No hay páginas seleccionadas todavía';
	}
?>
</form>

</body>
</html>
