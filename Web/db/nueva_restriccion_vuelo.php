<?php



	include("config.php") ;
	$link = mysqli_connect($server, $db_user, $db_pass) or die("Error " . mysqli_error($link)); 
	mysqli_select_db($link,$database);

	
	mysqli_query ($link,"INSERT INTO `bdnasa`.`restriccion_zonavuelo` (`latitud`,`longitud`,`idvuelo`) VALUES ('$_POST[lat]','$_POST[lon]','$_POST[nrores]')") or die ('Error en la carga de datos');
	
	echo "OK";


?>