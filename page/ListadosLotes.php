<?php
session_start();
?>
<?php include('../incluide/head.php');?>
     <!--FORMULARIO-->
    <div class="container p-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                        <div class="card-header text-center">
                            <h3>Lotes</h3>
                        </div>
                          <div class="card-body">
                            <form id="Listados">
                                    <input class="form-control mr-sm-2" id="buscarLotes" type="search" placeholder="Buscar" aria-label="Search">
                            </form>
                             <p>
                            <table class="table table-hover text-center">
                            <thead>
                                <tr >
                                    <th>IAFAS </th>
                                    <th>LOTE</th>
                                    <th>RANGO</th>
                                    <th>TIPO LOTE</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="ResultLotes"></tbody>
                            <tbody id="ListadoLotes"></tbody>
                        </table> 
                     </div>
                </div>  
            </div>    
        </div>
    </div>
<?php include('../incluide/footer.php');?>