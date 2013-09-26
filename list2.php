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
//		echo "Connection Succesful";
	}

	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		if ($_GET['add'] == "true") {
			$content_cookie = $_COOKIE['courses'];

			if (!empty($content_cookie)) {
				$pages = split(",", $content_cookie);
				if (!array_search($_GET['page'], $pages)) {
					$content_cookie = $content_cookie . "," . $_GET['page'];
				}
			} else {
				$content_cookie = $_GET['page'];
			}

			setcookie("courses", $content_cookie, time()+60*5);
		}
	}

	$query = "SELECT page_id, pl_title from pagelinks join page on pl_title=page_title where pl_from= " . $_GET['id'];
	$result = mysqli_query($con, $query);
	if (mysqli_num_rows($result)==0){
		echo "No hay páginas hijas </br>";
//		echo '<a href="javascript: history.go(-1)">Regresar</a>'; 
	}else{
		echo '<table border="1">';
		echo '<tr>';
		echo '<td>Página</td>';
		echo '<td>Acción</td>';
		echo '</tr>';
		while ($row = mysqli_fetch_array($result)){
			$page = str_replace("_", " ", $row['pl_title']);
			echo '<tr>';
				echo '<td>';
					echo $page;
				echo '</td>';
				echo '<td>';
					echo '<a href="list2.php?id=' . $row['page_id'] . '&add=false">Ver Hijas</a> ';
					echo ' | <a href="list2.php?id=' . $_GET['id'] . "&page=" . $row['page_id'] . '&add=true">Agregar</a>';
				echo '</td>';
			echo "</tr>";
			
			
//			echo '<a href="list2.php?id=' . $row['page_id'] . '">' . $page . "</a>";
//			echo "<br/>";
		}	
		echo '</table>';
	}
	echo '</br><a href="javascript: history.go(-1)">Regresar</a>';
	echo ' | <a href="prueba.php">Continuar</a>';
	mysqli_close($con);

?>
</body>
</html>
