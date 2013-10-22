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
	// A esta altura si sigue en esta página significa:
	// 1. La sesión está creada, en relación al wiki
	// 2. El usuario es sysop o un profesor registrado
	

	if ($_REQUEST['command'] == 'delete'){
		removepage($_REQUEST['pageid']);
	}else if ($_REQUEST['command'] =='clear'){
		unset($_SESSION['pages']);
	}
// Falta arreglar la página acá abajo
?>

<html>
<META charset="UTF-8">
<head>
<title>P�ginas Elegidas para Evaluaci�n</title>
<script language="javascript">
	function del(pid){
		if (confirm('�Est� seguro que desea eliminar esta p�gina de la lista de p�ginas a evaluar?')){
			document.form.pageid.value=pid;
			document.form.command.value='delete';
			document.form.submit();
		}
	}
	function clearpages(){
		if (confirm('�Est� seguro que desea eliminar todas las p�ginas de la lista de p�ginas a evaluar?')){
			document.form.command.value='clear';
			document.form.submit();
		}
	}
</script>
</head>
<body>
<form name="form" method="post">
	<input type="hidden" name="pageid" />
	<input type="hidden" name="command" />
	<input type="button" value="Seguir Eligiendo P�ginas" onclick="window.location='Paginas.php'" />
	<br />

<?php
	if ( is_array($_SESSION['pages']) ){
		echo '<table border="1">';
		echo '<tr>';
		echo '<td>P�gina</td><td>Acci�n</td>';
		echo '</tr>';
		$max = count($_SESSION['pages']);
		echo "<tr><td>MAX = </td><td>$max</td></tr>";
		for ($i = 0; $i < $max; $i++){
			$pid = $_SESSION['pages'][$i];
			$pagename = getpagename($con, $pid);
			echo '<tr>';
			echo "<td>$pagename</td>";
			echo '<td><input type="button" value="Quitar" onclick="del(' . $pid . ')" /></td>';
			echo '</tr>';			
		}
		echo '</table>';
		echo '<br /><input type="button" value="Quitar Todas" onclick="clearpages()" /><br />';
		echo '<input type="button" value="Evaluar" onclick="window.location=\"Evaluar.php\"" /><br />';
	}else{
		echo 'No hay p�ginas seleccionadas todav�a';
	}
?>
</form>

</body>
</html>
