<?php
session_start();
include('database.php');
include('Generador_trama_AMB.php');
require_once 'zip.class.php';

$inicio = trim($_POST['inicio']);
$fin = trim($_POST['fin']);
$lote = trim($_POST['lote']);
$usuario = $_SESSION['usuario'];
$aseguradora = $_POST['aseguradoras'];
$tipo_lote = $_POST['tipolotes'];

$result_explode = explode('|', $aseguradora);
$result_tipolote = explode('|', $tipo_lote);


//$result_explode[0]//CODIGO ISIS
//$result_explode[1]//CODIGO IAFAS
//$result_explode[2]//DESCRIPCION IAFAS



$count = validacion_lotes($lote);
$numero_lote = generar_numero_lote($lote, $result_explode[1], $count);
$loten = str_pad($numero_lote, 7, "0", STR_PAD_LEFT);

// if ($count == 0) {
// 	$insert = "INSERT INTO tedef(usuario_inicio,fecha_inicio,iafas,lote_tedef,estado,tlote)
// 	VALUES ('$usuario',NOW(),'$result_explode[1]',$numero_lote,0,'$result_tipolote[0]')";
// 	pg_exec($insert);
// }

$ArchivoZip = $numero_lote;

//$RutaDestinoTrama = "/var/www/html/VisorTedef/TEDEF_AMB/ArchivoPlano/" . $ArchivoZip;
//$RutaDestino = "/var/www/html/VisorTedef/TEDEF_AMB/ArchivoPlano/";

$RutaDestinoTrama = "C:\laragon\www\@visor\TEDEF_AMB\ArchivoPlano" . $ArchivoZip;
$RutaDestino = "C:\laragon\www\@visor\TEDEF_AMB\ArchivoPlano";


$count = count(glob($RutaDestino . '{*}', GLOB_BRACE)); //obtenemos todos los nombres de los ficheros
$files = glob($RutaDestino . '{*}', GLOB_BRACE); //obtenemos todos los nombres de los ficheros

if ($count > 0) {
	foreach ($files as $file) {
		$NumeroArchivo = opendir($file);
		while (($archivo = readdir($NumeroArchivo)) !== false) {
			if ($archivo <> ".." and $archivo <> ".") {
				$eliminar = $file . "/" . $archivo;
				unlink($eliminar); //ELIMINAR EL CONTENIDO DENTRO DE UN ARCHIVO 
			}
		}
		rmdir($file);
		mkdir($RutaDestinoTrama, 0777, TRUE);
	}
} else {
	mkdir($RutaDestinoTrama, 0777, TRUE);
}



//NOMBRE DE ARCHIVOS PARA CADA TABLA DEL TEDEF
$dfac = $RutaDestinoTrama . "/dfac_20100375061_00013383_" . $result_explode[1] . "_" . $loten . "_" . date('Ym') . "_" . date('Ymd');
$date = $RutaDestinoTrama . "/date_20100375061_00013383_" . $result_explode[1] . "_" . $loten . "_" . date('Ym') . "_" . date('Ymd');
$dser = $RutaDestinoTrama . "/dser_20100375061_00013383_" . $result_explode[1] . "_" . $loten . "_" . date('Ym') . "_" . date('Ymd');
$dden = $RutaDestinoTrama . "/dden_20100375061_00013383_" . $result_explode[1] . "_" . $loten . "_" . date('Ym') . "_" . date('Ymd');
$dfar = $RutaDestinoTrama . "/dfar_20100375061_00013383_" . $result_explode[1] . "_" . $loten . "_" . date('Ym') . "_" . date('Ymd');


//FUNCIONES QUE GENERAN LA TRAMA
$dfac_n = tedef_dfac($lote, $dfac);
if ($dfac_n > 0) {
	$date_n = tedef_date($lote, $date);
	if ($date_n > 0) {
		$dser_n = tedef_dser($lote, $dser);
		if ($dser_n > 0) {
			$dfar_n = tedef_dfar($lote, $dfar);
			if ($dfar_n > 0) {
				tedef_dden($dden);
				$r = 0;
			} else {
				$r = 4;
			}
		} else {
			$r = 3;
		}
	} else {
		$r = 2;
	}
} else {
	$r = 1;
}



/*if ($r == 0) {

	$RutaDescZip = "/var/www/html/VisorTedef/TEDEF_AMB/Descarga";
	$TotalZip = count(glob($RutaDescZip . '/{*.zip}', GLOB_BRACE));
	$zipTotal = glob($RutaDescZip . '/{*.zip}', GLOB_BRACE);

	if ($TotalZip > 0) {
		foreach ($zipTotal as $total) {
			unlink($total);
		}
	}

	$zipper = new ZipArchiver;
	$RutaDescarga = "/var/www/html/VisorTedef/TEDEF_AMB/Descarga/" . $result_explode[2] . "-" . $result_tipolote[0] . ".zip";
	$zip = $zipper->zipDir($RutaDestinoTrama, $RutaDescarga);
	$result = 0;
}*/

echo $result;
