 <?php
  include("config.php") ;
  $link = mysqli_connect($server, $db_user, $db_pass) or die("Error " . mysqli_error($link)); 
  mysqli_select_db($link,$database);
  $poligonos = mysqli_query($link,"select * from restriccion AS r inner join poligono AS p on r.idpoligono=p.idpoligono inner join capa as c on c.idcapa=p.idcapa where p.idcapa>0 and p.nro_res>0 order by r.idpoligono, r.idrestriccion ") or die(mysqli_error($link));

$contv=0;
$band=0;
  while($pol=mysqli_fetch_array($poligonos)){ 
          if($band!=$pol['idpoligono']){ $band= $pol['idpoligono'];  

              //$vecvertices[$contv]=new Array();
              $vecvertices[$contv][0] = " ";
              $vecvertices[$contv][1] = $pol['idpoligono'];
              $vecvertices[$contv][2] = $pol['color'];
              $vecvertices[$contv][3] = $pol['nombre'];
              $vecvertices[$contv][4] = $pol['descripcion'];
              $vecvertices[$contv][5] = $pol['idcapa'];;

              $contv++;
         	}
  }

echo json_encode($vecvertices);

?>