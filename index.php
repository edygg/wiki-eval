

<html>
<meta charset="UTF-8">
	<head>
		<title>Página de Administración</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	<head>
	<body>
	<?php
		putenv("MW_INSTALL_PATH=/var/www/mediawiki");
		$include_dir = "../mediawiki/includes";
		require_once( "$include_dir/WebStart.php");
		require_once( "$include_dir/User.php");
		$t = new User();
		$user = $t->newFromSession();
		$user->load();
		// Double Check is logged in user to wiki
		if ($user->isAnon() == true){
			echo "<script>window.location = 'error.php?ev=1'</script>";
		}
		// Check whether user is Sysop
		$user_id = $user->idForName();
		$con=mysqli_connect("localhost", "wikiphp", "Wixi+php2013", "iscwiki");
	        if (mysqli_connect_errno($con)){
			//echo "Failed to connect " . mysqli_connect_error();
			echo "<script>window.location = 'error.php?ev=3306'</script>";
		}else{
			//echo "Connection Succesful";
		}
		$query = "select user_name from user join user_groups on user_id=ug_user where ug_group = 'sysop' and user_id = " . $user_id;
		$result = mysqli_query($con, $query);
		if ($row = mysqli_fetch_array($result)){
			echo "<h2> Bienvenido: " . $row['user_name'] . "</h2></br>";
			echo "Operaciones: </br>";
			echo "<ul>";
			echo "	<li>Definir Estructura de Páginas</li>";
			echo '		<ul>
							<li><a href="CreateMainPages.php">Agregar páginas principales</a></li>
							<li><a href="ManageMainPages.php">Administrar páginas princiales</a></li>
						</ul>';
			echo "	<li>Definir Usuarios Profesores</li>";
			echo '		<ul>
							<li><a href="AddProfessors.php">Agregar profesores</a></li>
							<li><a href="ManageProfessors.php">Administrar profesores</a></li>
						</ul>';
			echo "	<li>Definir periodos</li>";
			echo '		<ul>
							<li><a href="IngresoPeriodos.php">Ingresar periodos</a></li>
						</ul>';
			echo '	<li><a href="list1.php">Listar clases</a></li>';
			echo "</ul>";
		}else{
			$query = "SELECT user_name FROM user JOIN professors ON user.user_id = professors.user_id WHERE professors.user_id = " . $user_id . ";";
			$result = mysqli_query($con, $query);

			if ($row = mysqli_fetch_array($result)) {
				echo '<h2> Bienvenido: ' . $row['user_name'] . '</h2><br>';
				echo "Operaciones: <br>";
				echo '<ul>
						<li><a href="list1.php">Listar clases</a></li>';
			} else {
				echo '<div class="error">Acceso denegado</div>';
			}
			
		}

		mysqli_close($con);

	?>
	</body>
</html>
