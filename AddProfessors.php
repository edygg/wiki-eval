<!DOCTYPE html>

<html>
<head>
	<title>Agregar profesores</title>
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

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$query = "INSERT INTO professors (user_id) VALUES (" . $_POST['users'] . ");";
			$result = mysqli_query($con, $query);

			if ($result) {
				echo '<div class="success">Ingresado exitosamente</div>';
			} else {
				echo '<div class="error">Error al ingresar la página</div>';
			}
		}

		echo '<h1>Agregar profesores</h1>';

		echo '
		<br><br><form method="post">
			<fieldset>
				<select name="users">
		';

		$query = "SELECT U.user_id, user_name FROM user U WHERE U.user_id NOT IN (SELECT user_id FROM professors);";
		$result = mysqli_query($con, $query);

		while ($row = mysqli_fetch_array($result)) {
			echo '<option value="' . $row['user_id'] . '">' . $row['user_name'] . '</option>';
		}

		echo '
				</select>
				<input type="submit" name="save_button" value="Agregar">
			</fieldset>
		</form>';

		echo '<br><br><a href="index.php">Regresar</a>';
	?>	
</body>
</html>