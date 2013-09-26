<!DOCTYPE html>
<?php 
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$pages = split(",", $_COOKIE['courses']);

		$key = array_search($_GET['id'], $pages);
		if ($key !== false) {
			unset($pages[$key]);

			for ($i = 0; $i < count($pages); $i++) {
				if (!empty($pages[$i])) {

					if ($i < count($pages) - 1) {
						$new_content .= $pages[$i] . ",";
					} else {
						$new_content .= $pages[$i];
					}
				}
			}
			
			setcookie("courses", "", time()-30000);
			setcookie("courses", $new_content, time()+60*5);
			echo $_COOKIE['courses'] . "<br>";
		}
	}
?>
<html>
	<head>
		<title>Listado de páginas seleccionadas</title>
		<meta charset="utf-8">
	</head>

	<body>
		<?php 

			$con = mysqli_connect("localhost", "wikiphp", "Wixi+php2013", "iscwiki");
			
			if (mysqli_connect_errno($con)) {
				echo '<div class="error">' . "Falló la conexión : " . mysqli_connect_error() . "</div>";
			} else {
				echo '<div class="success">' . "Conexión exitosa" . "</div>";
			}
			echo $_COOKIE['courses'] . "<br>";
			$pages = split(",", $_COOKIE['courses']);

			$query = "SELECT page_id, page_title FROM page WHERE ";

			for ($i = 0; $i < count($pages); $i++) {
				if ($i < count($pages) - 1) {
					$query .= "page_id = " . $pages[$i] . " OR ";
				} else {
					$query .= "page_id = " . $pages[$i] . ";";
				}
			}

			$result = mysqli_query($con, $query);

			while ($row = mysqli_fetch_array($result)) {
				echo $row['page_title'] . ' | <a href="prueba.php?id=' . $row['page_id'] . '">Eliminar</a><br>';
			}
		?>
	</body>
</html> 