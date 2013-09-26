<!DOCTYPE html>

<html>
<META charset="UTF-8">
<head>
<title>Consultas de Historia</title>
</head>
<body>
<?php
	$con=mysqli_connect("localhost", "wikiphp", "Wixi+php2013", "iscwiki");

	if (mysqli_connect_errno($con)){
		echo "Failed to connect " . mysqli_connect_error();
	}else{
	//	echo "Connection Succesful";
	}

	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		if ($_GET['add'] == "true") {
			$content_cookie = $_COOKIE['courses'];

			if (!empty($content_cookie)) {
				$pages = split(",", $content_cookie);
				if (!array_search($_GET['id'], $pages)) {
					$content_cookie = $content_cookie . "," . $_GET['id'];
				}
			} else {
				$content_cookie = $_GET['id'];
			}

			setcookie("courses", $content_cookie, time()+60*5);
		}
	}

	$query = "SELECT page.page_id, page_title FROM page JOIN main_pages ON page.page_id = main_pages.page_id;";
	$result = mysqli_query($con, $query);
	echo '<table border="1">';
	echo '<tr>';
	echo '<td>Página</td>';
	echo '<td>Acción</td>';
	echo '</tr>';
	while ($row = mysqli_fetch_array($result)){
		$page = str_replace("_", " ", $row['page_title']);
		echo '<tr>';
			echo '<td>';
				echo $page;
			echo '</td>';
			echo '<td>';
				echo '<a href="list2.php?id=' . $row['page_id'] . '&add=false">Ver Hijas</a> ';
				echo ' | <a href="list1.php?id=' . $row['page_id'] . '&add=true">Agregar</a>';
			echo '</td>';
		echo "</tr>";
	}
	echo '</table>';

	mysqli_close($con);

	echo '<br><br><a href="index.php">Inicio</a>';
	echo ' | <a href="prueba.php">Continuar</a>'
?>
</body>
</html>
