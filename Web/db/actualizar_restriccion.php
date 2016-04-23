<?php

	include("config.php") ;
	$link = mysqli_connect($server, $db_user, $db_pass) or die("Error " . mysqli_error($link)); 
	mysqli_select_db($link,$database);

	$poligonos = mysqli_query($link,"select max(idpoligono) as id from poligono ") or die(mysqli_error($link));
	$pol=mysqli_fetch_array($poligonos);

	$m = $pol['id'];
    
	$idcapa = $_POST['idcapa'];
	$descripcion = $_POST['descripcion'];
	$nrorestricciones = mysqli_query($link,"select * from restriccion where idpoligono=".$m."") or die(mysqli_error($link));

	$nrorest = mysqli_num_rows($nrorestricciones); 
	mysqli_query ($link,"UPDATE poligono SET idcapa='$idcapa', descripcion='$descripcion', nro_res='$nrorest' where idpoligono=".$m."") or die ($link);
	$capi = mysqli_query($link,"select * from capa where idcapa=".$idcapa." ") or die(mysqli_error($link));
	$cap=mysqli_fetch_array($capi);
	echo json_encode(array("color" => "$cap[color]", "descripcion" => "$descripcion", "nombre" => "$cap[nombre]")); 
	
	

?>