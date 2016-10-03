<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>

        <meta name="viewport" content="width=device-width, initial-scale=1"/>  
        <script src="/puntoventa/web/js/angular.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/puntoventa/web/css/font-awesome.css"/>
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
        <style>
            section{
                padding-top: 0px;
                padding-right: 15px;
                padding-bottom: 5px;
                padding-left: 15px;   
            }

        </style>	
    </head>
    <body>
        <header class="container-fluid">		

            <?php if ($sf_user->isAuthenticated()): ?>
                <table>  
                    <tr>
                        <td class="pull-left">
                            <div>				
                            </div>
                        </td>
                        <td>
                            <div class="pull-right" style="text-align: left;line-height:1.5em;color:black; font-size:13px">
                                <div><?php //echo date('Y-m-d');  ?></div>
                                <div class="username">Bienvenido(a): <span style="font-weight:bold"><?php echo $sf_user->getNombreCompleto(); ?></span></div>								
                                <div style="font-size:15px" class="logout-element">
                                    <a href="<?php echo url_for('@signout'); ?>"title="Click para salir del sistema">Cerrar Sesion</a> 					
                                    </br>
                                    <a href="#"title="Click para cambiar contrase&ntilde;a" data-toggle="modal" data-target="#passwordModal">Cambiar contrase&ntilde;a</a> 
                                </div>					
                            </div>
                        </td>
                    </tr>
                </table>
            <?php endif; ?>  
        </header>
        <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordLabel">
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
                                            <input type="hidden" class="form-control"  id="id2" name="id2" value="<?php echo $sf_user->getUserId(); ?>">
                                                <input type="password" class="form-control" id="pass1" name="pass1" placeholder="Contrase&ntilde;a">
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="precioCompra" class="col-xs-4 control-label">Repite la Contrase&ntilde;a:</label>
                                                        <div class="col-xs-8">								    
                                                            <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Contrase&ntilde;a">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input id="password-check" type="checkbox"> Mostrar contrase&ntilde;a
                                                            </label>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    </br></br>
                                                    </form>      
                                                    </div>
                                                    </div>
                                                    <div class="modal-footer" id="guardarPasword">                       
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button> 
                                                        <a id="btn-password" href="#" class="btn btn-success" role="button">Actualizar</a>                        
                                                    </div>             
                                                    </div>
                                                    </div>
                                                    </div>

                                                    <div class="col-xs-12">
                                                        <nav class="navbar navbar-custom navbar-static-top">
                                                            <div class="navbar-header">
                                                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                                                    <span class="sr-only">Toggle navigation</span>
                                                                    <span class="icon-bar"></span>
                                                                    <span class="icon-bar"></span>
                                                                    <span class="icon-bar"></span>
                                                                </button>

                                                            </div>
                                                            <div class="collapse navbar-collapse">
                                                                <ul class="nav navbar-nav">
                                                                    <?php if ($sf_user->getRol() == 1): ?>

                                                                        <li id="mConfiguracion" class="dropdown">
                                                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                                                <i class="fa fa-wrench"> Configuraci&oacute;n</i>
                                                                                <b class="caret"></b>
                                                                            </a>
                                                                            <ul class="dropdown-menu">
                                                                                <li id="mConceptos"><a href="<?php echo url_for("@filtros_alumnos"); ?>"><i class="fa fa-cogs"> Consultas</i></a></li>
                                                                                <li id="mConceptos"><a href="<?php echo url_for("@conceptos-list"); ?>"><i class="fa fa-cogs"> Conceptos de pago</i></a></li>    
                                                                                <li id="mCategorias"><a href="<?php echo url_for("@categorias-list"); ?>"><i class="fa fa-cogs"> Categorias</i></a></li>   
                                                                                <li id="mClientes"><a href="<?php echo url_for("@clientes_externos"); ?>"><i class="fa fa-users"> Clientes Externos</i></a></li>  
                                                                                <li id="mProveedor"><a href="<?php echo url_for("@proveedores_list"); ?>"><i class="fa fa-user"> Proveedores</i></a></li>
                                                                                <li id="mSeguridad"><a href="<?php echo url_for("@empleados_lista"); ?>"><i class="fa fa-unlock-alt"> Seguridad</i></a></li>								                                      

                                                                            </ul>
                                                                        </li>

                                                                        <li id="mConfiguracion" class="dropdown">
                                                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                                                <i class="fa fa-server"> Servicio</i>
                                                                                <b class="caret"></b>
                                                                            </a>
                                                                            <ul class="dropdown-menu">
                                                                                <li><a href="<?php echo url_for("@servicios"); ?>"> <i class="fa fa-list"> Lista de Servicios</i> </a></li> 
                                                                                <li><a href="<?php echo url_for("@servicios_asignar_servicios"); ?>"><i class="fa fa-th" aria-hidden="true"> Asignacion de Servicios</i></a></li>                                                                                
                                                                            </ul>
                                                                        </li>
                                                                        <li id="mConfiguracion" class="dropdown">
                                                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                                                <i class="fa fa-cart-arrow-down"> Caja</i>
                                                                                <b class="caret"></b>
                                                                            </a>
                                                                            <ul class="dropdown-menu">
                                                                                <li><a href="<?php echo url_for("@pagos_pagar_servicio"); ?>"> <i class="fa fa-usd" aria-hidden="true"> Pagar Servicio Alumno</i></a></li> 
                                                                                <li><a href="<?php echo url_for("@pagos_pagar_servicio_cliente"); ?>"> <i class="fa fa-usd" aria-hidden="true"> Pagar Servicio Cliente</i></a></li>
                                                                                <!--<li><a href="<?php echo url_for("@transporte_listas_rutas"); ?>"> <i class="fa fa-list"> EstadoCuentaAlumno</i> </a></li>                                                      -->
                                                                                <li id="mClientes"><a href="<?php echo url_for("@egresos_list"); ?>"><i class="fa fa-users"> Registro de Egresos</i></a></li>    

                                                                            </ul>
                                                                        </li>
                                                                        <li id="mConfiguracion" class="dropdown">
                                                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                                                <i class="fa fa-bus"> Transporte</i>
                                                                                <b class="caret"></b>
                                                                            </a>
                                                                            <ul class="dropdown-menu">
                                                                                <li><a href="<?php echo url_for("@transporte_listas_rutas"); ?>"> <i class="fa fa-list"> Listas por Ruta</i> </a></li> 
                                                                                <li><a href="<?php echo url_for("@transporte_horarios"); ?>"><i class="fa fa-table"> Horarios</i> </a></li>
                                                                                <li><a href="<?php echo url_for("@transporte_rutas"); ?>"><i class="fa fa-bus"> Rutas</i> </a></li>

                                                                            </ul>
                                                                        </li>
                                                                        <li id="mConfiguracion" class="dropdown">
                                                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                                                <i class="fa fa-book"> Reportes</i>
                                                                                <b class="caret"></b>
                                                                            </a>
                                                                            <ul class="dropdown-menu">
                                                                                <li id="mEcAlumno"><a href="<?php echo url_for("@estado_cuenta_servicios_estatus"); ?>"><i class="fa fa-bars" aria-hidden="true"> Estado de cuenta por servicio</i></a></li>  
                                                                                <li id="mEcServicio"><a href="<?php echo url_for("@estado_cuenta_servicios_dias_mora"); ?>"><i class="fa fa-newspaper-o" aria-hidden="true"> Reporte faltantes de pago (dias de mora)</i></a></li>  		  
                                                                                <li id="mEcServicio"><a href="<?php echo url_for("@estado_cuenta_servicios_activos_alumnos"); ?>"><i class="fa fa-bookmark-o" aria-hidden="true"> Reporte Alumnos con servicios vigentes</i></a></li>  		  

                                                                            </ul>
                                                                        </li>

                                                                    <?php endif; ?>

                                                                    <?php if ($sf_user->getRol() == 2): ?>

                                                                        <li id="mHome"><a onclick="" href="<?php echo url_for("@homepage"); ?>"><i class="fa fa-list-alt"> Agenda</i></a></li>                            						     
                                                                        <li id="mCaja"><a href="<?php echo url_for("@homepage"); ?>"><i class="fa fa-money">Punto de venta</i></a></li> 

                                                                    <?php endif; ?>
                                                                    <?php if ($sf_user->getRol() == 3): ?>
                                                                        <li id="mHome"><a onclick="" href="<?php echo url_for("@homepage"); ?>"><i class="fa fa-list-alt"> Transporte</i></a></li>
                                                                        <?php endif; ?>
                                                                </ul>
                                                            </div><!-- /.navbar-collapse -->
                                                        </nav>
                                                    </div>

                                                    <section>  
                                                        <?php if ($sf_user->isAuthenticated()): ?>
                                                    <!--iframe id="main-frame" style="width:100%;height:100%;border:0px;overflow: hidden;" src="<?php //echo url_for('@homepage');      ?>"></iframe--> 
                                                            <?php echo $sf_content; ?>
                                                        <?php endif; ?>  
                                                    </section>
                                                    </div>
                                                    <footer>
                                                        Copyright SkinDepile 2016
                                                    </footer>

                                                    <script>
                                                        $(document).ready(function () {
                                                            $("#btn-password").click(function () {

                                                                var form = document.getElementById('form_pass');
                                                                var dataForm = new FormData(form);
                                                                if ($("#pass1").val() == $("#pass2").val()) {

                                                                    $.ajax({
                                                                        url: "#",
                                                                        data: dataForm,
                                                                        type: 'POST',
                                                                        contentType: false,
                                                                        dataType: "JSON",
                                                                        processData: false
                                                                    }).done(function (response) {
                                                                        if (response == "OK")
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
                                                        });

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

                                                    </script>
                                                    </body>
                                                    </html>
