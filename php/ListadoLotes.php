<?php

include('database.php');

$sql="
SELECT      id,
            b.rsabrvda as iafa,
            a.lote_tedef as lote,
            factura_inicio||' - '||factura_fin as rango,
            CASE estado
            WHEN 1 THEN 'CERRADO'
            WHEN 0 THEN 'ABIERTO'
            END estado,
            b.rsabrvda||'('||lote_tedef||')' as descripcion,
            tlote
FROM TEDEF a
INNER JOIN pwces00 b ON(a.iafas=b.codigo_iafas) ORDER BY id DESC LIMIT 50
";

if(!$result = pg_exec($sql)) die("no se ejecuto query");
$json = array(); //creamos un array
while($row = pg_fetch_array($result)) 
{   
    $id=$row['id'];
    $iafa=$row['iafa'];
    $lote=$row['lote'];
    $rango=$row['rango'];
    $estado=$row['estado'];
    $descripcion=$row['descripcion'];
    $tlote=$row['tlote'];
	$json[] = array('id'=>$id,'iafa'=> $iafa,'lote'=> $lote,'rango'=> $rango,'estado'=>$estado, 'descripcion'=>$descripcion,'tlote'=>$tlote);
}

$json_string = json_encode($json);
echo $json_string;



?>