<?php

include('database.php');


$sql="SELECT id,
             iafas,
             lote,
             factura,
            observacion,
            usuario,
            to_char(fecha,'dd/mm/yyyy') as fecha 
FROM facturas_Ftrama ORDER BY id DESC LIMIT 6";

if(!$result = pg_exec($sql)) die("no se ejecuto query");
$json = array(); //creamos un array
while($row = pg_fetch_array($result)) 
{ 
    $id=$row['id'];    
	$iafas=$row['iafas'];
    $lote=$row['lote'];
    $factura=$row['factura'];
    $observacion=$row['observacion'];
    $usuario=$row['usuario'];
    $fecha=$row['fecha'];
    $json[] = array('id' =>$id ,'iafas'=> $iafas, 'lote'=> $lote,'factura' =>$factura, 'observacion'=> $observacion,'usuario' =>$usuario ,'fecha'=>$fecha);
    
}

$json_string = json_encode($json);
echo $json_string;


?>