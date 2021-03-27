<?php
session_start();
?>
<?php include('../incluide/head.php');?>

     <!--FORMULARIO-->
  <div class="container p-4">
                <div class="card">
                        <div class="card-header text-center">
                            <h3>Fuera de trama</h3>
                        </div>
                            <div class="card-body">
                              <form id="FueraTrama">                                
                                      <input class="form-control mr-sm-2" id="buscar" type="search" placeholder="Buscar" aria-label="Search">
                              </form>
                             <p>
                        <table class="table table-hover text-center">
                            <thead>
                                <tr >
                                    <th>IAFAS </th>
                                    <th>LOTE</th>
                                    <th>FACTURA</th>
                                    <th width="300">OBSERVACION</th>
                                    <th>USUARIO</th>
                                    <th>FECHA</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="ResultFtrama"></tbody>
                            <tbody id="ListadoFueratramal"></tbody>
                        </table> 
                     </div>
                </div>  
    </div>
<!---MODAL-->
<?php include('../incluide/modal-edit.php');?>
<div id="mensaje-validacion"></div> 
<?php include('../incluide/modal-mensaje.php');?>
<?php include('../incluide/footer.php');?>