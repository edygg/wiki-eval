<!DOCTYPE html>

<html>
<head>
	<title>Añadir páginas principales</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
	<style>
		textarea {
			width: 500px;
		}
	</style>
</head>

<body>

	<?php
		function val_form() {
			if (empty($_POST['c_name'])) {
				return false;
			}

			if (empty($_POST['c_code'])) {
				return false;
			}

			return true;
		}


		$con = mysqli_connect("localhost", "wikiphp", "Wixi+php2013", "iscwiki");

		if (mysqli_connect_errno($con)) {
			echo '<div class="error">' . "Falló la conexión : " . mysqli_connect_error() . "</div>";
		} else {
			echo '<div class="success">' . "Conexión exitosa" . "</div>";
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (val_form()) {
				$query = "INSERT INTO main_pages (page_id, course_name, course_code) VALUES (" . $_POST['pages'] . ",'" . $_POST['c_name'] . "','" . $_POST['c_code'] . "');";
				//echo $query;
				$result = mysqli_query($con, $query);
				if ($result) {
					echo '<div class="success">Ingresado exitosamente</div>';
				} else {
					echo '<div class="error">Error al ingresar la página</div>';
				}
			}
		}
		echo '<h1>Añadir páginas principales</h1>';
		echo '
		<br><br><form method="post">
			<fielset>
				<select name="pages">';
		$query = "SELECT P.page_id, P.page_title FROM page P WHERE P.page_id NOT IN (SELECT main_pages.page_id FROM main_pages) AND page_title NOT LIKE '%png' AND page_title NOT LIKE '%JPG' AND page_title NOT LIKE '%jpg' AND page_title NOT LIKE '%gif' ORDER BY P.page_title;";
		$result = mysqli_query($con, $query);

		while ($row = mysqli_fetch_array($result)) {	
			echo '<option value="' . $row['page_id'] . '">' . $row['page_title'] . '</option>';
		}

		echo	
				'</select><br><br>
				<input type="text" name="c_name" placeholder="Nombre del curso" required><br>
				<input type="text" name="c_code"placeholder="Código del curso"><br><br>
				<input type="submit" name="save_button" value="Añadir">
			</fieldset>
		</form>
		';

		echo '<br><br><a href="index.php">Regresar</a>';
	?>


</body>
</html>
