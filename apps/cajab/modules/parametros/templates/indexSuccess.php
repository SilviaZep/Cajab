     
<!--Creando modal de generar nueva cita  -->
<!-- Button trigger modal -->
<div  class="panel-body">
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#empleadosModal">  
        <i class="fa fa-user-plus">Nuevo Usuario</i>
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="empleadosModal" tabindex="-1" role="dialog" aria-labelledby="empleadoLabel" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="empleadoLabel">Nuevo Usuario</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class = "form-horizontal" id = "form_empleado">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="nombre" class="col-xs-4 control-label">Nombre:</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control"  id="nombre" name="nombre" placeholder="Empleado">
                                </div>
                            </div>
                        </div>
                        </br> </br>                       
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="unidad" class="col-xs-4 control-label">Rol:</label>
                                <div class="col-xs-8">
                                    <select class="form-control" id="rol" name="rol">
                                        <option value="1">Administrador</option>
                                        <option value="2">Cajero</option>
                                        <option value="3">Empleado</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        </br> </br> 
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="existencia" class="col-xs-4 control-label">Usuario:</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Cuenta de usuario">
                                </div>
                            </div>
                        </div>
                        </br></br>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="precioCompra" class="col-xs-4 control-label">Contrase&ntilde;a:</label>
                                <div class="col-xs-8">
                                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Contrase&ntilde;a">
                                </div>
                            </div>

                        </div>
                        </br></br>
						 
                    </form>      
                </div>
            </div>
            <div class="modal-footer" id="guardarConsumibles">                       
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button> 
                <a id="btn-empleado" href="#" class="btn btn-success" role="button">Guardar</a>                        
            </div>             
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="empleadosActModal" tabindex="-1" role="dialog" aria-labelledby="empleadoActLabel" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="empleadoLabel">Actualizar Usuario</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class = "form-horizontal" id = "form_empleado_act">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="nombre" class="col-xs-4 control-label">Nombre:</label>
                                <div class="col-xs-8">
								    <input type="hidden" class="form-control"  id="id1" name="id1">
                                    <input type="text" class="form-control"  id="nombre1" name="nombre1" placeholder="Empleado">
                                </div>
                            </div>
                        </div>
                        </br> </br>                       
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="unidad" class="col-xs-4 control-label">Rol:</label>
                                <div class="col-xs-8">
                                    <select class="form-control" id="rol1" name="rol1">
                                        <option value="1">Administrador</option>
                                        <option value="2">Cajero</option>
                                        <option value="3">Empleado</option>
                                    </select>
                                </div>
                            </div>
                        </div>
						</br></br>
                      
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="existencia" class="col-xs-4 control-label">Usuario:</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="usuario1" name="usuario1" placeholder="Cuenta de usuario">
                                </div>
                            </div>
                        </div>
                        </br></br> 
				<div class="col-xs-12">
                            <div class="form-group">
                                <label for="existencia" class="col-xs-4 control-label">Desactivar Cuenta:</label>
                                <div class="col-xs-8">
                                   <select class="form-control" id="estatusCuenta" name="estatusCuenta">
								   <option value="1">Activa</option>
								   <option value="2">Baja</option>
								   </select>
                                </div>
                            </div>
                        </div>	
 </br></br> 
				
						</br></br>						
                    </form>      
                </div>
            </div>
            <div class="modal-footer" id="guardarConsumibles">                       
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button> 
                <a id="btn-empleado-actualizar" href="#" class="btn btn-success" role="button">Actualizar</a>                        
            </div>             
        </div>
    </div>
</div>
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordLabel" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="empleadoLabel">Cambiar Contrase&ntilde;a</h4>
            </div>
            <div class="modal-body"> 
                <div class="row">
                    <form class = "form-horizontal" id = "form_pass">                      
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="precioCompra" class="col-xs-4 control-label">Contrase&ntilde;a:</label>
                                <div class="col-xs-8">
								 <input type="hidden" class="form-control"  id="id2" name="id2">
                                    <input type="password" class="form-control" id="pass1" name="pass1" placeholder="Contrase&ntilde;a">
                                </div>
                            </div>
							  <div class="form-group">
                                <label for="precioCompra" class="col-xs-4 control-label">Repite la Contrase&ntilde;a:</label>
                                <div class="col-xs-8">
                                    <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Contrase&ntilde;a">
                                </div>
                            </div>
                        </div>
                        </br></br>
                    </form>      
                </div>
            </div>
            <div class="modal-footer" id="guardarConsumibles">                       
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button> 
                <a id="btn-password" href="#" class="btn btn-success" role="button">Actualizar</a>                        
            </div>             
        </div>
    </div>
</div>

<div class = "search_container">
    <i class = "fa fa-search search_ic"></i><input id = "empleadoSearch" type = "text" class = "form-control" placeholder = "Search..." />
</div>
<table id = "empleadosTable" class = "display" cellspacing = "0" width = "100%">
    <thead>
        <tr>
            <th class = "col-xs-1">#</th>
            <th class = "col-xs-2">Nombre</th>
			<th class = "col-xs-1">Usuario</th> 
            <th class = "col-xs-1">Rol</th> 
            <th class = "col-xs-1">Estatus Cuenta</th>
            <th class = "col-xs-1">Acciones</th>

        </tr>
    </thead>
    <tbody>
<?php $i = 0;  
if ($empleados->count() > 0):		
            foreach ($empleados as $record):
                 if($record['estatus']==1)
			   {$tipo_status='<span class="label label-success">Activo</span>';}
				else{
					$tipo_status='<span class="label label-danger">Baja</span>';
				} 
				if($record['rol']==1)
			   {$rol='<span class="label label-success">Admin</span>';}
				if($record['rol']==2){
					$rol='<span class="label label-danger">Caja</span>';
				}?> 
                <tr id=" <?php echo $record['id']; ?>">
                    <td><?php echo $record['id']; ?></td>      
                    <td class="col-xs-1"><?php echo $record['nombre_completo']; ?></td>
					<td class="col-xs-1"><?php echo $record['usuario']; ?></td>
                    <td class="col-xs-1"><?php echo $rol; ?></td>
                    <td class="col-xs-1"><?php echo $tipo_status; ?></td>                   
					 <td class="col-xs-1">
					 <a title="Editar Usuario" href = "javascript:editar('<?php echo $record['id'];?>')" class = "fa fa-pencil-square-o fa-lg"> </a> &nbsp
					 <a title="Cambiar password" href = "javascript:cambiarPassword('<?php echo $record['id'];?>')" class = "fa fa-key fa-lg"> </a>
					
					 </td>  
					</tr>             
        <?php $i++;endforeach; endif;?>     

    </tbody>
</table>
</div>
<!-- tabla-->


<script>
   
  
    $(document).ready(function(){
        $("#mConsumibles").addClass("activeNew");
    
        var empleadosTable = $("#empleadosTable").dataTable({
            sDom: 't<"bottom"p>',
            "pageLength": 8,
            "aoColumns": [ 
                { "sClass": "" },
                { "sClass": "" }, 
                { "sClass": "" },
                { "sClass": "" },
                { "sClass": "" },                
                { "sClass": "" }             ],
            "oLanguage": { "sZeroRecords": "No hay registros",
                "oPaginate": { "sPrevious": "<<",
                    "sNext": ">>" } },
            "aoColumnDefs": [ { 'bSortable': false, 
                    'aTargets': [ 2 ] } ]
        }); //end datatable
        $("#empleadoSearch").keyup(function(){
            empleadosTable.api().search($(this).val()).draw();
        });
       
        
        $("#btn-empleado").click(function(){
			
            var form = document.getElementById('form_empleado');
            var dataForm = new FormData(form);       
  	  
            $.ajax({          
                url: "<?php echo url_for("@empleados_agregar"); ?>",
                data:dataForm,
                type: 'POST',       
                contentType: false,
                dataType: "JSON",
                processData: false
            }).done(function(response){
                if(response== "OK")
                {
                    $('#empleadosModal').modal('hide');
                    alert("Empleado Registrado");
                    location.reload();                           
                }
                else
                {
                    alert(response);
                }
        
            });//end ajax done
        });
		
		 $("#btn-empleado-actualizar").click(function(){
            var form = document.getElementById('form_empleado_act');
            var dataForm = new FormData(form);
        
  	  
            $.ajax({          
                url: "<?php echo url_for("@empleados_actualizar"); ?>",
                data:dataForm,
                type: 'POST',       
                contentType: false,
                dataType: "JSON",
                processData: false
            }).done(function(response){
                if(response== "OK")
                {
                    $('#empleadosActModal').modal('hide');
                    alert("Empleado Actualizado");
                    location.reload();                           
                }
                else
                {
                    alert("Error");
                }
        
            });//end ajax done
        });
       
	   
        $("#btn-password").click(function(){
            var form = document.getElementById('form_pass');
            var dataForm = new FormData(form);
        
  	    if($("#pass1").val() == $("#pass2").val()){
            $.ajax({          
                url: "<?php echo url_for("@empleados_password"); ?>",
                data:dataForm,
                type: 'POST',       
                contentType: false,
                dataType: "JSON",
                processData: false
            }).done(function(response){
                if(response== "OK")
                {
                    $('#passwordModal').modal('hide');
                    alert("Registro Actualizado");
                    location.reload();                           
                }
                else
                {
                    alert("Error");
                }
        
            });//end ajax done
			}// end if = password
			 else
			 {
				  alert("Las contrase\u00f1aas no coninciden");
			 }
        });
		
$.toggleShowPassword({
	    field: '#pass1',
	    control: '#password-check'
    });
	$.toggleShowPassword({
	    field: '#pass2',
	    control: '#password-check'
    });
		  });// end ready
		  
		  (function ($) {
    $.toggleShowPassword = function (options) {
        var settings = $.extend({
            field: "#password",
            control: "#toggle_show_password",
        }, options);

        var control = $(settings.control);
        var field = $(settings.field)

        control.bind('click', function () {
            if (control.is(':checked')) {
                field.attr('type', 'text');
            } else {
                field.attr('type', 'password');
            }
        })
    };
}(jQuery));

    
    function editar(id)
    { 
        $.ajax({
            url: "<?php echo url_for("@empleados_detalle"); ?>",
            type: "GET",
            dataType: "JSON",
            data:{ id: id}  
        }).done(function(empleadoList){  
			$('#id1').val(empleadoList.id);		
            $('#nombre1').val( empleadoList.nombre_completo);
            $('#rol1').val(empleadoList.rol);
            $('#usuario1').val(empleadoList.usuario);			
			$('#estatusCuenta').val(empleadoList.estatus); 
			
        });        
        $("#empleadosActModal").modal('show');
    }
	
	 
    function cambiarPassword(id)
    {   
	
        $('#id2').val(id);       
        $("#passwordModal").modal('show');
    }

</script>
