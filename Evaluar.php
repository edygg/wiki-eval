
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
	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<meta charset="UTF-8">
<head>
<title>Establecer Parámetros de Evaluación</title>
<meta name="generator" content="Bluefish 2.2.3" >
<html>
<head>
<title>Evaluación</title>
</head>
<body>
<?php
	$wikigrade = $_REQUEST['points'];
	// Contenido
	$content_r = $_REQUEST['content_rubric'];
	$content_g = $_REQUEST['content_grade'];
	$content_w = $_REQUEST['content_weight'];
	// Presentación
	$present_r = $_REQUEST['present_rubric'];
	$present_g = $_REQUEST['present_grade'];
	$present_w = $_REQUEST['present_weight'];
	// Colaboración
	$colab_r = $_REQUEST['colab_rubric'];
	$colab_g = $_REQUEST['colab_grade'];
	$colab_w = $_REQUEST['colab_weight'];
	// Organización
	$orga_r = $_REQUEST['orga_rubric'];
	$orga_g = $_REQUEST['orga_grade'];
	$orga_w = $_REQUEST['orga_weight'];
	// Referencias
	$refer_r = $_REQUEST['refer_rubric'];
	$refer_g = $_REQUEST['refer_grade'];
	$refer_w = $_REQUEST['refer_weight'];
	// Lenguaje
	$lang_r = $_REQUEST['lang_rubric'];
	$lang_g = $_REQUEST['lang_grade'];
	$lang_w = $_REQUEST['lang_weight'];
	// Consistencia Temporal
	$consist_w = $_REQUEST['consist_weight'];
	// Contribución
	$contrib_w = $_REQUEST['contrib_weight'];
	// Método de Evaluación Consistencia
	$consist_m = $_REQUEST['consist_meth'];
	// Método de Evaluación Contenido
	$contrib_m = $_REQUEST['contrib_meth'];

	echo "Puntos Total Actividad Wiki: $wikigrade <br />";
	echo '<table border="1">';
	echo '<tr><th>Variable</th><th>Valor</th><th>Peso</th><th>Ponderado</th></tr>';
	
	$sum = 0.0;	
	$sum += createParameterRow($content_g, $content_w, $content_r, "Contenido");
	$sum += createParameterRow($present_g, $present_w, $present_r, "Presentación");
	$sum += createParameterRow($colab_g, $colab_w, $colab_r, "Colaboración");
	$sum += createParameterRow($orga_g, $orga_w, $orga_r, "Organización");
	$sum += createParameterRow($refer_g, $refer_w, $refer_r, "Referencias");
	$sum += createParameterRow($lang_g, $lang_w, $lang_r, "Lenguaje");
	
	
	
	echo "<tr><td>Consistencia</td><td></td><td>$consist_w</td><td></td></tr>";
	echo "<tr><td>Contribución</td><td></td><td>$contrib_w</td><td></td></tr>";
	echo "</table>"; 
	
	echo "Método de Eval. Consistencia $consist_m <br />";
	echo "Método de Eval. Contribución $contrib_m <br />";
	echo "Suma Nota de Parte Colaborativa: $sum Ponderado: " . ($sum * $wikigrade / 100.0) . "<br />";
	
	$wclause = "";
	$max = count($_SESSION['pages']);
	for ($i = 0; $i < $max; $i++){
		$pid = $_SESSION['pages'][$i];
		if ($i != $max - 1)
			$wclause = $wclause . "page.page_id = $pid OR ";
		else
			$wclause = $wclause . "page.page_id = $pid ";
	}
	$query = "SELECT rev_timestamp, rev_len, user_name " .
		 "FROM page JOIN revision ON page.page_id=revision.rev_page JOIN user ON revision.rev_user=user.user_id " .
		 "WHERE " . $wclause;
	
	echo "<p>$query</p>";
	

?>
</body>
</html>
