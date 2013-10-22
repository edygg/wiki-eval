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
<head>
<title>Establecer Parámetros de Evaluación</title>
<meta name="generator" content="Bluefish 2.2.3" >
<meta name="author" content="Carlos Roberto Arias" >
<meta name="date" content="2013-09-27T12:10:02-0600" >
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<script type="text/javascript">
<!--

// -->
</script>
</head>
<body>

<h1>Parámetros de Evaluación</h1>
<div align="left" name="main">
<form action="Evaluar.php" method="post">
Puntos Asignados al Wiki: <input type="text" name="points" /> <br>
<p>
<ul>
<li>Los valores asignados a los pesos deberán sumar 100</li>
<li>Puede dejar en blanco los pesos de criterios que no desea utilizar en la evaluación</li>
<li>En los parámetros de evaluación grupal, si deja en blanco el campo <i>Nota</i> se utilizará el valor seleccionado en <i>Rúbrica</i>, 
    si el campo <i>Nota</i> tiene algún valor se utilizará ese valor y no el de <i>Rúbrica</i></li>
<li>La Evaluación Individual será calculada por el sistema, y luego se sumará a los valores asignados y ponderados de la evaluación grupal</li>
</ul>

</p>
<div align="left" name="group_issues">
<h2>Parámetros de Evaluación Grupal </h2><br>
<table>
<tr>
<th>Criterio</th>
<th>Rúbrica</th>
<th>Nota</th>
<th>Peso</th>
</tr>
<tr>
<td>Contenido</td>
<td>
<select name="content_rubric">
<option value="0">Nada</option>
<option value="1">Esfuerzo Mínimo</option>
<option value="2">Información Esencial</option>
<option value="3">Muestra Conocimiento del Tema</option>
<option value="4">Cubre el tema a Profundidad, con ejemplos</option>
<option value="5">Excede las expectativas</option>
</select>
</td>
<td><input type="text" name="content_grade" size="4"/></td>
<td><input type="text" name="content_weight" size="4"/></td>
</tr>
<tr>
<td>Presentación</td>
<td>
<select name="present_rubric">
<option value="0">Desorganizado</option>
<option value="1">Distrae</option>
<option value="2">Buen uso de atributos</option>
<option value="3">El uso de atributos mejora la calidad</option>
<option value="4">La presentación ayuda significativamente a la comprensión</option>
<option value="5">Excede las expectativas (i.e. usa vídeo)</option>
</select>
</td>
<td><input type="text" name="present_grade" size="4"/></td>
<td><input type="text" name="present_weight" size="4"/></td>
</tr>
<tr>
<td>Colaboración</td>
<td>
<select name="colab_rubric">
<option value="0">No hubo</option>
<option value="1">Menos del 25%</option>
<option value="2">Menos del 50%</option>
<option value="3">Menos del 75%</option>
<option value="4">Todos colaboraron</option>
<option value="5">Consiguieron colaboración de experto</option>
</select>
</td>
<td><input type="text" name="colab_grade" size="4" /></td>
<td><input type="text" name="colab_weight" size="4" /></td>
</tr>
<tr>
<td>Organización</td>
<td>
<select name="orga_rubric">
<option value="0">Desorganizado</option>
<option value="1">Usa algunas secciones</option>
<option value="2">Tiene organización lógica</option>
<option value="3">Usa secciones, enumeraciones</option>
<option value="4">La organización es ideal</option>
<option value="5">Excede las expectativas</option>
</select>
</td>
<td><input type="text" name="orga_grade" size="4"/></td>
<td><input type="text" name="orga_weight" size="4"/></td>
</tr>
<tr>
<td>Referencias</td>
<td>
<select name="refer_rubric">
<option value="0">No hay referencias</option>
<option value="1">Las referencias son pocas, pobres o sólo web</option>
<option value="2">Tiene algunas referencias</option>
<option value="3">Tiene referencias, pero no sigue formato APA</option>
<option value="4">Tiene referencias adecuadas en formato APA</option>
<option value="5">Todas las referencias son "Respetables"</option>
</select>
</td>
<td><input type="text" name="refer_grade" size="4"/></td>
<td><input type="text" name="refer_weight" size="4"/></td>
</tr>
<tr>
<td>Lenguaje</td>
<td>
<select name="lang_rubric">
<option value="0">No toma en cuenta ortografía, gramática y redacción</option>
<option value="1"></option>
<option value="2">Tiene algunos conceptos de ortografía</option>
<option value="3"></option>
<option value="4">El nivel del documento es aceptable</option>
<option value="5">La redacción y ortografía son impecables</option>
</select>
</td>
<td><input type="text" name="lang_grade" size="4"/></td>
<td><input type="text" name="lang_weight" size="4"/></td>
</tr>
</table>

</div>
<div align="left" name="individual_issues">
<h2>Parámetros de Evaluación Individual </h2><br>
<table>
<tr>
<th>Criterio</th>
<th>Peso</th>
</tr>
<tr>
<td>
Consistencia Temporal
</td>
<td><input type="text" name="consist_weight" size="4"/></td>
</tr>
<tr>
<td>
Contribución
</td>
<td><input type="text" name="contrib_weight" size="4"/></td></tr>
</table>
</div>
<h3>Elección de Método de Ponderación</h3>
<div align="left" name="pond_meth">
<table>
<tr>
<th>Criterio</th>
<th>Método de Cálculo</th>
<th>Breve Descripción</th>
</tr>
<tr>
<td>Consistencia</td>
<td>
<select name="consist_meth">
<option value="0">Por número máximo de participaciones</option>
<option value="1">Por número establecido de participaciones</option>
<option value="2">Por número de participaciones semanales</option>
</select>
</td>
<td>Define cómo se calculará la evaluación de la consistencia dependiendo del criterio del profesor</td>
</tr>
<tr>
<td>Contribución</td>
<td>
<select name="contrib_meth">
<option value="0">Normalizar con respecto al total de contribuciones</option>
<option value="1">Suavizar y luego Normalizar con respecto al total de contribuciones</option>
</select>
</td>
<td>Define cómo se calculará la evaluación de las contribuciones, la suavización se hace por medio de una función exponencial con asíntota</td>
</tr>
</table>

</div>
<div align="left" name="page_list">
<h2>Lista de Páginas Seleccionadas para Evaluación</h2>
<ul>
<?php
	$max = count($_SESSION['pages']);
	for ($i = 0; $i < $max; $i++){
		$pid = $_SESSION['pages'][$i];
		$pagename = str_replace("_", " ", getpagename($con, $pid));
		echo "<li>$pagename</li>";
	}
	 
?>
</ul>
</div>
<input type="Submit" value="Evaluar" />
</form>
</div>


</body>
</html>
