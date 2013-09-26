<!DOCTYPE html>

<html>
<head>
	<title>Actualizar páginas principales</title>
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
			$query = "UPDATE main_pages SET course_name = '" . $_POST['c_name'] . "', course_code = '" . $_POST['c_code'] . "' WHERE page_id = " . $_GET['id'] . ";";
			$result = mysqli_query($con, $query);

			if ($result) {
				echo '<div class="success">Ingresado exitosamente</div>';
			} else {
				echo '<div class="error">Error al ingresar la página</div>';
			}
		}

		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$query = "SELECT course_name, course_code FROM main_pages WHERE page_id = " . $_GET['id'] . ";";
			$result = mysqli_query($con, $query);
			$row = mysqli_fetch_array($result);
			$cn = $row['course_name'];
			$cd = $row['course_code'];	
		}

		echo '<h1>Actualizar páginas principales</h1>';
		echo '
		<br><br><form method="post">
			<fielset>
				<input type="text" name="c_name" placeholder="Nombre del curso" value="' . $cn . '" required><br>
				<input type="text" name="c_code"placeholder="Código del curso" value="' . $cd . '"><br><br>
				<input type="submit" name="save_button" value="Actualizar">
			</fieldset>
		</form>
		';

		echo '<br><br><a href="ManageMainPages.php">Regresar</a>'; 
	?>


</body>
</html>