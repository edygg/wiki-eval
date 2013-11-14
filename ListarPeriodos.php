<!doctype html>

<html lang="es">
<head>
	<title>Listar periodos</title>
	<meta charset="utf-8">
</head>
<body>
	<table border="1">
		<tr>
			<th>Semetre</th>
			<th>Periodo</th>
			<th>Año</th>
			<th>Fecha inicio</th>
			<th>Fecha final</th>
			<th>Acciones</th>
		</tr>

		<?php
			$con=mysqli_connect("localhost", "wikiphp", "Wixi+php2013", "iscwiki");
			if (mysqli_connect_errno($con)){
				//echo "Failed to connect " . mysqli_connect_error();
				echo "<script>window.location = 'error.php?ev=3306'</script>";
			}else{
				//echo "Connection Succesful";
			}

			$query = "select * from periodos;";
			$result = mysqli_query($con, $query);

			while ($row = mysqli_fetch_array($result)) {
				echo '<tr>';
					echo '<td>' . $row["semestre"] . '</td>';
					echo '<td>' . $row["periodo"] . '</td>';
					echo '<td>' . $row["year"] . '</td>';
					echo '<td>' . substr($row["fecha_inicio"], 0, 10) . '</td>';
					echo '<td>' . substr($row["fecha_final"], 0, 10) . '</td>';
					echo '<td><a href="ActualizarPeriodos.php?id=' . $row['periodo_id'] . '">Actualizar</a></td>';		
				echo '</tr>';
			}
		?>
	</table>
</body>
</html>