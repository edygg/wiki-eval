<!DOCTYPE html>

<html>
<head>
	<title>Detalles de la página</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">

	<style type="text/css">
		#detalles {
			font-size: 0.8em;
			font-family: sans-serif;
			font-weight: lighter;
		}
	</style>
</head>

<body>
	<?php
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($_POST['date_range'] == "range_start_end" && (empty($_POST['f_inicio']) || empty($_POST['f_fin']))) {
				echo '<div class="error">' . "<p>Ingrese correctamente las fechas de inicio y fin.</p>"; 
				echo "<p>Recuerde que las fechas tienen que ser ingresadas como números consecutivos, ". 
				     "para representar 2013-enero-01 escriba: 20130101</p>" . "</div>";
			 } else {
			 	$con = mysqli_connect("localhost", "wikiphp", "Wixi+php2013", "iscwiki");
			 	
			 	if (mysqli_connect_errno($con)) {
			 		echo '<div class="error">' . "Falló la conexión : " . mysqli_connect_error() . "</div>";
			 	} else {
			 		echo '<div class="success">' . "Conexión exitosa" . "</div>";
			 	}
			 } 
		}
	?>

	<div id="detalles">
		<h1>Detalles de la página seleccionada</h1>

		<!-- Recogiendo los detales de la página seleccionada -->
		<?php
			$query = "SELECT page_title, page_len FROM page WHERE page_id=" . $_POST["pid"] . ";";
			$result = mysqli_query($con, $query);

			while ($row = mysqli_fetch_array($result)) {
				echo "<b>Página:</b> " . $row['page_title'] . "<br>";
				echo "<b>Longitud:</b> " . $row['page_len'] . "<br>";
			}

			if ($_POST['date_range'] == "range_start_end") {
				$fecha_inicio = $_POST['f_inicio'] . "000000";
				$fecha_final = $_POST['f_fin'] . "000000";
			} else {
				$query = "SELECT fecha_inicio, fecha_final FROM periodos WHERE periodo_id=" . $_POST['semestre_periodos'] . ";";
				$result = mysqli_query($con, $query);
				$row = mysqli_fetch_array($result);
				$fecha_inicio = date("YmdHis", strtotime($row['fecha_inicio']));
				$fecha_final = date("YmdHis", strtotime($row['fecha_final']));
			}

			$query = "SELECT user_name, rev_timestamp, rev_len FROM page, user, revision". 
					 " WHERE user_id = rev_user AND rev_page = page_id AND rev_timestamp > " .
					 $fecha_inicio . " AND rev_timestamp < " . $fecha_final . " AND page_id = " 
					 . $_POST['pid'] . " ORDER BY rev_timestamp;";
			$result = mysqli_query($con, $query);

			$datos = array();
			while ($row = mysqli_fetch_array($result)) {
				$datos[] = $row;
			}

			mysqli_close($con);

			$fechas = array();
			$usuarios = array();

			foreach ($datos as $registro) {
				$fecha_actual = substr($registro['rev_timestamp'], 0, 8);
				$usuario = $registro['user_name'];

				if (!in_array($fecha_actual, $fechas)) {
					$fechas[] = $fecha_actual;
				}

				if (!in_array($usuario, $usuarios)) {
					$usuarios[] = $usuario;
				}
			}

			sort($usuarios);

			$tabla_principal;

			foreach($usuarios as $usuario) {
				foreach($fechas as $fecha) {
					$datos_por_fecha[$fecha] = 0;
				}
				$tabla_principal[$usuario] = $datos_por_fecha;
			}

			$dato_anterior = 0;
			foreach ($datos as $dato) {
				$tabla_principal[$dato['user_name']][substr($dato['rev_timestamp'], 0, 8)] += $dato['rev_len'] - $dato_anterior;
				$dato_anterior = $dato['rev_len'];
			}

			$totales_por_usuario;
			$totales_por_fecha;

			foreach ($usuarios as $usuario) {
				foreach ($fechas as $fecha) {
					$totales_por_usuario[$usuario] += $tabla_principal[$usuario][$fecha];
					$totales_por_fecha[$fecha] += $tabla_principal[$usuario][$fecha];
				}
			}

			//Creando la tabla 
			echo '<table border="1">';
				echo '<thead>';
					echo '<tr>';
						echo '<th>Usuario</th>';

						foreach($fechas as $fecha) {
							echo '<th>' . $fecha . '</th>';
						}

						echo '<th>Total</th>'; 

					echo '</tr>';
				echo '</thead>';

				echo '<tbody>';
					foreach($usuarios as $usuario) {
						echo '<tr>';
							echo '<td>'. $usuario . '</td>';

						$datos_por_fecha = $tabla_principal[$usuario];

						foreach($fechas as $fecha) {

							echo '<td>' . $datos_por_fecha[$fecha] . '</td>';
						}
						echo '<td>' . $totales_por_usuario[$usuario] . '</td>';
						echo '</tr>';
					}
				echo '</tbody>';

				echo '<tfoot>';
					echo "<th>Total</th>";
					foreach($fechas as $fecha) {
						echo '<td>' . $totales_por_fecha[$fecha] . '</td>';
					}

					if (array_sum($totales_por_fecha) === array_sum($totales_por_usuario)) {
						echo '<td>' . array_sum($totales_por_usuario) . '</td>';
					}
				echo '</tfoot>';
			echo '</table>';

			//var_dump($tabla_principal);
			
		?>	
	</div>
</body>
</html>