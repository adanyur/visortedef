<?php

include('database.php');

$id=$_POST['id'];

$sql="SELECT 	lote,
	            factura,
	            observacion 
      FROM facturas_ftrama WHERE id=$id
";


if(!$result = pg_exec($sql)) die("no se ejecuto query");
$json = array(); //creamos un array

while($row = pg_fetch_array($result)) 
{
    $lote=$row['lote'];
    $factura=$row['factura'];
    $observacion=$row['observacion'];

    $json[] = array('lote' => $lote,'factura'=>$factura,'observacion' =>$observacion);

}


$json_string = json_encode($json);
echo $json_string;



?>