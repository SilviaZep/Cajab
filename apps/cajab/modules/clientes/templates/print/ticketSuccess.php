<div class="center-container w800">
<?php echo image_tag('Top1.gif','height="100px"')?>
</br></br></br>
Orden de Servicio # <?php echo $orden; ?>
</br></br>
<div style="width:100%">
<table id = "sesionesTable" class = "display reporte" cellspacing = "0" width = "100%">
    <thead>
        <tr>
            <th class = "col-xs-1"></th>
            <th class = "col-xs-1">Servicio</th>
			<th class = "col-xs-1">EStatus Servicio</th> 
            <th class = "col-xs-1">Estatud Pago</th> 
            <th class = "col-xs-1">Precio</th>

        </tr>
    </thead>
    <tbody>
<?php if ($servicios->count() > 0):		
            foreach ($servicios as $record):?> 
                <tr id=" <?php echo $record['id']; ?>">
                    <td><?php echo $record['id']; ?></td>      
                    <td class="col-xs-1"><?php echo $record['nombre_tratamiento']; ?></td>
					<td class="col-xs-1"><?php echo $record['estatus_s']; ?></td>
                    <td class="col-xs-1"><?php echo $record['estatus_p']; ?></td>
                    <td class="col-xs-1"><?php echo $record['precio']; ?></td>                   
					  
					</tr>             
        <?php endforeach; endif;?>     

    </tbody>
</table>
</div>

<footer>
</br>
<p style="text-align:right"><?php echo $unidadNegocio->getNombre(); ?>
</br>
<?php echo $unidadNegocio->getDireccion(); ?></p>
</footer>

</div>