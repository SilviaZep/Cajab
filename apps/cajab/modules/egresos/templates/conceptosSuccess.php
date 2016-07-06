     
<!--Creando modal de generar nueva cita  -->
<!-- Button trigger modal -->
<div  class="panel-body">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#conceptoModal">  
        <i class="fa fa-user-plus">Nuevo Concepto</i>
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="conceptoModal" tabindex="-1" role="dialog" aria-labelledby="conceptoLabel" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="empleadoLabel">Nuevo Concepto</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class = "form-horizontal" id = "form_concepto">
                        <div class="col-xs-12">
                            <div class="form-group">
                            <label for="nombre" class="col-xs-4 control-label">Servicio:</label>
                            <div class="col-xs-8">
                               <select id="idServicio"  name="idServicio" class="form-control">
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
                                <label for="existencia" class="col-xs-4 control-label">Concepto de pago:</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="concepto" name="concepto" placeholder="Concepto de pago">
                                </div>
                            </div>
                        </div>
                        </br></br>
						 
                    </form>      
                </div>
            </div>
            <div class="modal-footer" id="guardarConceptos">                       
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button> 
                <a id="btn-concepto" href="#" class="btn btn-success" role="button">Guardar</a>                        
            </div>             
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="conceptosActModal" tabindex="-1" role="dialog" aria-labelledby="conceptosActLabel" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="empleadoLabel">Actualizar Concepto</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class = "form-horizontal" id = "form_concepto_act">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="nombre" class="col-xs-4 control-label">Concepto:</label>
                                <div class="col-xs-8">
								    <input type="hidden" class="form-control"  id="id1" name="id1">
                                    <input type="text" class="form-control"  id="concepto1" name="concepto1" placeholder="Concepto">
                                </div>
                            </div>
                        </div>
                        </br> </br>                       
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="unidad" class="col-xs-4 control-label">Estatus:</label>
                                <div class="col-xs-8">
                                    <select class="form-control" id="estatus" name="estatus">
                                        <option value="1" selected>Activo</option>
                                        <option value="0">Baja</option>                                       
                                    </select>
                                </div>
                            </div>
                        </div>
						</br></br>
                      					
                    </form>      
                </div>
            </div>
            <div class="modal-footer" id="guardarConcepto">                       
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button> 
                <a id="btn-concepto-act" href="#" class="btn btn-success" role="button">Actualizar</a>                        
            </div>             
        </div>
    </div>
</div>

<div class = "search_container">
    <i class = "fa fa-search search_ic"></i><input id = "conceptoSearch" type = "text" class = "form-control" placeholder = "Search..." />
</div>
<table id = "conceptoTable" class = "display" cellspacing = "0" width = "100%">
    <thead>
        <tr>
            <th class = "col-xs-1"></th>
            <th class = "col-xs-2">Servicio</th>
			<th class = "col-xs-1">Concepto</th> 
            <th class = "col-xs-1">Estatus</th>
            <th class = "col-xs-1"></th>

        </tr>
    </thead>
    <tbody>
<?php $i = 0;  
if ($conceptos->count() > 0):		
            foreach ($conceptos as $record):
                 if($record['estatus']==1){
					 $tipo_status='<span class="label label-success">Activo</span>';}
				else{
					$tipo_status='<span class="label label-danger">Baja</span>';
				} 
				?> 
                <tr id=" <?php echo $record['id']; ?>">
                    <td><?php echo $record['id']; ?></td>      
                    <td class="col-xs-1"><?php echo $record['servicio']; ?></td>
					<td class="col-xs-1"><?php echo $record['concepto']; ?></td>
                    <td class="col-xs-1"><?php echo $tipo_status; ?></td>                   
					 <td class="col-xs-1">
					 <a href = "javascript:editar('<?php echo $record['id'];?>','<?php echo $record['concepto'];?>','<?php echo $record['estatus'];?>')" class = "fa fa-pencil-square-o fa-lg"></a> &nbsp
					 </td>  
					</tr>             
        <?php $i++;endforeach; endif;?>     

    </tbody>
</table>
</div>
<!-- tabla-->


<script>
   
  
    $(document).ready(function(){
        $("#mConcepto").addClass("activeNew");
    
        var conceptoTable = $("#conceptoTable").dataTable({
            sDom: 't<"bottom"p>',
            "pageLength": 8,
            "aoColumns": [ 
                { "sClass": "" },
                { "sClass": "" }, 
                { "sClass": "" },
                { "sClass": "" },
                { "sClass": "" }
				],
            "oLanguage": { "sZeroRecords": "No hay registros",
                "oPaginate": { "sPrevious": "<<",
                    "sNext": ">>" } },
            "aoColumnDefs": [ { 'bSortable': false, 
                    'aTargets': [ 2 ] } ]
        }); //end datatable
        $("#conceptoSearch").keyup(function(){
            conceptoTable.api().search($(this).val()).draw();
        });
       
        
        $("#btn-concepto").click(function(){
            var form = document.getElementById('form_concepto');
            var dataForm = new FormData(form);        
  	  
            $.ajax({          
                url: "<?php echo url_for("@conceptos_agregar"); ?>",
                data:dataForm,
                type: 'POST',       
                contentType: false,
                dataType: "JSON",
                processData: false
            }).done(function(response){
                if(response== "OK")
                {
                    $('#conceptoModal').modal('hide');     
                    limpiarCampos();
                    location.reload();                           
                }
                else
                {
                    alert(response);
                }
        
            });//end ajax done
        });
		
		 $("#btn-concepto-act").click(function(){
            var form = document.getElementById('form_concepto_act');
            var dataForm = new FormData(form);        
  	  
            $.ajax({          
                url: "<?php echo url_for("@conceptos_modificar"); ?>",
                data:dataForm,
                type: 'POST',       
                contentType: false,
                dataType: "JSON",
                processData: false
            }).done(function(response){
                if(response== "OK")
                {
                    $('#conceptosActModal').modal('hide');
					limpiarCampos();
                    location.reload();                           
                }
                else
                {
                    alert("Error");
                }
        
            });//end ajax done
        });
       
	  });// end ready  
       

    function editar(id,concepto,estatus)
    { 
        
			$('#id1').val(id);		
            $('#concepto1').val(concepto);
            $('#estatus').val(estatus);
           $("#conceptosActModal").modal('show');
    }
	
	 function limpiarCampos()
    { 
        
			$('#id1').val();		
            $('#concepto1').val();				
            $('#idServicio').val();
			$('#concepto').val();
            $('#estatus').val();
    }
	
	 
    
</script>
