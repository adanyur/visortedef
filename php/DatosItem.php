<?php

include('database.php');

$id=$_POST['id'];

$sql="
    SELECT 
    id,
    rsabrvda as iafa,
    cesgrs,
    factura_inicio,
    factura_fin,
    CASE
    WHEN estado = 0 THEN
    'ABIERTO'
    ELSE
    'CERRADO'
    END as estado,
    tlote,
    iafas AS codiafas,
    substring(tlote from 1 for 1) as idtlote
    FROM tedef a
    INNER JOIN pwces00 b ON(a.iafas=b.codigo_iafas )  
    WHERE id=$id
";

if(!$result = pg_exec($sql)) die("no se ejecuto query");
$json = array(); //creamos un array
while($row = pg_fetch_array($result)) 
{   
    $id=$row['id'];
    $iafa=$row['iafa'];
    $cesgrs=$row['cesgrs'];
    $facturaInicio=$row['factura_inicio'];
    $facturaFin=$row['factura_fin'];
	$estado=$row['estado'];
    $tlote=$row['tlote'];
    $codiafas=$row['codiafas'];
    $idtlote=$row['idtlote'];
    $json[] = array(
                'id'=>$id,'iafa'=> $iafa,'cesgrs'=>$cesgrs,'facturaInicio'=> $facturaInicio,'facturaFin'=> 
                $facturaFin,'estado'=>$estado,'tlote'=>$tlote,'codiafas'=>$codiafas,'idtlote' => $idtlote
                );
}

$json_string = json_encode($json);
echo $json_string;



?>