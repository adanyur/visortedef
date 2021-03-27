<?php
session_start();
?>
<?php include('../incluide/head.php'); ?>


<!--FORMULARIO-->
<div class="container p-4">
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <form id="FueraTrama">
                        <div class="form-group">
                            <select class="form-control" id="ListadoLotesA"></select>
                        </div>

                        <div class="form-group">
                            <input type="text" id="factura" class="form-control" placeholder="INGRESAR FACTURA">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="observacion" placeholder="OBSERVACION" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block text-center">
                            Enviar Fuera de trama
                        </button>
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
                        <th>FACTURA</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="ListadoFueratrama"></tbody>
            </table>
        </div>
    </div>
</div>
<div id="mensaje-validacion"></div>
<?php include('../incluide/footer.php'); ?>