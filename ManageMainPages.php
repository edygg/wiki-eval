<!DOCTYPE html>

<html>
<head>
	<title>Administrar Páginas Principales</title>
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
	?>	

	<h1>Administrar Páginas Principales</h1>


	<?php

		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$query = "DELETE FROM main_pages WHERE page_id = " . $_GET['id'] . ";";
			mysqli_query($con, $query);
		}


		$query = "SELECT page.page_id,course_name,course_code FROM page JOIN main_pages ON page.page_id = main_pages.page_id;";
		$result = mysqli_query($con, $query);

		echo '<table border="1"
				<thead>
					<tr>
						<th>Código</th>
						<th>Nombre</th>
						<th>Editar</th>
					</tr>
				</thead>
				<tbody>';

		while ($row = mysqli_fetch_array($result)) {
			
			echo '<tr>
					<td>' . $row['course_code'] . '</td>
					<td>' . $row['course_name'] . '</td>
					<td><a href="UpdateMainPages.php?id=' . $row['page_id'] . '">Actualizar</a> | <a href="ManageMainPages.php?id=' . $row['page_id'] . '">Eliminar</a>' . '</td>';
		}

		echo '	</tbody>
			 </table>';

		echo '<br><br><a href="index.php">Regresar</a>';
	?>

</body>
</html>