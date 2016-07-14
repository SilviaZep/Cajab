<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">           
             <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"/>
                <?php include_stylesheets() ?>
                <?php include_javascripts() ?>
                </head>
                <body>

                    <header>
                        <?php if ($sf_user->isAuthenticated()): ?>
                            <div style="text-align: left;line-height:1.5em;color:black; font-size:13px">
                                <div><?php echo date('Y-m-d'); ?></div>
                                <div class="username">Bienvenido(a): <span style="font-weight:bold"><?php echo $sf_user->getNombreCompleto(); ?></span></div>
                                <div style="font-size:15px" class="logout-element">
                                    <a href="<?php echo url_for('@signout'); ?>"title="Click para salir del sistema">Cerrar Sesion</a> 
                                </div>
                            </div>
                        <?php endif; ?>  
                    </header>

                    <nav class="navbar navbar-default" role="navigation">
                        <!-- El logotipo y el icono que despliega el menú se agrupan
                             para mostrarlos mejor en los dispositivos móviles -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                    data-target=".navbar-ex1-collapse">
                                <span class="sr-only">Desplegar navegación</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>    
                        </div>

                        <!-- Agrupar los enlaces de navegación, los formularios y cualquier
                             otro elemento que se pueda ocultar al minimizar la barra -->
                        <div class="collapse navbar-collapse navbar-ex1-collapse">
                            <ul class="nav navbar-nav menuv">      
                                <li class="activeNew"><a href="<?php echo url_for("@homepage"); ?>"><i class="fa fa-list-alt fa-lg">Caja</i></a></li>
                                <li><a href="#<?php //echo url_for("@clientes"); ?>"><i class="fa fa-users fa-lg">Servicios</i></a></li>     
                                <li ><a href="#<?php //echo url_for("@tratamientos"); ?>"><i class="fa fa-th fa-lg">Transprte</i> </a></li>    
                                                           
                            </ul>
                        </div>
                    </nav>
                    <section>  
                        <?php if ($sf_user->isAuthenticated()): ?>
     <!--iframe id="main-frame" style="width:100%;height:100%;border:0px;overflow: hidden;" src="<?php //echo url_for('@homepage');   ?>"></iframe--> 
                            <?php echo $sf_content; ?>
                        <?php endif; ?>  
                    </section>
                    <footer>
                        Copyright Instituto Oriente 2016
                    </footer>
                </body>
                </html>
