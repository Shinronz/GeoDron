<?php



	include("config.php") ;
	$link = mysqli_connect($server, $db_user, $db_pass) or die("Error " . mysqli_error($link)); 
	mysqli_select_db($link,$database);

	
	mysqli_query ($link,"INSERT INTO `bdnasa`.`capa` (`nombre`,`color`) VALUES ('$_POST[nombrecapa]','$_POST[colorcapa]')") or die ('Error en la carga de datos');
	$id= mysqli_insert_id($link);
	$string= "<option value=".$id.">".$_POST['nombrecapa']."</option>";
	 echo $string;


?>