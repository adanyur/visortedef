$(document).ready(function () {
  //@INICIO
  //FUNCIONES QUE SE EJECUTAN DE FORMA INMEDIATA
  ListadoLotes();
  ListadoLotesA();
  ListadoAseguradora();
  ListadoFtrama();
  ListadoTipoLotes();
  //

  /**************************************LOGIN***************************************************/
  //login
  $("#login").submit(function (e) {
    const data = {
      usuario: $("#usuario").val(),
      clave: $("#clave").val(),
    };
    $.post("php/Login.php", data, function (result) {
      let mensaje;
      if (result == "1") {
        window.location.href = "page/GenerarTedef.php";
      } else {
        $("#modal-mensaje").modal("show");
        $("#mensaje-error").text(
          "Usuario o contraseña Incorrecto, Favor de Revisar"
        );
      }
    });
    e.preventDefault();
  });

  //CERRAR SESSION
  $("#cerrar-sesion").submit(function (e) {
    $.ajax({
      url: "../php/CerrarSession.php",
      type: "POST",
      success: function (result) {
        if (result == 1) {
          window.location.href = "../index.html";
        }
      },
    });
    e.preventDefault();
  });

  /**************************************GENERAR TRAMA***************************************************/

  //FUNCION PARA GENERAR LA TRAMA AMB
  $(document).on("click", ".Generar-TEDEF", function (e) {
    if ($("#Aseguradora").val() == "0") {
      validacionTedef(1);
    } else if ($("#TipoLote").val() == "0") {
      validacionTedef(2);
    } else if ($("#inicio").val() == "") {
      validacionTedef(3);
    } else if ($("#fin").val() == "") {
      validacionTedef(4);
    } else {
      const datos = {
        inicio: $("#inicio").val(),
        fin: $("#fin").val(),
        aseguradoras: $("#Aseguradora").val(),
        tipolotes: $("#TipoLote").val(),
      };
      $("#modal-carga").modal("show");
      $.ajax({
        data: datos,
        url: "../php/Generador_trama_ambulatoria.php",
        type: "POST",
        success: function (result) {
          if (result == 0) {
            $("#modal-carga").modal("hide");
            $("#modal-mensaje").modal("show");
            $("#generarTrama").trigger("reset");
            ListadoLotes();
            ListadoAseguradora();
            ListadoTipoLotes();
            window.location.href = "../php/DescargarArchivo.php";
          }
        },
      });
    }
    e.preventDefault();
  });

  //BOTON NUEVO
  $(document).on("click", ".nuevo", function () {
    $("#generarTrama").trigger("reset");
    $("#FueraTrama").trigger("reset");
    ListadoAseguradora();
    ListadoTipoLotes();
  });

  //FUNCION MODAL
  function validacionTedef(codigo) {
    let mensaje = "";
    let template = "";

    if (codigo == 1) {
      mensaje = "SELECIONAR ASEGURADORA";
    } else if (codigo == 2) {
      mensaje = "SELECCIONAR TIPO DE LOTE";
    } else if (codigo == 3) {
      mensaje = "INGRESAR INICIO DE RANGO";
    } else if (codigo == 4) {
      mensaje = "INGRESAR FACTURA";
    } else {
      mensaje = "INGRESAR INICIO DE RANGO";
    }
    template += `
        <div class="modal fade" id="modal-validacion">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        ${mensaje}
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    $("#mensaje-validacion").html(template);
    $("#modal-validacion").modal("show");
  }

  /***********************************************/

  /**************************************LISTADO DE LOTES***************************************************/
  //LISTADO DE ASEGURADORAS
  function ListadoAseguradora() {
    $.ajax({
      url: "../php/ListadoAseguradora.php",
      type: "GET",
      success: function (result) {
        let aseguradora = JSON.parse(result);
        let template = "";
        template += '<option value="0">SELECCIONAR ASEGURADORA</option>';
        aseguradora.forEach((aseguradora) => {
          template += `<option id="codigo" value="${aseguradora.cesgrs}|${aseguradora.codigo_iafas}|${aseguradora.rsabrvda}">${aseguradora.rsabrvda}</option>`;
        });
        $("#Aseguradora").html(template);
      },
    });
  }

  //LISTADO DE TIPO DE LOTES
  function ListadoTipoLotes() {
    $.ajax({
      url: "../php/ListadoTLote.php",
      type: "GET",
      success: function (result) {
        let Tlote = JSON.parse(result);
        let template = "";
        template += '<option value="0">SELECCIONAR TIPO LOTE</option>';
        Tlote.forEach((Tlote) => {
          template += `<option value="${Tlote.descripcion}|${Tlote.codigo}">${Tlote.descripcion}</option>`;
        });
        $("#TipoLote").html(template);
      },
    });
  }

  //LISTADO LOTES CON ESTADO ABIERTO EN LA TABLA
  function ListadoLotes() {
    $.ajax({
      url: "../php/ListadoLotes.php",
      type: "GET",
      success: function (result) {
        let Llotes = JSON.parse(result);
        let template = "";
        let templateLotes = "";
        let templateI = "";

        Llotes.forEach((Llotes) => {
          const estado = Llotes.estado;

          if (estado == "ABIERTO") {
            color = "background-color:#FFFFFF;";
            icono = '<i class="fas fa-lock-open"></i>';
          } else {
            color = "background-color:#f443366e;";
            icono = '<i class="fas fa-lock"></i>';
          }

          if (estado == "ABIERTO") {
            template += `
                    <tr ida=${Llotes.id} style=${color}>
                        <td>${Llotes.iafa}</td>
                        <td>${Llotes.lote}</td>
                        <td>${Llotes.tlote}</td>
                        <td>
                            <button class="item btn btn-dark">
                                <i class="fas fa-check"></i>
                            </button>
                        <td>
                    </tr>`;
          }

          templateLotes += `
                    <tr idL=${Llotes.id}|${estado} style=${color}>
                    <td>${Llotes.iafa}</td>
                    <td>${Llotes.lote}</td>
                    <td>${Llotes.rango}</td>
                    <td>${Llotes.tlote}</td>
                    <td colspan='3'>
                        <button class="editarL btn btn-dark">
                            ${icono}
                        </button>
                    </td>
                </tr>                
                `;
        });

        $("#ListadoLotesAC").html(template);
        $("#ListadoLotes").html(templateLotes);
        $("#ResultLotes").hide();
      },
    });
  }

  //LISTADO DE LOTES ACTIVOS PARA SELECT EN FUERA DE TRAMA
  function ListadoLotesA() {
    $.ajax({
      url: "../php/ListadoLotes.php",
      type: "GET",
      success: function (result) {
        let lote = JSON.parse(result);
        let template = "";
        template += '<option value="0">SELECCIONAR LOTE</option>';
        lote.forEach((lote) => {
          var estado = lote.estado;
          if (estado == "ABIERTO") {
            template += `<option id="codigo" value="${lote.lote}|${lote.iafa}">${lote.descripcion}</option>`;
          }
        });
        $("#ListadoLotesA").html(template);
      },
    });
  }

  /**************************************FUERA DE TRAMA***************************************************/

  //INSERTAR FACTURA FUERA DE TRAMA
  $("#FueraTrama").submit(function (e) {
    if ($("#ListadoLotesA").val() == "0") {
      validacionFtrama(1);
    } else if ($("#factura").val() == "") {
      validacionFtrama(2);
    } else {
      const data = {
        id: $("#ListadoLotesA").val(),
        factura: $("#factura").val(),
        observacion: $("#observacion").val(),
      };
      $.post("../php/InsertFTrama.php", data, function (result) {
        $("#FueraTrama").trigger("reset");
        ListadoFtrama();
      });
    }
    e.preventDefault();
  });

  //FUNCIONA DE VALIDACION FUERA DE TRAMA

  function validacionFtrama(codigo) {
    let mensaje = "";
    let template = "";
    if (codigo == 1) {
      mensaje = "SELECCIONAR LOTE";
    } else if (codigo == 2) {
      mensaje = "INGRESAR FACTURA";
    }

    template += `
    <div class="modal fade" id="modal-validacion">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            ${mensaje}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    `;
    $("#mensaje-validacion").html(template);
    $("#modal-validacion").modal("show");
  }

  //LISTADO DE FACTURAS FUERA DE TRAMA
  function ListadoFtrama() {
    $.ajax({
      url: "../php/ListadoFueraTrama.php",
      type: "GET",
      success: function (result) {
        let ftrama = JSON.parse(result);
        let template = "";
        let templatel = "";
        ftrama.forEach((ftrama) => {
          template += `
                <tr id="${ftrama.id}">
                    <td>${ftrama.iafas}</td>
                    <td>${ftrama.lote}</td>
                    <td>F102-${ftrama.factura}</td>
                    <td>
                        <button class="eliminar btn btn-danger">
                            <i class="fas fa-trash-alt "></i>
                        </button>
                    </td>
                </tr>
                `;

          templatel += `
                <tr id="${ftrama.id}">
                    <td>${ftrama.iafas}</td>
                    <td>${ftrama.lote}</td>
                    <td>F102-${ftrama.factura}</td>
                    <td>${ftrama.observacion}</td>
                    <td>${ftrama.usuario}</td>
                    <td>${ftrama.fecha}</td>
                    <td> 
                        <button type="button" class="edit-modal btn btn-primary" data-toggle="modal" data-target="#modal-edit" data-whatever="@mdo">
                            <i class="fas fa-pencil-alt "></i>
                        </button>
                    </td>
                    <td>     
                        <button class="eliminar btn btn-danger">
                           <i class="fas fa-trash-alt "></i>
                       </button>
                    </td>
                </tr>
                `;
        });
        $("#ListadoFueratrama").html(template);
        $("#ListadoFueratramal").html(templatel);
      },
    });
  }

  /**************************************MODAL****************************************************************/

  /**************************************OPCION DE BUSQUEDA***************************************************/
  //BUSQUEDA DE FACTURA O LOTE PARA FUERA DE TRAMA
  $("#buscar").keyup(function () {
    if ($("#buscar").val()) {
      let buscar = $("#buscar").val();
      $.ajax({
        url: "../php/BuscarFtrama.php",
        data: { buscar },
        type: "POST",
        success: function (result) {
          if (!result.error) {
            let buscar = JSON.parse(result);
            let template = "";
            buscar.forEach((buscar) => {
              template += `
                <tr id="${buscar.id}">
                     <td>${buscar.iafas}</td>
                     <td>${buscar.lote}</td>
                     <td>F102-${buscar.factura}</td>
                     <td>${buscar.observacion}</td>
                     <td>${buscar.usuario}</td>
                     <td>${buscar.fecha}</td>
                     <td>
                        <button type="button" class="edit-modal btn btn-primary" data-toggle="modal" data-target="#modal-edit" data-whatever="@mdo">
                             <i class="fas fa-pencil-alt "></i>
                        </button>
                    </td>
                    <td>    
                        <button class="eliminar btn btn-danger">
                            <i class="fas fa-trash-alt "></i>
                        </button>
                    </td>
                 </tr>
                `;
            });

            $("#ListadoFueratramal").hide();
            $("#ResultFtrama").show();
            $("#ResultFtrama").html(template);
          }
        },
      });
    } else {
      $("#ResultFtrama").hide();
      $("#ListadoFueratramal").show();
    }
  });

  //BUSQUEDA POR LOTE,IAFAS,USUARIO Y FECHA
  $("#buscarLotes").keyup(function () {
    var a = $("#buscarLotes").val();
    var count = a.length;
    if (count > 0) {
      let buscarLotes = $("#buscarLotes").val();
      $.ajax({
        url: "../php/BuscarLotes.php",
        data: { buscarLotes },
        type: "POST",
        success: function (result) {
          if (!result.error) {
            let buscarLotes = JSON.parse(result);
            let template = "";
            buscarLotes.forEach((buscarLotes) => {
              let estado = buscarLotes.estado;
              if (estado == "ABIERTO") {
                color = "background-color:#FFFFFF;";
                icono = '<i class="fas fa-lock-open"></i>';
              } else {
                color = "background-color:#f443366e;";
                icono = '<i class="fas fa-lock"></i>';
              }

              if (buscarLotes.reg > 0) {
                template += `
                    <tr idL=${buscarLotes.id}|${estado} style=${color}>
                        <td>${buscarLotes.iafas}</td>
                        <td>${buscarLotes.lote}</td>
                        <td>${buscarLotes.rango}</td>
                        <td>${buscarLotes.tlote}</td>
                        <td>
                            <button class="editarL btn btn-dark">
								${icono}
							</button>
                        </td>
                    </tr>
                    `;
              } else {
                template += `
                        <tr>
                            <td colspan='5'>
                                <div class="card">
                                    <div class="card-body">No hay registros</div>
                                </div>
                            </td>
                        </tr>
                        `;
              }
            });
            $("#ListadoLotes").hide();
            $("#ResultLotes").show();
            $("#ResultLotes").html(template);
          }
        },
      });
    } else if (count == 0) {
      $("#ResultLotes").hide();
      $("#ListadoLotes").show();
    }
  });

  /**************************************OPCION DE ACTUALIZAR ESTADO EN LISTADO DE LOTES***************************************************/
  $(document).on("click", ".editarL", (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const id = $(element).attr("idl");
    $.post("../php/CambioEstado.php", { id }, (result) => {
      ListadoLotes();
      $("#ResultLotes").hide();
      $("#ListadoLotes").show();
      $("#Listados").trigger("reset");
    });
    e.preventDefault();
  });
  /**************************************OPCION DE ELIMINAR***************************************************/
  $(document).on("click", ".eliminar", (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const id = $(element).attr("id");
    $.post("../php/Eliminar.php", { id }, (result) => {
      ListadoFtrama();
      $("#ResultFtrama").hide();
      $("#ListadoFueratramal").show();
      $("#FueraTrama").trigger("reset");
    });
  });

  /**************************************OPCION PARA USAR DATOS***************************************************/
  $(document).on("click", ".item", (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const id = $(element).attr("ida");
    $.post("../php/DatosItem.php", { id }, (result) => {
      const item = JSON.parse(result);
      item.forEach((item) => {
        let DatosAseguradora = "";
        let TipoLote = "";

        DatosAseguradora = `
                        <option value="${item.cesgrs}|${item.codiafas}|${item.iafa}">${item.iafa}</option>'
                                `;
        TipoLote = `
                        <option value="${item.tlote}|${item.idtlote}">${item.tlote}</option>'
                        `;
        $("#nuevoLote").show();
        $("#Aseguradora").html(DatosAseguradora);
        $("#TipoLote").html(TipoLote);
        $("#inicio").val(item.facturaInicio);
        $("#fin").val(item.facturaFin);
      });
    });

    e.preventDefault();
  });

  /**************************************MODAL***************************************************/

  $(document).on("click", ".edit-modal", (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const id = $(element).attr("id");

    $.post("../php/DatosFtrama.php", { id }, (result) => {
      const itemftrama = JSON.parse(result);
      let template = "";
      let templateCabecera = "";
      itemftrama.forEach((itemftrama) => {
        templateCabecera += `<b>FACTURA : F102-${itemftrama.factura}</b>`;
        template += `
                <div class="form-group">
                    <label for="message-text" class="col-form-label">OBSERVACION</label>
                    <input type="hidden" id="factura" value="${itemftrama.factura}">
                    <textarea class="form-control" id="message-text">${itemftrama.observacion}</textarea>
                </div>    
                `;
      });
      $("#EditFtrama").html(template);
      $("#cabecera-modal").html(templateCabecera);
    });
    e.preventDefault();
  });

  /**UPDATE DENTRO DEL MODAL PARA FUERA DE TRAMA**/
  $("#edit-ftrama").submit(function (e) {
    if ($("#Aseguradora").val() == "0") {
      validacionModal(1);
    } else if ($("#ListadoLotesA").val() == "0") {
      validacionModal(2);
    } else {
      let aseguradora = $("#Aseguradora").val();
      let lotes = $("#ListadoLotesA").val();
      let factura = $("#factura").val();
      let observaciones = $("#message-text").val();

      $.ajax({
        url: "../php/Actualizarftrama.php",
        data: { aseguradora, lotes, observaciones, factura },
        type: "POST",
        success: function (result) {
          $("#ResultFtrama").hide();
          $("#ListadoFueratramal").show();
          $("#FueraTrama").trigger("reset");
          $("#modal-edit").modal("hide");
          $("#edit-ftrama").trigger("reset");
          ListadoFtrama();
          if (result == 1) {
            $("#modal-mensaje").modal("show");
          }
        },
      });
    }
    e.preventDefault();
  });

  //FUNCIONA DE VALIDACION

  function validacionModal(codigo) {
    let mensaje = "";
    let template = "";
    if (codigo == 1) {
      mensaje = "SELECIONAR ASEGURADORA";
    } else if (codigo == 2) {
      mensaje = "SELECIONAR LOTE";
    }

    template += `
    <div class="modal fade bd-example-modal-sm" id="modal-validacion">
     <div class="modal-dialog modal-sm modal-dialog-centered">
       <div class="modal-content" >
         <div class="modal-body">
           ${mensaje}
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
    </div>
    `;
    $("#mensaje-validacion").html(template);
    $("#modal-validacion").modal("show");
  }
}); //@FIN
