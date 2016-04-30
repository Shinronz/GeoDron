<?php

	include("config.php") ;
	$link = mysqli_connect($server, $db_user, $db_pass) or die("Error " . mysqli_error($link)); 
	mysqli_select_db($link,$database);

	$poligonos = mysqli_query($link,"select max(idvuelo) as id from vuelo ") or die(mysqli_error($link));
	$pol=mysqli_fetch_array($poligonos);

	$m = $pol['id'];
    
	$iddron = $_POST['iddron'];
	$drone = mysqli_query($link,"select autonomia from dron inner join modelo on dron.idmodelo=modelo.idmodelo where dron.id='$iddron' ") or die(mysqli_error($link));
	$dron=mysqli_fetch_array($drone);

	$fec=explode("/",$_POST['dia']);
	$fecha=$fec[2].'-'.$fec[1].'-'.$fec[0];

	$idtipovuelo = $_POST['idtipovuelo'];
	$altura_min = $_POST['altura_min'];
	$altura_max = $_POST['altura_max'];
	$dia = $fecha;
	$hora= $_POST['hora'];
	$fecha = $fecha." ".$_POST['hora'];
	$baterias = $_POST['baterias']*$dron['autonomia'];
    
	/*$nrorestricciones = mysqli_query($link,"select * from restriccion_zonavuelo where idvuelo=".$m."") or die(mysqli_error($link));
	$nrorest = mysqli_num_rows($nrorestricciones); */
	mysqli_query ($link,"UPDATE vuelo SET tipo_vuelo='$idtipovuelo', altura_min='$altura_min', altura_max='$altura_max', dia='$dia', hora='$hora', fecha_hora='$fecha', duracion='$baterias', iddron='$iddron' where idvuelo=".$m."") or die ($link);
	$tipovuelo = mysqli_query($link,"select * from tipo_vuelo where id_tipovuelo=".$idtipovuelo." ") or die(mysqli_error($link));
	$cap=mysqli_fetch_array($tipovuelo);
	
	echo json_encode(array("color" => "#000000", "descripcion" => "$cap[descripcion]", "nombre" => "Nombre del vuelo"));

?>