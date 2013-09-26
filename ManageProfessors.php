<!DOCTYPE html>

<html>
<head>
	<title>Administrar Profesores</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<?php
		$con = mysqli_connect("localhost", "wikiphp", "Wixi+php2013", "iscwiki");
		
		if (mysqli_connect_errno($con)) {
			echo '<div class="error">' . "Falló la conexión : " . mysqli_connect_error() . "</div>";
		} else {
			echo '<div class="success">' . "Conexión exitosa" . "</div>";
		}

		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$query = "DELETE FROM professors WHERE user_id = " . $_GET['id'] . ";";
			$result = mysqli_query($con, $query);
		}

		echo '<h1>Administrar profesores</h1>';

		echo '
		<table border="1">
			<thead>
				<tr>
					<th>Usuario</th>
					<th>Editar</th>
				</tr>
			<thead>
			<tbody>
		';

		$query = "SELECT U.user_id, U.user_name FROM professors P JOIN user U ON P.user_id = U.user_id;";
		$result = mysqli_query($con, $query);
		while ($row = mysqli_fetch_array($result)) {
			echo '
				<tr>
					<td>' . $row['user_name'] . '</td>
					<td><a href="ManageProfessors.php?id='. $row['user_id'] . '">Eliminar</a></td>
				</tr>
			';
		}

		echo '</tbody>
			</table>
		';
		echo '<br><br><a href="index.php">Regresar</a>';
	?>
</body>
</html>