<?php
	include_once "./historyfunctions.php";
	$uid = checkLoggedToWiki();
	if ($uid == -1)
		header("location:error.php?ev=1");
	$con=mysqli_connect("localhost", "wikiphp", "Wixi+php2013", "iscwiki");
	if (mysqli_connect_errno($con)){
		header("location:error.php?ev=3306");
	}
	$so = checkSysOp($uid, $con);
	$uname = checkProfessor($uid, $con);
	if (! $so && $uname == "")
		header("location:error.php?ev=2");
	// A esta altura si sigue en esta página significa:
	// 1. La sesión está creada, en relación al wiki
	// 2. El usuario es sysop o un profesor registrado
		
	if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'add'){
		$pid = $_REQUEST['pageid'];
		addpage($pid);
		header("location:Elegidas.php");
		exit();
	}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Páginas del Wiki</title>
<script language="javascript">
	function addPage(pid){
		document.form.pageid.value = pid;
		document.form.command.value= 'add';
		document.form.submit();
	}
	function seeChildren(pid){
		document.form.pageid.value = pid;
		document.form.command.value='children';
		document.form.submit();
	}
</script>
</head>
<body>
<form name="form">
	<input type="hidden" name="pageid" />
	<input type="hidden" name="command" />
</form>

<?php
	if (isset($_REQUEST['pageid'])){
		$pid = $_REQUEST['pageid'];
	}else{
		$pid = 0;
	}
	showPages($pid, $con);
?>

</body>
</html>
