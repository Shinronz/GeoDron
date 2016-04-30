<?php
require_once 'class.login.php';

$request_body = file_get_contents('php://input');
$json = json_decode($request_body);
$us = $json->{'us'};
$pas = $json->{'pas'};

$login = new Login(false, $us, $pas);
$login->loguear();
echo $_SESSION['id'];

/*if (isset($_POST['us']) && isset($_POST['pas'])) {
	$us =$_POST['us'];
	$pas = hash('sha512', strval($_POST['pas']));
} else {
	$us = $json->{'us'};
	$pas = $json->{'pas'};
}*/

/*include("config.php");
$link = mysqli_connect($server, $db_user, $db_pass);
if (!$link) {
	die('Could not connect: ' . mysqli_error($link));
}

mysqli_select_db($link,$database);

$sql = "SELECT id FROM usuario WHERE mail='".$us."' AND pass='".$pas."';";

$result = mysqli_query($link, $sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row =mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo $row["id"];
	}

	 $_SESSION['loggedin'] = true;
	 $_SESSION['id'] = $row["id"];
	 $_SESSION['start'] = time();
	 $_SESSION['expire'] = $_SESSION['start'] + (20 * 60) ;
 
}else{
	echo 0;
}

mysqli_close($link);*/
?>

