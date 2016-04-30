<?php


$request_body = file_get_contents('php://input');
$json = json_decode($request_body);



if (isset($_POST['us'])&& isset($_POST['pas'])) {
	$us = $_POST['us'];
	$pas = $_POST['pas'];

}else{
	$us = $json->{'us'};
	$pas = $json->{'pas'};
	
}



include("config.php") ;
$link=mysqli_connect($server, $db_user, $db_pass);
if (!$link) {
die('Could not connect: ' . mysqli_error($link));
}
mysqli_select_db($link,$database);
$sql = "SELECT id FROM usuario WHERE mail='".$us."' AND pass='".$pas."';";

$result = mysqli_query($link, $sql);
if ($result->num_rows = 0) {
    // output data of each row
    $sql="INSERT INTO usuario (mail,pass)	VALUES ('$us','$pas')";  
	if($result = mysqli_query($link, $sql)){
								
		echo mysqli_insert_id($link);
	}
	else{ 
		echo "0";
	} 
 
}else{
		echo 0;
		 }


mysqli_close($link);
?>
