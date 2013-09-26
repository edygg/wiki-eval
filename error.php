<html>
<meta charset="UTF-8">
	<head>
		<title>Error</title>
	<head>
	<body>
	<?php
		$ev = $_GET['ev'];
		if ($ev == 1)
			$em = "Debe estar registrado en el sistema";
		elseif ($ev == 2)
			$em = "Sólo sysop puede acceder al sistema de administración";
		elseif ($ev == 3306)
			$em = "Error de Conexión con la base de datos";
		else
			$em = "Error no identificado todavía";
		echo '<font color="#ff0000">' . $em . "</font>";

	?>
	</body>
</html>
