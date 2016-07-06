<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Instituto Oriente</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"/>
            <?php include_stylesheets() ?>
            <?php include_javascripts() ?>
  </head>
  <body>
 

    
       <!--end optional-->
    
    <div class="main-cont">
      <div class="velo"></div>
      <nav class="navbar-azul">
       <div class="container-fluid">
	   <div class="pull-right">
        <a href="" class="visible-xs js-team-btn">
            <span class="fa fa-users"></span>
        </a>
		 <div><?php echo date('Y-m-d'); ?></div>    
        <a href="<?php echo url_for('@signout'); ?>">
            <span class="fa fa-cog" style="text-align: center" title="Click para salir del sistema"><div class="name" style="font-size: 10px;">Cerrar Sesion</div></span>
        </a>
       
    </div>  

	   </div>
      </nav><!--end navbar-azul-->
      <nav id="menu">
        <div class="text-center">
		<?php echo image_tag('logo_instituto.png')?>
	   </div>
	   <div class="text-center user-tag">
	  <p>Bienvenido <span><strong><?php echo $sf_user->getNombreCompleto(); ?></strong></span></span></p>
     </div>
   <ul class="nav navbar-nav menuv">      
	<li class="activeNew"><a href="<?php echo url_for("@homepage"); ?>"><i class="fa fa-list-alt fa-lg">Caja</i></a></li>
	<li><a href="#<?php //echo url_for("@clientes"); ?>"><i class="fa fa-users fa-lg">Servicios</i></a></li>     
	<li ><a href="#<?php //echo url_for("@tratamientos"); ?>"><i class="fa fa-th fa-lg">Transprte</i> </a></li>    
							   
   </ul>      
<div class="text-center">
 Copyright Instituto Oriente 2016
</div>                         
<!--end text-center user-tag-->
  
      </nav><!--end menu-->
      <div class="container-fluid">
        <?php if ($sf_user->isAuthenticated()): ?>
     <!--iframe id="main-frame" style="width:100%;height:100%;border:0px;overflow: hidden;" src="<?php //echo url_for('@homepage');   ?>"></iframe--> 
                            <?php echo $sf_content; ?>
         <?php endif; ?> 
      </div><!--end container-fluid-->
    </div><!--end main-cont-->


  </body>
</html>
<script>
 
</script>  