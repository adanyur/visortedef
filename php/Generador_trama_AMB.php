<?php
include('database.php');

//VALIDACION SI EXISTE EL RANGO DE FACTURAS
function validacion_lotes($lote)
{

	// $sql="SELECT count(*)as total FROM TEDEF WHERE factura_inicio=$inicio AND factura_fin=$fin AND iafas='$iafas'";

	$sql = "SELECT count(*) as total FROM pwtgn00 WHERE lote=$lote";
	if (!$result = pg_exec($sql)) die("no se ejecuto query");
	while ($row = pg_fetch_array($result)) {
		return $row['total'];
	}
}

function generar_numero_lote($lote, $iafas, $count)
{

	if ($count > 0) {
		$sql = "SELECT max(lote) as lote_tedef FROM pwtgn00 p WHERE lote=$lote";
	} else {
		$sql = "SELECT  lote_tedef + 1 AS lote_tedef
				FROM TEDEF t 
				INNER JOIN  pwces00 a ON(t.iafas=a.codigo_iafas) 
				WHERE IAFAS='$iafas' 
				ORDER BY lote_tedef  
				DESC LIMIT 1";
	}

	if (!$result = pg_exec($sql)) die("no se ejecuto query");
	while ($row = pg_fetch_array($result)) {
		return $row['lote_tedef'];
	}
}



//FUNCION PARA GENERAR TRAMA DE LA TABLA FACTURACION


// function tedef_dfac($inicio, $fin, $lote, $iafas, $archivo)
function tedef_dfac($lote, $archivo)
{

	$sql = "SELECT * FROM uf_tedef_dfac($lote);";

	if (!$result = pg_exec($sql)) die("no se ejecuto query");
	$ar1 = fopen($archivo . ".txt", "w+");
	while ($row = pg_fetch_array($result)) {
		$dato = $row['trama'] . "\r\n";
		fwrite($ar1, $dato);
	}
	if (fclose($ar1)) {
		return 1;
	} else {
		return 0;
	}
}


//FUNCION PARA GENERAR TRAMA DE LA TABLA ATENCION
// function tedef_date($inicio, $fin, $lote, $iafas, $archivo)
function tedef_date($lote, $archivo)
{
	$sql = "SELECT * FROM uf_tedef_date($lote);";
	if (!$result = pg_exec($sql)) die("no se ejecuto query");
	$ar1 = fopen($archivo . ".txt", "w+");
	while ($row = pg_fetch_array($result)) {
		$dato = $row['trama'] . "\r\n";
		fwrite($ar1, $dato);
	}
	if (fclose($ar1)) {
		return 1;
	} else {
		return 0;
	}
}

//FUNCION PARA GENERAR TRAMA DE LA TABLA SERVICIO
//function tedef_dser($inicio, $fin, $lote, $iafas, $archivo)
function tedef_dser($lote, $archivo)
{
	$sql = "SELECT * FROM uf_tedef_dser($lote);";
	if (!$result = pg_exec($sql)) die("no se ejecuto query");
	$ar1 = fopen($archivo . ".txt", "w+");
	while ($row = pg_fetch_array($result)) {
		$dato = $row['trama'] . "\r\n";
		fwrite($ar1, $dato);
	}
	if (fclose($ar1)) {
		return 1;
	} else {
		return 0;
	}
}


//FUNCION PARA GENERAR TRAMA DE LA TABLA FARMACIA
function tedef_dfar($lote, $archivo)
{
	$sql = "SELECT * FROM uf_tedef_dfar($lote);";
	if (!$result = pg_exec($sql)) die("no se ejecuto query");
	$ar1 = fopen($archivo . ".txt", "w+");
	while ($row = pg_fetch_array($result)) {
		$dato = $row['trama'] . "\r\n";
		fwrite($ar1, $dato);
	}
	if (fclose($ar1)) {
		return 1;
	} else {
		return 0;
	}
}


function tedef_dden($archivo)
{
	fopen($archivo . ".txt", "a+");
}
