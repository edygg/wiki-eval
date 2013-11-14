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
	<h1>Actualizar periodos</h1>
	
	<?php
		function val_form() {
			if (!is_numeric($_POST['p_year']) || ($_POST['p_year'] < 2000 && $_POST['p_year'] > 2099)) {
				echo '<div class="error">Año no válido</div>';
				return false;
			}
			return true;
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {	
			if(val_form()) {
				$con = mysqli_connect("localhost", "wikiphp", "Wixi+php2013", "iscwiki");

				if (mysqli_connect_errno($con)) {
					echo '<div class="error">' . "Falló la conexión : " . mysqli_connect_error() . "</div>";
				} else {
					$fecha_ini = str_replace("-", "", $_POST['p_fecha_inicio']);
					$fecha_fin = str_replace("-", "", $_POST['p_fecha_final']);
					$query = "update periodos set periodo_id=".$_POST['p_periodo'].", semestre=".$_POST['p_semestre'].", year=".
							 $_POST['p_year'].", fecha_inicio=".$fecha_ini.", fecha_final=".
							 $fecha_fin." where periodo_id=".$_GET['id'].";";
					$result = mysqli_query($con, $query);
					mysqli_close($con);

					if ($result)
						echo '<div class="success">Actualizado exitosamente</div>';
					else
						echo '<div class="error">Error al actualizar el registro</div>';
				}
				
			}
		}

		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$con = mysqli_connect("localhost", "wikiphp", "Wixi+php2013", "iscwiki");

			if (mysqli_connect_errno($con)) {
				echo '<div class="error">' . "Falló la conexión : " . mysqli_connect_error() . "</div>";
			} else {

				$query = "select * from periodos where periodo_id=" . $_GET['id'] . ";";
				$result = mysqli_query($con, $query);
				$row = mysqli_fetch_array($result);

				$semestre = $row["semestre"];
				$periodo = $row["periodo"];
				$year = $row["year"];
				$fecha_i = substr($row["fecha_inicio"], 0, 10);
				$fecha_f = substr($row["fecha_final"], 0, 10);;

				mysqli_close($con);
			}
			
		}

		echo '
		<form method="post">
			<fielset>
				<select name="p_semestre">';

		if ($semestre == 1) {
			echo '<option value="1" selected>Primer Semestre</option>
					<option value="2">Segundo Semestre</option>';
		} else {
			echo '<option value="1">Primer Semestre</option>
					<option value="2" selected>Segundo Semestre</option>';
		}

		echo '	</select><br>
				<select name="p_periodo">';

		switch($periodo) {
			case 1:
				echo '<option value="1" selected>Primer Periodo</option>
					<option value="2">Segundo Periodo</option>
					<option value="4">Tercer Periodo</option>
					<option value="5">Cuarto Periodo</option>';
				break;

			case 2:
				echo '<option value="1">Primer Periodo</option>
					<option value="2" selected>Segundo Periodo</option>
					<option value="4">Tercer Periodo</option>
					<option value="5">Cuarto Periodo</option>';
				break;

			case 4:
				echo '<option value="1">Primer Periodo</option>
					<option value="2">Segundo Periodo</option>
					<option value="4" selected>Tercer Periodo</option>
					<option value="5">Cuarto Periodo</option>';
				break;

			case 5:
				echo '<option value="1">Primer Periodo</option>
					<option value="2">Segundo Periodo</option>
					<option value="4">Tercer Periodo</option>
					<option value="5" selected>Cuarto Periodo</option>';
				break;
		}
		echo '	
				</select><br>
				<input type="number" name="p_year" placeholder="Año: 2013" required value="'.$year.'"><br>
				<input type="text" name="p_fecha_inicio" placeholder="Inicio: yyyymmdd" required value="'.$fecha_i.'"><br>
				<input type="text" name="p_fecha_final" placeholder="Final: yyyymmdd" required value="'.$fecha_f.'"><br>
				<input type="submit" name="save_button" value="Actualizar">
			</fielset>
		</form>
		';

		echo '<br><br><a href="index.php">Regresar</a>';
	?>
</body>
</html>