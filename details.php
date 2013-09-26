<!DOCTYPE html>

<html>
<head>
	<title>Inicio - Listado de páginas</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">

	<style type="text/css">
		#seleccion {
			height: 250px;
			padding: 5%;
		}

		#formulario {

		}

		span {
			font-size: 0.7em;
		}
	</style>
</head>

<body>
	<!-- Creando la conexión a la BD -->
	<?php 
		$con = mysqli_connect("localhost", "wikiphp", "Wixi+php2013", "iscwiki");

		if (mysqli_connect_errno($con)) {
			echo '<div class="error">' . "Falló la conexión : " . mysqli_connect_error() . "</div>";
		} else {
			echo '<div class="success">' . "Conexión exitosa" . "</div>";
		}
	?> 

	<div id="seleccion">
		<h1>Parámetros de evaluación</h1>

		<!-- Formulario de selección de página -->
		<form id="formulario" action="details_page.php" name="selectpage" method="post">
			<select name="pid">
				<?php
					$query = "SELECT page_id, page_title FROM page WHERE (page_title NOT LIKE '%png' AND page_title NOT LIKE '%JPG' AND page_title NOT LIKE '%jpg' AND page_title NOT LIKE '%gif');";
					$result = mysqli_query($con, $query);

					while ($row = mysqli_fetch_array($result)) {
						echo '<option value="' . $row['page_id'] . '" >' . $row['page_title'] . '</option>';
					}
				?>
			</select><br><br>

			<?php
				$fecha_ini = date("Ymd", strtotime('-3 months')) ;
				$fecha_fin = date("Ymd");
				echo '<input type="radio" name="date_range" checked value="periods">Por trimestre</input><br>';

				$query = "SELECT periodo_id, semestre, periodo, year FROM periodos ORDER BY year DESC, semestre ASC, periodo ASC;";
				$result = mysqli_query($con, $query);

				echo '<select name="semestre_periodos">';
				while ($row = mysqli_fetch_array($result)) {
					echo '<option value="' . $row['periodo_id'] . '">' . "semestre " . $row['semestre'] . ", periodo " . 
						 $row['periodo'] . ", Año " . $row['year'] . '</option>';  
				}
				echo '</select>';

				mysqli_close($con);
				echo '<br><br><input type="radio" name="date_range" value="range_start_end">Por rango de fechas</input><br>';		
				echo '<span>Fecha inicio:</span> <input name="f_inicio" type="number" value="' . $fecha_ini .'"><br>';
				echo '<span>Fecha final:</span> <input name="f_fin" type="number" value="' . $fecha_fin .'"><br>';
			?>
			<input type="submit" value="Seleccionar">

		</form>
	</div>

</body>
</html>