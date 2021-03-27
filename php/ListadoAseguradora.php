<?php

include('database.php');


$sql="
    SELECT 
    cesgrs,
    rsabrvda,
    codigo_iafas
    FROM pwces00
    WHERE length(codigo_iafas) <> '0'
";

if(!$result = pg_exec($sql)) die("no se ejecuto query");
$json = array(); //creamos un array
while($row = pg_fetch_array($result)) 
{ 
    $cesgrs=$row['cesgrs'];
    $rsabrvda=$row['rsabrvda'];
    $codigo_iafas=$row['codigo_iafas'];
	$json[] = array('cesgrs'=> $cesgrs,'rsabrvda'=> $rsabrvda,'codigo_iafas'=> $codigo_iafas);
}

$json_string = json_encode($json);
echo $json_string;


?>