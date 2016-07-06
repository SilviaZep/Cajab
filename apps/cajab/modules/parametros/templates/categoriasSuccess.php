     
<!--Creando modal de generar nueva cita  -->
<!-- Button trigger modal -->
<div  class="panel-body">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#CategoriaModal">  
        <i class="fa fa-user-plus">Nuevo Categoria</i>
    </button>
</div>
<div class="modal fade" id="ActualizarCategoriaModal" tabindex="-1" role="dialog" aria-labelledby="categoriaActualizarLabel" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="categoriaLabel">Actualizar Categoria</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class = "form-horizontal" id = "form_categoria_update">
                        <div class="col-xs-12">
                            <div class="form-group">
							 <input type="hidden" class="form-control"  id="id1" name="id1">
                                <label for="nombre" class="col-xs-4 control-label">Nombre:</label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control"  id="nombre1" name="nombre1" placeholder="Categoria">
                                </div>
                            </div>
                        </div>
                        </br> </br> 							
						<div class="col-xs-12">
                            <div class="form-group">
                                <label for="existencia" class="col-xs-4 control-label">Estatus:</label>
                                <div class="col-xs-8">
                                   <select class="form-control" id="estatus" name="estatus">
								   <option value="1">Activa</option>
								   <option value="0">Baja</option>
								   </select>
                                </div>
                            </div>
                        </div>	
						   </br> </br> 	
						<div class="col-xs-12">
                            <div class="form-group">
                                <label for="existencia" class="col-xs-4 control-label">Tipo:</label>
                                <div class="col-xs-8">
                                   <select class="form-control" id="tipo1" name="tipo1">
								   <option value="1">Activa</option>
								   <option value="0">Baja</option>
								   </select>
                                </div>
                            </div>
                        </div>
						   </br> </br> 	
						<div class="col-xs-12">
                            <div class="form-group">
                                <label for="existencia" class="col-xs-4 control-label">Descripci&oacute;n:</label>
                                <div class="col-xs-8">
                                 <textarea type="text" class="form-control"  id="des1" name="des1" placeholder="Descripci&oacute;n"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>      
                </div>
            </div>
            <div class="modal-footer" id="guardarCategoria">                       
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button> 
                <a id="btn-categoria-actualizar" href="#" class="btn btn-success" role="button">Actualizar</a>                        
            </div>             
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="CategoriaModal" tabindex="-1" role="dialog" aria-labelledby="categoriaLabel" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="categoriaLabel">Nuevo Categoria</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class = "form-horizontal" id = "form_categoria">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="nombre" class="col-xs-4 control-label">Nombre:</label>
                                <div class="col-xs-8">								
                                    <input type="text" class="form-control"  id="nombre" name="nombre" placeholder="Categoria">
                                </div>
                            </div>
                        </div>
                        </br> </br>
						<div class="col-xs-12">
                            <div class="form-group">
                                <label for="existencia" class="col-xs-4 control-label">Tipo:</label>
                                <div class="col-xs-8">
                                   <select class="form-control" id="tipo" name="tipo">
								   <option value="1">Activa</option>
								   <option value="0">Baja</option>
								   </select>
                                </div>
                            </div>
                        </div>
						   </br> </br> 	
						<div class="col-xs-12">
                            <div class="form-group">
                                <label for="existencia" class="col-xs-4 control-label">Descripci&oacute;n:</label>
                                <div class="col-xs-8">
                                 <textarea type="text" class="form-control"  id="des" name="des" placeholder="Descripci&oacute;n"></textarea>
                                </div>
                            </div>
                        </div>						
                    </form>      
                </div>
            </div>
            <div class="modal-footer" id="guardarCategoria">                       
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button> 
                <a id="btn-categoria" href="#" class="btn btn-success" role="button">Guardar</a>                        
            </div>             
        </div>
    </div>
</div>

<div class = "search_container">
    <i class = "fa fa-search search_ic"></i><input id = "categoriasSearch" type = "text" class = "form-control" placeholder = "Search..." />
</div>
<table id = "categoriasTable" class = "display" cellspacing = "0" width = "100%">
    <thead>
        <tr>
            <th class = "col-xs-1"></th>
            <th class = "col-xs-2">Categoria</th>
			<th class = "col-xs-1">Tipo</th>
			<th class = "col-xs-1">Descripci&oacute;n</th>
            <th class = "col-xs-1">Estatus</th>
            <th class = "col-xs-1"></th>

        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;    $tipo_status="";
            foreach ($categorias as $record):
               if($categorias[$i]['estatus']==1)
			   {$tipo_status='<span class="label label-success">Activo</span>';}
				else{
					$tipo_status='<span class="label label-danger">Baja</span>';
				}		   ?> 
                <tr id=" <?php echo $categorias[$i]['id']; ?>">
                    <td><?php echo $categorias[$i]['id']; ?></td>      
                    <td class="col-xs-1"><?php echo $categorias[$i]['categoria']; ?></td>					
					 <td class="col-xs-1"><?php echo $categorias[$i]['tipo']; ?></td>
					 <td class="col-xs-1"><?php echo $categorias[$i]['descripcion']; ?></td>
                    <td class="col-xs-1"><?php echo $tipo_status; ?></td>
					<td class="col-xs-1"><a href = "javascript:editar('<?php echo $categorias[$i]['id'];?>','<?php echo $categorias[$i]['categoria'];?>','<?php echo $categorias[$i]['estatus'];?>','<?php echo $categorias[$i]['tipo'];?>','<?php echo $categorias[$i]['descripcion'];?>')" class = "fa fa-pencil-square-o fa-lg"> </a></td>   
                </tr>             
        <?php $i++;endforeach;?>     

    </tbody>
</table>
</div>

<script>
   
  
    $(document).ready(function(){
        $("#mCategorias").addClass("activeNew");
    
        var categoriasTable = $("#categoriasTable").dataTable({
            sDom: 't<"bottom"p>',
            "pageLength": 8,
            "aoColumns": [ 
                { "sClass": "" },
                { "sClass": "" }, 
			    { "sClass": "" }, 
				{ "sClass": "" }, 
                { "sClass": "" },
                { "sClass": "" }           ],
            "oLanguage": { "sZeroRecords": "No hay registros",
                "oPaginate": { "sPrevious": "<<",
                    "sNext": ">>" } },
            "aoColumnDefs": [ { 'bSortable': false, 
                    'aTargets': [ 2 ] } ]
        }); //end datatable
        $("#categoriasSearch").keyup(function(){
            categoriasTable.api().search($(this).val()).draw();
        });
       
        
        $("#btn-categoria").click(function(){
            var form = document.getElementById('form_categoria');
            var dataForm = new FormData(form);
        
  	  
            $.ajax({          
                url: "<?php echo url_for("@categorias_agregar"); ?>",
                data:dataForm,
                type: 'POST',       
                contentType: false,
                dataType: "JSON",
                processData: false
            }).done(function(response){
                if(response== "OK")
                {
                    $('#CategoriaModal').modal('hide');                    
                    location.reload();                      
                }
                else
                {
                    alert("Error");
                }
        
            });//end ajax done
        });
       
	   
	    $("#btn-categoria-actualizar").click(function(){
            var form = document.getElementById('form_categoria_update');
            var dataForm = new FormData(form);
        
  	  
            $.ajax({          
                url: "<?php echo url_for("@categorias_modificar"); ?>",
                data:dataForm,
                type: 'POST',       
                contentType: false,
                dataType: "JSON",
                processData: false
            }).done(function(response){
                if(response== "OK")
                {
                    $('#ActualizarCategoriaModal').modal('hide');                    
                    location.reload();                      
                }
                else
                {
                    alert("Error");
                }
        
            });//end ajax done
        });
    });
   
    function editar(id,categoria,estatus,tipo,obs)
    {   
		$('#nombre1').val(categoria);
		$('#id1').val(id);
		$('#tipo').val(tipo);
		$('#des1').val(obs);
        
        $("#ActualizarCategoriaModal").modal('show');
    }

</script>
