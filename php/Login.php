<?php
session_start();
include('database.php');


$usuario=$_POST['usuario'];
$clave=$_POST['clave'];


$sql="SELECT * FROM psaus00 WHERE ctausro='$usuario' AND ndidntdd='$clave'";
$result = pg_exec($sql);
$count = pg_num_rows($result);

if($count > 0){
    $_SESSION['usuario']=$usuario;
    $_SESSION['tedef']='Trama Generado';
    $_SESSION['mensaje-update']='Se actualizo los datos....';
    echo 1;
}else{
    echo 0;
}

?>