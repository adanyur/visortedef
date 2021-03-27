<?php

include('database.php');

$dato=$_POST['buscarLotes'];

if($dato == null){
    echo "no hay dato";
}

$sql="
    SELECT  a.id,
			b.rsabrvda as iafas,
            a.lote_tedef as lote,
            factura_inicio||' - '||factura_fin as rango,
            CASE estado
                WHEN 1 THEN 'CERRADO'
                WHEN 0 THEN 'ABIERTO'
            END estado,
            tlote,
            b.rsabrvda||'('||lote_tedef||')' as descripcion,
            usuario_inicio||'-'||COALESCE (usuario_fin,'') as usuario,
            to_char(fecha_inicio,'dd/mm/yyyy') as fecha
    FROM TEDEF a
    INNER JOIN pwces00 b ON(a.iafas=b.codigo_iafas) 
    WHERE CASt(lote_tedef AS VARCHAR) LIKE '$dato%' ORDER BY 1 DESC
";

$result = pg_exec($sql);
$count = pg_num_rows($result);
$json = array();
$reg="";

if($count > 0){
    
    while($row = pg_fetch_array($result)) 
{ 	$id=$row['id'];
	$iafas=$row['iafas'];
    $lote=$row['lote'];
    $rango=$row['rango'];
    $estado=$row['estado'];
    $tlote=$row['tlote'];
    $json[] = array('reg' => 1 ,'id'=>$id,'iafas'=> $iafas, 'lote'=> $lote,'rango'=> $rango,'estado'=>$estado,'tlote'=>$tlote);
}

}else{
    $json[] = array('reg' => 0);
}


$json_string = json_encode($json);
echo $json_string;


?>