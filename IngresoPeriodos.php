<!DOCTYPE html>

<html>
<head>
	<title>Formulario de ingreso de periodos</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">

	<style>
		select {
			width: 195px;
		}

		input {
			font-size: 1em;
		}
	</style>
</head>

<body>
	<h1>Ingreso de periodos</h1>
	
	<?php
		function val_form() {
			if (!is_numeric($_POST['p_year']) || ($_POST['p_year'] < 2000 && $_POST['p_year'] > 2099)) {
				echo '<div class="error">Año no válido</div>';
				return false;
			}

			if (!is_numeric($_POST['p_fecha_inicio']) || !is_numeric($_POST['p_fecha_final'])) {
				echo '<div class="error">Error en la fecha. Recuerde el formato: 20130405 (yyyymmdd)</div>';
				return false;
			} else {
				if (strlen($_POST['p_fecha_inicio']) != 8 || strlen($_POST['p_fecha_final']) != 8) {
					echo '<div class="error">Error en la fecha. Recuerde el formato: 20130405 (yyyymmdd)</div>';
					return false;
				} else {
					$year = substr($_POST['p_fecha_inicio'], 0, 4);
					$month = substr($_POST['p_fecha_inicio'], 4, 2);
					$day = substr($_POST['p_fecha_inicio'], 6, 2);

					if (!checkdate($month, $day, $year)) {
						echo '<div class="error">Error en la fecha. Recuerde el formato: 20130405 (yyyymmdd)</div>';
						return false;
					}

					$year = substr($_POST['p_fecha_final'], 0, 4);
					$month = substr($_POST['p_fecha_final'], 4, 2);
					$day = substr($_POST['p_fecha_final'], 6, 2);

					if (!checkdate($month, $day, $year)) {
						echo '<div class="error">Error en la fecha. Recuerde el formato: 20130405 (yyyymmdd)</div>';
						return false;
					}

				}
			}

			return true;
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {	
			if(val_form()) {
				$con = mysqli_connect("localhost", "wikiphp", "Wixi+php2013", "iscwiki");

				if (mysqli_connect_errno($con)) {
					echo '<div class="error">' . "Falló la conexión : " . mysqli_connect_error() . "</div>";
				} else {

					$query = "INSERT INTO periodos (semestre, periodo, year, fecha_inicio, fecha_final) " .
							 "VALUES (" . $_POST['p_semestre'] . "," . $_POST['p_periodo'] . "," . $_POST['p_year'] . "," .
							 $_POST['p_fecha_inicio'] .", " . $_POST['p_fecha_final'] . ");";
					$result = mysqli_query($con, $query);
					mysqli_close($con);

					if ($result)
						echo '<div class="success">Ingresado exitosamente</div>';
					else
						echo '<div class="error">Error al ingresar el registro</div>';
				}
				
			}
		}

		echo '
		<form method="post">
			<fielset>
				<select name="p_semestre">
					<option value="1">Primer Semestre</option>
					<option value="2">Segundo Semestre</option>
				</select><br>
				<select name="p_periodo">
					<option value="1">Primer Periodo</option>
					<option value="2">Segundo Periodo</option>
					<option value="4">Tercer Periodo</option>
					<option value="5">Cuarto Periodo</option>
				</select><br>
				<input type="text" name="p_year" placeholder="Año: 2013" required><br>
				<input type="text" name="p_fecha_inicio" placeholder="Inicio: yyyymmdd" required><br>
				<input type="text" name="p_fecha_final" placeholder="Final: yyyymmdd" required><br>
				<input type="submit" name="save_button" value="Guardar">
			</fielset>
		</form>
		';

		echo '<br><br><a href="index.php">Regresar</a>';
	?>
</body>
</html>