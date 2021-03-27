<?php
session_start();
include('database.php');


$codigo=$_POST['id'];
$result_explode = explode('|', $codigo);
$factura=$_POST['factura'];
$usuario=$_SESSION['usuario'];
$observacion=$_POST['observacion'];


$array_factura= explode(';', $factura);


foreach($array_factura as $key=>$value){

$sql ="INSERT INTO facturas_Ftrama(lote,factura,observacion,iafas,usuario,fecha) 
VALUES ($result_explode[0],$value,'$observacion','$result_explode[1]','$usuario',now())";

    if(pg_exec($sql)){
        return 1;
    }else{
        return 0;
    }

}

?>
