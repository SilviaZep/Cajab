      
<!--Creando modal de generar nueva cita  -->
<!-- Button trigger modal -->
<div  class="panel-body">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#proveedorModal">  
        <i class="fa fa-user-plus"> Nuevo Proveedor</i>
    </button>
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#egresoModal">  
        <i class="fa fa-user-plus"> Nuevo Egreso</i>
    </button>
	<a class="btn btn-primary" href="<?php echo url_for("@egresos_imprimir");  ?>" target="_black">  
        <i class="fa fa-user-plus"> Imprimir</i>
    </a>
</div>


<!-- Modal -->
<div class="modal fade" id="proveedorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Nuevo Proveedor</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="nombre" class="col-xs-4 control-label">Nombre(s):</label>
                            <div class="col-xs-8">
                                <input type="text" class="form-control"  id="nombre" placeholder="Nombre">
                            </div>
                        </div>
                    </div>
                    </br> </br>  
                    
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="domicilio" class="col-xs-4 control-label">Domicilio:</label>
                            <div class="col-xs-8">
                                <textarea class="form-control" id="domicilio" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    </br></br></br></br>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="telCasa" class="col-xs-4 control-label">Telefono</label>
                            <div class="col-xs-8">
                                <input type="number" id="tel" class="form-control"  placeholder="Telefono">
                            </div>
                        </div>
                    </div>
                    </br></br>
                  
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="correo" class="col-xs-4 control-label">Correo Electronico:</label>
                            <div class="col-xs-8">
                                <input type="email" id="correo" class="form-control"  placeholder="Email">
                            </div>
                        </div>  
                    </div>
                    </br>   </br>
                </div>
            </div>
            <div class="modal-footer" id="guardarCliente">                       
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button> 
                <a id="btn-proveedor" href="#" class="btn btn-success" role="button">Guardar</a>                        
            </div>             
        </div>
    </div>
</div>
<div class="modal fade" id="egresoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Nuevo Egreso</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="nombre" class="col-xs-4 control-label">Servicio:</label>
                            <div class="col-xs-8">
                               <select id="servicioId" class="form-control">
							   <option value="0">Selecciona uno</option>
							   <?php $i = 0;  
								if ($servicios->count() > 0):		
											foreach ($servicios as $record):?> 
							   <option value="<?php echo $record['id']; ?>"><?php echo $record['nombre']; ?></option>
							     <?php $i++;endforeach; endif;?>  
							   </select>
                            </div>
                        </div>
                    </div>
                    </br> </br>  
                    
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="domicilio" class="col-xs-4 control-label">Proveedor:</label>
                            <div class="col-xs-8">
                               <select id="proveedor"  class="form-control">
							   <option value="0">Selecciona uno</option>
							   <?php $i = 0;  
								if ($proveedores->count() > 0):		
											foreach ($proveedores as $record):?> 
							   <option value="<?php echo $record['id']; ?>"><?php echo $record['nombre']; ?></option>
							     <?php $i++;endforeach; endif;?>  
							   </select>
                            </div>
                        </div>
                    </div>
                    </br></br>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="telCasa" class="col-xs-4 control-label">Concepto de cobro</label>
                            <div class="col-xs-8">
                               <select id="concepto" name="concepto" class="form-control">
							   </select>
                            </div>
                        </div>
                    </div>
                    </br></br>
                  
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="correo" class="col-xs-4 control-label">Monto:</label>
                            <div class="col-xs-8">
                                <input type="text" id="cantidad" class="form-control"  placeholder="$ Monto">
                            </div>
                        </div>  
                    </div>
                    </br>   </br>
					 <div class="col-xs-12">
                            <div class="form-group">
                                <label for="unidad" class="col-xs-4 control-label">Tipo de pago:</label>
                                <div class="col-xs-8">
                                    <select class="form-control" id="tipo" name="tipo">
                                        <option value="1" selected>Abono</option>
                                        <option value="2">Liquidaci&oacute;n</option>                                       
                                    </select>
                                </div>
                            </div>                       
						</div>
						 </br></br>
						 <div class="col-xs-12" style="display:none" id="refDiv">
                            <div class="form-group">
                                <label for="unidad" class="col-xs-4 control-label">Referencia:</label>
                                <div class="col-xs-8">
                                    <input type="text" id="referencia" class="form-control"  placeholder="# Factura">
                                </div>
                            </div>
                        </div>
						</br></br>
					 <div class="col-xs-12">
                        <div class="form-group">
                            <label for="correo" class="col-xs-4 control-label">Observaciones:</label>
                            <div class="col-xs-8">
                                <textarea id="observaciones" class="form-control"  placeholder="Observaciones"></textarea>
                            </div>
                        </div>  
                    </div>
                    </br>   </br>
                </div>
            </div>
            <div class="modal-footer" id="guardarCliente">                       
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button> 
                <a id="btn-egreso" href="#" class="btn btn-success" role="button">Guardar</a>                        
            </div>             
        </div>
    </div>
</div>

<div>
    <div class = "search_container">
        <i class = "fa fa-search search_ic"></i><input id = "clientesSearch" type = "text" class = "form-control" placeholder = "Search..." />
    </div>
    <table id = "egresoTable" class = "display" cellspacing = "0" width = "100%">
        <thead>
            <tr>
                <th class = "col-xs-1"></th>
                <th class = "col-xs-2">Servicio</th>              
                <th class = "col-xs-1">Proveedor</th> 				
                <th class = "col-xs-2">Concepto de cobro</th>
                <th class = "col-xs-1">Fecha registro</th>
				<th class = "col-xs-1">Tipo pago</th>
				<th class = "col-xs-1">#. Factura</th>
				<th class = "col-xs-1">Observaciones</th>
				<th class = "col-xs-1">Monto</th>				
				
            </tr>
        </thead>
		  <tfoot>		  
            <tr>			
                <th colspan="8" style="text-align:right">Total:</th>  
				<th></th>             
            </tr>
			 
        </tfoot>
        <tbody>
		<?php $i = 0;  
if ($egresos->count() > 0):		
            foreach ($egresos as $record):
			   if($record['tipo_pago']==1){
					 $tipo='<span class="label label-success">Adeudo</span>';}
				else{
					$tipo='<span class="label label-danger">Liquidaci&oacute;n</span>';
				} ?> 
                  <tr id=" <?php echo $record['id']; ?>">
                    <td><?php echo $record['id']; ?></td>  
					<td class="col-xs-1"><?php echo $record['servicio']; ?></td>
                    <td class="col-xs-1"><?php echo $record['proveedor']; ?></td>
                    <td class="col-xs-2"><?php echo $record['concepto']; ?></td>  
                    <td class="col-xs-1"><?php echo $record['fecha_registro']; ?></td>
					<td class="col-xs-1"><?php echo $tipo; ?></td>					
					<td class="col-xs-1"><?php echo $record['referencia']; ?></td>
					<td class="col-xs-2"><?php echo $record['observaciones']; ?></td>  
					<td class="col-xs-1"><?php echo $record['cantidad']; ?></td>
					
					</tr>             
        <?php $i++;endforeach; endif;?>     

        </tbody>
    </table>
</div>
<!-- tabla-->


<script>
    var idCliente=0;
   
    $(document).ready(function(){
		
  $('#servicioId').change(function() {
	   var idServicio = $(this).val();
	    dataForm = new FormData();          		
        dataForm.append('id', idServicio);
	   
		$.ajax({          
            url: "<?php echo url_for("@catalogo_conceptos_pago"); ?>",
            data:dataForm,
            type: 'POST',       
            contentType: false,
            dataType: "JSON",
            processData: false
        }).done(function(conceptos){
			
           
              var options = "";
				options += "<option value = '0'>Selecciona uno</option>";
				for(var i = 0; i < conceptos.length; i++){
				  options += "<option value = '" + conceptos[i].id + "'>" + conceptos[i].concepto + "</option>";
				}//end for
			
				$("#concepto").append(options);                          
                               
        });//end ajax done
	});	
	
	$('#tipo').change(function() { 

	  var tipo = $(this).val();
	  if(tipo==2)
	  {
		  $('#refDiv').show(); 
	  }
	  else{
		   $('#refDiv').hide();
	  }
	  
	});	
     $("#mClientes").addClass("activeNew");
	 
	 
        var egresoTable = $("#egresoTable").dataTable({
            sDom: 't<"bottom"p>',
            "pageLength": 18,
            "aoColumns": [ 
                { "sClass": "" },
                { "sClass": "" }, 
                { "sClass": "" },
                { "sClass": "" },
				{ "sClass": "" },
				{ "sClass": "" },
				{ "sClass": "" },
				{ "sClass": "" },
                { "sClass": "" }],
            "oLanguage": { "sZeroRecords": "No hay registros",
                "oPaginate": { "sPrevious": "<<",
                    "sNext": ">>" } },
            "aoColumnDefs": [ { 'bSortable': false, 
                    'aTargets': [ 2 ] } ],
					"footerCallback": function ( row, data, start, end, display ) {
                 var api = this.api(), data;
				 
				   var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
			
			// Total over all pages
            total = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 8 ).footer() ).html(
                '$'+pageTotal
            );
        }
        }); //end datatable
        $("#clientesSearch").keyup(function(){
            egresoTable.api().search($(this).val()).draw();
        });
      
    
        
    $("#btn-proveedor").click(function(){
        dataForm = new FormData();          		
        dataForm.append('nombre', $('#nombre').val());      
        dataForm.append('domicilio', $('#domicilio').val());
        dataForm.append('correo', $('#correo').val());
        dataForm.append('tel', $('#tel').val());
		
		if($('#nombre').val() !=""){
		 $.ajax({          
            url: "<?php echo url_for("@agregar_proveedor"); ?>",
            data:dataForm,
            type: 'POST',       
            contentType: false,
            dataType: "JSON",
            processData: false
        }).done(function(response){
            if(response== "OK")
            {
                $('#proveedorModal').modal('hide');               
				limpiarCampos();
                location.reload();                          
            }
            else
            {
                alert("Error");
            }
        
        });//end ajax done
		}
		else{
			alert("Hay campos requeridos");
		}
    });
	
	 $("#btn-egreso").click(function(){
        dataForm = new FormData();  
		dataForm.append('servicio', $('#servicioId').val());      
        dataForm.append('cantidad', $('#cantidad').val());
        dataForm.append('tipo', $('#tipo').val());
        dataForm.append('referencia', $('#referencia').val());
		dataForm.append('proveedor', $('#proveedor').val());
		dataForm.append('concepto', $('#concepto').val());
		dataForm.append('observaciones', $('#observaciones').val());
        
		if($('#servicioId').val() !="" || $('#cantidad').val() !=""){
		$.ajax({          
            url: "<?php echo url_for("@agregar_egresos"); ?>",
            data:dataForm,
            type: 'POST',       
            contentType: false,
            dataType: "JSON",
            processData: false
        }).done(function(response){
            if(response== "OK")
            {
                $('#egresoModal').modal('hide');
                limpiarCampos();
                location.reload();                          
            }
            else
            {
                alert("Error");
            }
        
        });//end ajax done
		}
		else{
			alert("Hay campos requeridos");
			}
    });
       
});



function  limpiarCampos()
{
	    $('#nombre').val("");      
        $('#domicilio').val("");
        $('#correo').val("");
        $('#tel').val("");         
}
</script>
