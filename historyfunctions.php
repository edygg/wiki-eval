<?php

putenv("MW_INSTALL_PATH=/var/www/mediawiki");
$include_dir = "../mediawiki/includes";
require_once( "$include_dir/WebStart.php");
require_once( "$include_dir/User.php");

function checkLoggedToWiki(){
	$t = new User();
	$user = $t->newFromSession();
	$user->load();
	if ($user->isAnon() == true){
		return -1;
	}else{
		return $user->idForName();
	}
}
function getpagename($con, $pid){
	$query = "SELECT page.page_title as title FROM page WHERE page.page_id =" . $pid;
	$result = mysqli_query($con, $query);
	if ($row = mysqli_fetch_array($result))
		return $row['title'];
	else
		return "Err";
}
function showPages($pid, $con){
	if ($pid == 0){
		$query = "SELECT page.page_id, page_title as title FROM page JOIN main_pages ON page.page_id = main_pages.page_id;";
	}else{
		$query = "SELECT page_id, pl_title as title FROM pagelinks JOIN page ON pl_title=page_title WHERE pl_from= " . $pid;
	}
	$result = mysqli_query($con, $query);
	if (mysqli_num_rows($result)==0){
		echo "No hay páginas hijas </br>";
	}else{
		echo '<table border="1">';
		echo '<tr>';
		echo '<td>Página</td>';
		echo '<td>Acción</td>';
		echo '</tr>';
		while ($row = mysqli_fetch_array($result)){
			$page = str_replace("_", " ", $row['title']);
			echo '<tr>';
                                echo '<td>';
	                                echo $page;
	                        echo '</td>';
	                        echo '<td>';
					echo '<input type="button" value="Ver Hijas" onclick="seeChildren(' . $row['page_id'] . ')"/>';
					echo '<input type="button" value="Agregar" onclick="addPage(' . $row['page_id'] . ')"/>';
//	                                echo '<a href="list2.php?id=' . $row['page_id'] . '&add=false">Ver Hijas</a> ';
//                                      echo ' | <a href="list2.php?id=' . $_GET['id'] . "&page=" . $row['page_id'] . '&add=true">Agregar</a>';
                                echo '</td>';
                        echo "</tr>";
		}
		echo '</table>';
	}
}

function checkSysOp($uid, $con){
	$query = "SELECT user_name FROM user JOIN user_groups ON user_id=ug_user WHERE ug_group = 'sysop' AND user_id = $uid";
	$result = mysqli_query($con, $query);
	if ($row = mysqli_fetch_array($result)){
		return true;
	}else{
		return false;
	}
}
function checkProfessor($uid, $con){
	$query = "SELECT user_name FROM user JOIN professors ON user.user_id = professors.user_id WHERE professors.user_id = $uid";
	$result = mysqli_query($con, $query);
	if ($row = mysqli_fetch_array($result)) {
		return $row['user_name'];
	}else{
		return "";
	}
}
function addpage($pid){
	if ($pid < 0)
		return;
	if (is_array($_SESSION['pages'])){
		$max=count($_SESSION['pages']);
		$_SESSION['pages'][$max]=$pid;
	}else{
		$_SESSION['pages'] = array();
		$_SESSION['pages'][0]=$pid;
	}
}
function removepage($pid){
	$pid = intval($pid);
	$max=count($_SESSION['pages']);
	for ($i = 0; $i < $max; $i++){
		if ($pid == $_SESSION['pages'][$i]){
			unset($_SESSION['pages'][$i]);
			break;
		}
	}
	$_SESSION['pages']=array_values($_SESSION['pages']);
	
}
function createParameterRow($grade, $weight, $rubric, $caption){
	echo "<tr>";
	echo "<td>$caption</td>";
	if ($grade == "")
		$value = $rubric / 5.0 * 100.0;
	else
		$value = $grade;
	echo "<td>" . sprintf("%5.2f", $value) . "</td>";
	echo "<td>$weight</td>";
	echo "<td>" . ($value * $weight / 100.0) . "</td>";
	echo "</tr>";
	return ($value * $weight / 100.0);
}
?>
