<?php
session_start();
set_time_limit(1440);
?>
<?php include('../incluide/head.php'); ?>
<!--FORMULARIO-->
<div class="container p-4">
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <form id="generarTrama">
                        <div class="form-group">
                            <select class="form-control" id="Aseguradora"></select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="TipoLote"></select>
                        </div>
                        <!-- <div class="form-group">
                            <input type="text" id="lote" class="form-control" placeholder="INGRESAR LOTE">
                        </div> -->
                        <div class="form-group">
                            <input type="text" id="inicio" class="form-control" placeholder="INGRESAR INICIO FACTURA">
                        </div>
                        <div class="form-group">
                            <input type="text" id="fin" class="form-control" placeholder="INGRESAR FIN FACTURA">
                        </div>
                        <div class="form-group">
                            <button type="button" class="Generar-TEDEF btn btn-primary btn-block text-center">
                                Generar TEDEF AMB
                            </button>
                        </div>
                        <button type="button" class="nuevo btn btn-primary btn-block text-center">
                            Nuevo
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!--LISTADO FUERA DE TRAMA-->
        <div class="col-md-7">
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>IAFAS </th>
                        <th>LOTE</th>
                        <th>TIPO LOTE</th>
                    </tr>
                </thead>
                <tbody id="ListadoLotesAC"></tbody>
            </table>
        </div>
    </div>
</div>
<div id="mensaje-validacion"></div>
<?php include('../incluide/modal-mensaje.php'); ?>
<?php include('../incluide/modal-carga.php'); ?>
<?php include('../incluide/footer.php'); ?>