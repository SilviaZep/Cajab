      
<!--Creando modal de generar nueva cita  -->
<!-- Button trigger modal -->
<div  class="panel-body">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ClientesModal">  
        <i class="fa fa-user-plus"> Nuevo Proveedor</i>
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="ClientesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                <a id="btn-agregar" href="#" class="btn btn-success" role="button">Guardar</a>                        
            </div>             
        </div>
    </div>
</div>

<div class="modal fade" id="ClientesModificarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel1">Actualizar Proveedor</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id = "div_confirm"></div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="nombre" class="col-xs-4 control-label">Nombre(s):</label>
                            <div class="col-xs-8">							
									 <input type="hidden" class="form-control"  id="id1" name="id1">
                                <input type="text" class="form-control"  id="nombre1" placeholder="Nombre">
                            </div>
                        </div>
                    </div>                    
                    </br> </br> 
                  
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="domicilio" class="col-xs-4 control-label">Domicilio:</label>
                            <div class="col-xs-8">
                                <textarea class="form-control" id="domicilio1" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    </br></br></br></br>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="telCasa" class="col-xs-4 control-label">Telefono:</label>
                            <div class="col-xs-8">
                                <input type="number" id="tel1" class="form-control"  placeholder="Telefono casaa">
                            </div>
                        </div>
                    </div>
                    </br></br>
                     
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="correo" class="col-xs-4 control-label">Correo Electronico:</label>
                            <div class="col-xs-8">
                                <input type="email" id="correo1" class="form-control"  placeholder="Email">
                            </div>
                        </div>  
                    </div>
                    </br>   </br>
                </div>
            </div>

            <div class="modal-footer" id="modificarCliente">                       
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button> 
                <a id="btn-modificar" href="#" class="btn btn-success" role="button">Actualizar</a>                        
            </div> 
        </div>
    </div>
</div>
<div>
    <div class = "search_container">
        <i class = "fa fa-search search_ic"></i><input id = "clientesSearch" type = "text" class = "form-control" placeholder = "Search..." />
    </div>
    <table id = "tableForm" class = "display" cellspacing = "0" width = "100%">
        <thead>
            <tr>
                <th class = "col-xs-1"></th>
                <th class = "col-xs-2">Name</th>              
                <th class = "col-xs-1">Correo</th> 				
                <th class = "col-xs-2">Direccion</th>
                <th class = "col-xs-1">Telefono</th>
				<th class = "col-xs-1"></th>
            </tr>
        </thead>
        <tbody>
		<?php $i = 0;  
if ($proveedores->count() > 0):		
            foreach ($proveedores as $record):?> 
                <tr id=" <?php echo $record['id']; ?>">
                    <td><?php echo $record['id']; ?></td>  
					<td class="col-xs-2"><?php echo $record['nombre']; ?></td>
                    <td class="col-xs-1"><?php echo $record['email']; ?></td>
                    <td class="col-xs-2"><?php echo $record['direccion']; ?></td>  
                    <td class="col-xs-1"><?php echo $record['telefono']; ?></td>                   
					 <td class="col-xs-1">
					 <a href = "javascript:editForm('<?php echo $record['id'];?>','<?php echo $record['nombre'];?>','<?php echo $record['direccion'];?>','<?php echo $record['email'];?>','<?php echo $record['telefono'];?>')" class = "fa fa-pencil-square-o fa-lg"> </a> &nbsp
					</td>  
					</tr>             
        <?php $i++;endforeach; endif;?>     

        </tbody>
    </table>
</div>
<!-- tabla-->
<div  class="panel-body">
    <table class="table table-bordered">
        <tr>

        </tr>
    </table>
</div>

<script>
    var idCliente=0;
   
    $(document).ready(function(){
     $("#mProveedores").addClass("activeNew");
	 
	 
        var clienteTable = $("#tableForm").dataTable({
            sDom: 't<"bottom"p>',
            "pageLength": 8,
            "aoColumns": [ 
                { "sClass": "" },
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
        $("#clientesSearch").keyup(function(){
            tableForm.api().search($(this).val()).draw();
        });
      
    
        
    $("#btn-agregar").click(function(){
        dataForm = new FormData();          		
        dataForm.append('nombre', $('#nombre').val());      
        dataForm.append('domicilio', $('#domicilio').val());
        dataForm.append('correo', $('#correo').val());
        dataForm.append('tel', $('#tel').val());
		
		if($('#nombre').val() !=null || $('#nombre').val() !="")
		{
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
                $('#ClientesModal').modal('hide');
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
			alert("Hay campos que son requeridos");
		}
    });
	
	 $("#btn-modificar").click(function(){
        dataForm = new FormData();       
				
        dataForm.append('id', $('#id1').val());  
        dataForm.append('nombre', $('#nombre1').val());      
        dataForm.append('domicilio', $('#domicilio1').val());
        dataForm.append('correo', $('#correo1').val());
        dataForm.append('tel', $('#tel1').val());
        $.ajax({          
            url: "<?php echo url_for("@proveedor_modificar"); ?>",
            data:dataForm,
            type: 'POST',       
            contentType: false,
            dataType: "JSON",
            processData: false
        }).done(function(response){
            if(response== "OK")
            {
                $('#ClientesModificarModal').modal('hide');
                limpiarCampos();
                location.reload();                          
            }
            else
            {
                alert("Error");
            }
        
        });//end ajax done
    });
       
});

function editForm(id,nombre,domicilio,correo,tel)
{
	
	   $('#id1').val(id); 
	    $('#nombre1').val(nombre);      
        $('#domicilio1').val(domicilio);
        $('#correo1').val(correo);
        $('#tel1').val(tel);  
		$("#ClientesModificarModal").modal('show');
    
                   
}

function  limpiarCampos()
{
		$('#id').val(); 
	    $('#nombre').val();      
        $('#domicilio').val();
        $('#correo').val();
        $('#tel').val();         
}
</script>
