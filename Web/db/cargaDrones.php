<?php  
  include("config.php") ;
  $link = mysqli_connect($server, $db_user, $db_pass) or die("Error " . mysqli_error($link)); 
  mysqli_select_db($link,$database);
   session_start(); 
  $id= $_SESSION['id'];

  $drones = mysqli_query($link,"SELECT mo.nombre_modelo AS nombre, mar.nombre_marca AS nombre_marca, dr.id AS id
FROM dron AS dr
INNER JOIN modelo AS mo ON mo.idmodelo = dr.idmodelo
INNER JOIN marca AS mar ON mar.idmarca = mo.idmarca
WHERE dr.idusuario =  '$id'
ORDER BY dr.id
") or die(mysqli_error($link));


	$cant=0; 
    while($dro=mysqli_fetch_array($drones)) { 
            echo "<option value=". $dro['id'].">";
             echo $dro['nombre_marca']." (".$dro['nombre'].")</option>";
    }
  
?>