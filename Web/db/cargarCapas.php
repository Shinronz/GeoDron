<?php  
  include("config.php") ;
  $link = mysqli_connect($server, $db_user, $db_pass) or die("Error " . mysqli_error($link)); 
  mysqli_select_db($link,$database);
  $capas = mysqli_query($link,"select * from capa order by idcapa ") or die(mysqli_error($link));


	$cant=0; 
    while($caps=mysqli_fetch_array($capas)) { 
            echo "<option value=". $caps['idcapa'].">";
             echo $caps['nombre']."</option>";
    }
?>