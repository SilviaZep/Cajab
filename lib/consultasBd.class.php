<?php
/*
Clase para hacer consultas a la bd
*/

class consultasBd
{
  
    public static function getClientesExternosList() {
   $conn = Doctrine_Manager::getInstance()->getConnection("default");               
        $sql = "SELECT *
          FROM clientes_externos";        
    $sql = sprintf($sql);  
    $st = $conn->execute($sql);  
    return $st->fetchAll(PDO::FETCH_ASSOC);    
  }  
  
   public static function getProveedoresList() {
   $conn = Doctrine_Manager::getInstance()->getConnection("default");               
        $sql = "SELECT *
          FROM proveedores";        
    $sql = sprintf($sql);  
    $st = $conn->execute($sql);  
    return $st->fetchAll(PDO::FETCH_ASSOC);    
  }  
  
  public static function getEgresossList() {
   $conn = Doctrine_Manager::getInstance()->getConnection("default");               
        $sql = "SELECT e.*,p.nombre as proveedor, cc.concepto, s.nombre as servicio
		FROM
		egresos e
		JOIN servicio s ON (s.id = e.id_servicio)
		JOIN proveedores p ON (p.id= e.id_proveedor)
		JOIN conceptos_cobro cc ON (cc.id=e.id_concepto)
		ORDER BY s.fecha_registro DESC";        
    $sql = sprintf($sql);  
    $st = $conn->execute($sql);  
    return $st->fetchAll(PDO::FETCH_ASSOC);    
  }  
  
  /*  public static function getListadoServicios() {
		 $valor="Silvia";
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
      
        $sql = "select * from servicio 
                where activo=1
                and fecha_evento >='2016-05-08'
                and fecha_evento <='2016-05-08'
                and nombre like '%" . $valor . "%'
                limit 1;";
		// echo $sql; die();         
    $st = $conn->execute($sql);  
    return $st->fetchAll(PDO::FETCH_ASSOC);  
    }*/
  
 public static function getServiciosList() {
   $conn = Doctrine_Manager::getInstance()->getConnection("default");               
        $sql = "SELECT *
          FROM servicio";        
    $sql = sprintf($sql);  
    $st = $conn->execute($sql);  
    return $st->fetchAll(PDO::FETCH_ASSOC);    
  }  
 
  public static function getConceptoPagoList($id) {
   $conn = Doctrine_Manager::getInstance()->getConnection("default");               
        $sql = "SELECT *
          FROM conceptos_cobro 
		  WHERE id_servicio=%d";        
    $sql = sprintf($sql,$id);  
    $st = $conn->execute($sql);  
    return $st->fetchAll(PDO::FETCH_ASSOC);    
  }  
   public static function getUsuarios() {
   $conn = Doctrine_Manager::getInstance()->getConnection("default");               
        $sql = "SELECT *
          FROM usuario ORDER by nombre_completo ASC";        
    $sql = sprintf($sql);  
    $st = $conn->execute($sql);  
    return $st->fetchAll(PDO::FETCH_ASSOC);    
  } 
public static function getConceptoList() {
   $conn = Doctrine_Manager::getInstance()->getConnection("default");               
        $sql = "SELECT cc.*,s.nombre as servicio
          FROM conceptos_cobro  cc
		  JOIN servicio s ON (s.id = cc.id_servicio)
		  ORDER BY s.nombre";  
      $sql = sprintf($sql); 		  
     $st = $conn->execute($sql);  
    return $st->fetchAll(PDO::FETCH_ASSOC);    
  }    
 public static function getCategoriasList() {

        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "SELECT * FROM categoria_servicio ORDER BY categoria";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
//--------------Consultas Coronel----------------

    public static function getListadoServicios($fechaIni, $fechaFin, $lim, $off, $nombreServicio, $categoria) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $filtroCategoria = "and categoria_id={$categoria}";
        if ($categoria == 0) {
            $filtroCategoria = "";
        }

        $sql = "select *,
      case aplica_parcialidad when 1 then 'SI' when 0 then 'NO' end as apl_par , 
      case pago_obligatorio when 1 then 'SI' when 0 then 'NO' end as pag_obl,  
      case tipo_cliente when 1 then 'Alumnos' when 2 then 'Clientes Ext' when 3 then 'Mixto' end as tip_cli, 
      date(fecha_inicio) as fec_ini,
      date(fecha_fin) as fec_fin,
      ifnull((select categoria from categoria_servicio where id=s.categoria_id),'NA') as categoria,
      ifnull((select nombre from servicio where id=s.id_servicio),'') as servicio_padre
      from servicio s
      where s.activo=1
      and s.fecha_evento >='{$fechaIni}'
      and s.fecha_evento <='{$fechaFin}'
      and s.nombre like '%{$nombreServicio}%'
      {$filtroCategoria}
      limit {$lim} offset {$off};";
        //  $rsql = sprintf($sql);
        //echo $sql;
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTotalListadoServicios($fechaIni, $fechaFin, $nombreServicio, $categoria) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $filtroCategoria = "and categoria_id={$categoria}";
        if ($categoria == 0) {
            $filtroCategoria = "";
        }
        $sql = "select count(*) as total from servicio 
                where activo=1
                and fecha_evento >='{$fechaIni}'
                and fecha_evento <='{$fechaFin}'
                and nombre like '%{$nombreServicio}%'
                {$filtroCategoria} ;";
        //  $rsql = sprintf($sql);
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getListadoServiciosVigentes($lim, $off, $nombreServicio, $categoria) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $filtroCategoria = "and categoria_id={$categoria}";
        if ($categoria == 0) {
            $filtroCategoria = "";
        }
        $sql = "select *,
      case aplica_parcialidad when 1 then 'SI' when 0 then 'NO' end as apl_par , 
      case pago_obligatorio when 1 then 'SI' when 0 then 'NO' end as pag_obl,  
      case tipo_cliente when 1 then 'Alumnos' when 2 then 'Clientes Ext' when 3 then 'Mixto' end as tip_cli, 
      date(fecha_inicio) as fec_ini,
      date(fecha_fin) as fec_fin,
      ifnull((select categoria from categoria_servicio where id=s.categoria_id),'NA') as categoria
      from servicio s
      where s.activo=1
      and s.fecha_inicio<=date(now())
      and date(now())<=s.fecha_fin
      and s.nombre like '%{$nombreServicio}%'
      {$filtroCategoria}
      limit {$lim} offset {$off};";
        ;
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTotalListadoServiciosVigentes($nombreServicio, $categoria) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $filtroCategoria = "and categoria_id={$categoria}";
        if ($categoria == 0) {
            $filtroCategoria = "";
        }
        $sql = "select count(*) as total from servicio 
                where activo=1
                and fecha_inicio<=date(now())
                and date(now())<=fecha_fin
                and nombre like '%{$nombreServicio}%'
                {$filtroCategoria}
                ;";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getListadoRutas($lim, $off, $nombreRuta) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");

        $sql = "select 
                * from ruta 
                where estatus=1
                and nombre like '%{$nombreRuta}%'
                limit {$lim}  offset {$off};";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTotalListadoRutas($nombreRuta) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "select 
                count(*) as total from ruta 
                where estatus=1
                and nombre like '%{$nombreRuta}%';";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    //----------------------------Listado Rutas que pudieron haber sido eliminadas

    public static function getListadoRutasAntiguas($fecha, $nombreRuta) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");

        $sql = "select * from (
                select r.*,
                (select count(*) as tot_alum_ruta from lista_ruta 
                where fecha='{$fecha}' 
                and id_ruta=r.id
                and estatus=1) as tot_alum_ruta
                from ruta r) t
                where tot_alum_ruta>0;";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTotalListadoRutasAntiguas($fecha, $nombreRuta) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "select count(*) as total from (
                select r.*,
                (select count(*) as tot_alum_ruta from lista_ruta 
                where fecha='{$fecha}' 
                and id_ruta=r.id
                and estatus=1) as tot_alum_ruta
                from ruta r) t
                where tot_alum_ruta>0;";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    //--------------------------------------------------------------------------


    public static function getListadoCategoriasServicios() {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "select * from categoria_servicio
                where estatus=1;";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    //listad Alumnos 
    public static function getListadoAlumnos($lim, $off, $nombreAlumno, $idServicio, $flagVenta, $idPapa) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $filtroVenta = "and id not in(
                    select distinct(id_alumno) 
                    from servicio_cliente 
                    where id_servicio={$idServicio} and tipo_cliente=1)";
        $filtroPapa = "and id in(
                    select distinct(id_alumno) 
                    from servicio_cliente 
                    where id_servicio={$idPapa} and tipo_cliente=1)";
        if ($flagVenta) {//si es tipo venta no se agrega el filtro porque se pueden agregar cuantas veces sea necesario
            $filtroVenta = "";
        }
        if ($idPapa == 0) {//si es tipo venta no se agrega el filtro porque se pueden agregar cuantas veces sea necesario
            $filtroPapa = "";
        }
        $sql = "select * 
                from alumno_pruebas
                where nombre like '%{$nombreAlumno}%'
                {$filtroVenta}
                {$filtroPapa}
                limit {$lim} offset {$off};";

        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTotalListadoAlumnos($nombreAlumno, $idServicio, $flagVenta, $idPapa) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $filtroVenta = "and id not in(
                    select distinct(id_alumno) 
                    from servicio_cliente 
                    where id_servicio={$idServicio} and tipo_cliente=1)";
        $filtroPapa = "and id in(
                    select distinct(id_alumno) 
                    from servicio_cliente 
                    where id_servicio={$idPapa} and tipo_cliente=1)";
        if ($flagVenta) {//si es tipo venta no se agrega el filtro porque se pueden agregar cuantas veces sea necesario
            $filtroVenta = "";
        }
        if ($idPapa == 0) {//si es tipo venta no se agrega el filtro porque se pueden agregar cuantas veces sea necesario
            $filtroPapa = "";
        }
        $sql = "select count(*) as total
                from alumno_pruebas
                where nombre like '%{$nombreAlumno}%' 
                {$filtroVenta}
                {$filtroPapa};";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    //***fin listado Alumnos
//Lista Clientes
    public static function getListadoClientesExternos($lim, $off, $nombreCliente, $idServicio, $flagVenta, $idPapa) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $filtroVenta = "and id not in(
                    select distinct(id_cliente) 
                    from servicio_cliente 
                    where id_servicio={$idServicio} and tipo_cliente=2)";
        $filtroPapa = "and id in(
                    select distinct(id_cliente) 
                    from servicio_cliente 
                    where id_servicio={$idPapa} and tipo_cliente=2)";
        if ($flagVenta) {//si es tipo venta no se agrega el filtro porque se pueden agregar cuantas veces sea necesario
            $filtroVenta = "";
        }
        if ($idPapa == 0) {//si es tipo venta no se agrega el filtro porque se pueden agregar cuantas veces sea necesario
            $filtroPapa = "";
        }
        $sql = "select * 
                from clientes_externos
                where nombre like '%{$nombreCliente}%'
                {$filtroVenta}
                {$filtroPapa}
                limit {$lim} offset {$off};";

        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTotalListadoClientesExternos($nombreCliente, $idServicio, $flagVenta, $idPapa) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $filtroVenta = "and id not in(
                    select distinct(id_cliente) 
                    from servicio_cliente 
                    where id_servicio={$idServicio} and tipo_cliente=2)";
        $filtroPapa = "and id in(
                    select distinct(id_cliente) 
                    from servicio_cliente 
                    where id_servicio={$idPapa} and tipo_cliente=2)";
        if ($flagVenta) {//si es tipo venta no se agrega el filtro porque se pueden agregar cuantas veces sea necesario
            $filtroVenta = "";
        }
        if ($idPapa == 0) {//si es tipo venta no se agrega el filtro porque se pueden agregar cuantas veces sea necesario
            $filtroPapa = "";
        }
        $sql = "select count(*) as total
                from clientes_externos
                where nombre like '%{$nombreCliente}%'
                {$filtroVenta}
                {$filtroPapa}
                ;";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    //---------
    public static function getListaAsignadosServicio($idServicio, $nombreCliente, $limit, $offset) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "select * from (select sc.id,sc.estatus,sc.id_servicio,sc.id_alumno,sc.id_cliente,
                CASE sc.tipo_cliente
                      WHEN 1 THEN ifnull((select nombre from alumno_pruebas where id=sc.id_alumno),'na')
                      WHEN 2 THEN ifnull((select nombre from clientes_externos where id=sc.id_cliente),'na')
                      ELSE  'na' END as cliente,
                CASE sc.tipo_cliente
                      WHEN 1 THEN 'Alumno'
                      WHEN 2 THEN 'Cliente Externo'
                      ELSE  'na' END as tipo_descripcion,
                CASE sc.estatus
                      WHEN 1 THEN 'Activo'
                      WHEN 2 THEN 'Pagado'
                          WHEN 3 THEN 'Cancelado'
                          WHEN 4 THEN 'Condonado'
                      ELSE  'na' END as estatus_descripcion,
                s.nombre as nombre_servicio
                from servicio_cliente sc,servicio s
                where sc.id_servicio=s.id) t
                where id_servicio={$idServicio}
                and cliente like '%{$nombreCliente}%'                  
                order by tipo_descripcion,cliente
                limit {$limit} offset {$offset};";

        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTotalListaAsignadosServicio($idServicio, $nombreCliente) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "select count(*) as total from (select sc.id_servicio,sc.id_alumno,sc.id_cliente,            
                CASE sc.tipo_cliente
                      WHEN 1 THEN ifnull((select nombre from alumno_pruebas where id=sc.id_alumno),'na')
                      WHEN 2 THEN ifnull((select nombre from clientes_externos where id=sc.id_cliente),'na')
                      ELSE  'na' END as cliente,
                CASE sc.tipo_cliente
                      WHEN 1 THEN 'Alumno'
                      WHEN 2 THEN 'Cliente Externo'
                      ELSE  'na' END as tipo_descripcion,
                CASE sc.estatus
                      WHEN 1 THEN 'Activo'
                      WHEN 2 THEN 'Pagado'
                          WHEN 3 THEN 'Cancelado'
                          WHEN 4 THEN 'Condonado'
                      ELSE  'na' END as estatus_descripcion,
                s.nombre as nombre_servicio
                from servicio_cliente sc,servicio s
                where sc.id_servicio=s.id) t
                where id_servicio={$idServicio}
                and cliente like '%{$nombreCliente}%'                  
                order by tipo_descripcion,cliente;";

        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    //---------clonar servicio
    public static function getClonarServicio($idServicioa, $idServiciob, $idUsuario) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "call sp_clonar_servicio({$idServicioa},{$idServiciob},{$idUsuario});";
        $conn->execute($sql);
        return true;
    }

    //_--------------------------------HORARIOS

    public static function getHorariosAlumnos($limit, $offset, $nombre) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "select a.nombre,a.grado,a.grupo,hr.*,
ifnull((select r.nombre from ruta r where id=hr.r_lun_e),'No Asig.') as r_lun_e_nombre,
ifnull((select r.nombre from ruta r where id=hr.r_lun_s),'No Asig.') as r_lun_s_nombre,
ifnull((select r.nombre from ruta r where id=hr.r_mar_e),'No Asig.') as r_mar_e_nombre,
ifnull((select r.nombre from ruta r where id=hr.r_mar_s),'No Asig.') as r_mar_s_nombre,
ifnull((select r.nombre from ruta r where id=hr.r_mie_e),'No Asig.') as r_mie_e_nombre,
ifnull((select r.nombre from ruta r where id=hr.r_mie_s),'No Asig.') as r_mie_s_nombre,
ifnull((select r.nombre from ruta r where id=hr.r_jue_e),'No Asig.') as r_jue_e_nombre,
ifnull((select r.nombre from ruta r where id=hr.r_jue_s),'No Asig.') as r_jue_s_nombre,
ifnull((select r.nombre from ruta r where id=hr.r_vie_e),'No Asig.') as r_vie_e_nombre,
ifnull((select r.nombre from ruta r where id=hr.r_vie_s),'No Asig.') as r_vie_s_nombre,
(case hr.tipo when 1 then 'Completo' when 2 then 'Medio' else 'NA' end ) as tipo_transporte
                from horario_ruta hr, alumno_pruebas a
                where hr.id_alumno=a.id
                and a.nombre like '%{$nombre}%'
                limit {$limit} offset {$offset};";

        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTotalHorariosAlumnos($nombre) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "select count(*) as total
                from horario_ruta hr, alumno_pruebas a
                where hr.id_alumno=a.id
                and a.nombre like '%{$nombre}%' ;";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    //-----------------------Rutas.................

    public static function getDiaSemana($fecha) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "SELECT WEEKDAY('{$fecha}') as dia;";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getListasInscritosDiaRuta($fecha, $dia, $ruta) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $flagQ = 0;
        date_default_timezone_set('America/Mexico_City');
        $fechaActual = new DateTime();
        $fechaActual = $fechaActual->format('Y-m-d');
        if ($fechaActual < $fecha) {//dias futuros
            $flagQ = 1;
        }
        if ($fechaActual == $fecha) {//dia de hoy
            $qC = "select count(*) as total
                    from lista_ruta lr,alumno_pruebas a
                    where lr.id_alumno=a.id 
                    and lr.fecha='{$fecha}'
                    and lr.estatus=1 and lr.tipo in(1,2)
                    and lr.id_ruta={$ruta};";
            $rC = $conn->execute($qC);
            $rC = $rC->fetchAll(PDO::FETCH_ASSOC);
            if ($rC[0]['total'] > 0) {//Si hay registros
                $flagQ = 2;
            } else {
                $flagQ = 1;
            }
        }
        if ($fechaActual > $fecha) {//dias anteriores
            $flagQ = 2;
        }


        if ($flagQ == 1) {//Calculados
            $sql = "select * from (
                    select a.nombre,sc.id as id_ref,0 as guardado,
                    (case hr.tipo when 1 then 'Completo' when 2 then 'Medio' else 'NA' end ) as tipo_transporte
                    from servicio_cliente sc,servicio s,horario_ruta hr,alumno_pruebas a
                    where sc.id_servicio=s.id
                    and sc.id_alumno=hr.id_alumno
                    and sc.id_alumno=a.id
                    and s.fecha_inicio<='{$fecha}'
                    and s.fecha_fin>='{$fecha}'
                    and s.tipo_transporte in (1,2)
                    and s.activo=1
                    and (hr.r_{$dia}_e={$ruta} or hr.r_{$dia}_s={$ruta})
                    union 
                    select a.nombre,lr.id as id_ref,0 as guardado,
                    (case lr.tipo when 1 then 'Completo' when 2 then 'Medio' when 3 then 'Eventual' else 'NA' end ) as tipo_transporte 
                    from lista_ruta lr,alumno_pruebas a
                    where lr.id_alumno=a.id
                    and lr.fecha='{$fecha}'
                    and lr.id_ruta={$ruta}
                    )t
                    order by nombre;";
        }
        if ($flagQ == 2) {//guardados
            $sql = "select a.nombre,0 as id_ref,1 as guardado, 
                    (case lr.tipo when 1 then 'Completo' when 2 then 'Medio' when 3 then 'Eventual' else 'NA' end ) as tipo_transporte
                    from lista_ruta lr,alumno_pruebas a
                    where lr.id_alumno=a.id 
                    and fecha='{$fecha}'
                    and estatus=1 
                    and id_ruta={$ruta};";
        }

        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTotalListasInscritosDiaRuta($fecha, $dia, $ruta) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $flagQ = 0;
        date_default_timezone_set('America/Mexico_City');
        $fechaActual = new DateTime();
        $fechaActual = $fechaActual->format('Y-m-d');
        if ($fechaActual < $fecha) {//dias futuros
            $flagQ = 1;
        }
        if ($fechaActual == $fecha) {//dia de hoy
            $qC = "select count(*) as total
                    from lista_ruta lr,alumno_pruebas a
                    where lr.id_alumno=a.id 
                    and lr.fecha='{$fecha}'
                    and lr.estatus=1 and lr.tipo in(1,2)
                    and lr.id_ruta={$ruta};";
            $rC = $conn->execute($qC);
            $rC = $rC->fetchAll(PDO::FETCH_ASSOC);
            if ($rC[0]['total'] > 0) {//Si hay registros
                $flagQ = 2;
            } else {
                $flagQ = 1;
            }
        }
        if ($fechaActual > $fecha) {//dias anteriores
            $flagQ = 2;
        }


        if ($flagQ == 1) {//Calculados
            $sql = "select count(*) as total from (
                    select a.nombre,sc.id as id_ref,
                    (case hr.tipo when 1 then 'Completo' when 2 then 'Medio' else 'NA' end ) as tipo_transporte
                    from servicio_cliente sc,servicio s,horario_ruta hr,alumno_pruebas a
                    where sc.id_servicio=s.id
                    and sc.id_alumno=hr.id_alumno
                    and sc.id_alumno=a.id
                    and s.fecha_inicio<='{$fecha}'
                    and s.fecha_fin>='{$fecha}'
                    and s.tipo_transporte in (1,2)
                    and s.activo=1
                    and (hr.r_{$dia}_e={$ruta} or hr.r_{$dia}_s={$ruta})
                    union 
                    select a.nombre,lr.id as id_ref,
                    (case lr.tipo when 1 then 'Completo' when 2 then 'Medio' when 3 then 'Eventual' else 'NA' end ) as tipo_transporte 
                    from lista_ruta lr,alumno_pruebas a
                    where lr.id_alumno=a.id
                    and lr.fecha='{$fecha}'
                    and lr.id_ruta={$ruta}
                    )t
                    order by nombre;";
        }
        if ($flagQ == 2) {//guardados
            $sql = "select count(*) as total
                    from lista_ruta lr,alumno_pruebas a
                    where lr.id_alumno=a.id 
                    and fecha='{$fecha}'
                    and estatus=1 
                    and id_ruta={$ruta};";
        }

        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    //--------------Fin consultas Coronel-----------------

    public static function getGuardarListasPorRuta($fecha, $idRuta) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = " call sp_guardar_listas_por_ruta('{$fecha}',{$idRuta});";
        $conn->execute($sql);
        return true;
    }

    public static function getVerificarGuardado($fecha) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "select count(*) as total
                from lista_ruta lr,alumno_pruebas a
                where lr.id_alumno=a.id 
                and lr.fecha='{$fecha}'
                and lr.estatus=1 and lr.tipo in(1,2);";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    
     public static function getGenerarHorariosActivos() {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
          date_default_timezone_set('America/Mexico_City');
        $fechaActual = new DateTime();
        $fechaActual = $fechaActual->format('Y-m-d');
        $sql = " call sp_generar_horarios_transporte_activo('{$fechaActual}');";
        $conn->execute($sql);
        return true;
    }
//Queryrs insituto	
	 public static function getAlumnosInstituto() {
        $conn = Doctrine_Manager::getInstance()->getConnection("instituto");
        $sql = "select nombre,seccion as total
                from ListaAlumnoB";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
       
    }
    public static function getListaAlumnosFiltros($idCiclo, $idGrado, $idgrupo){
    	$conn = Doctrine_Manager::getInstance()->getConnection("instituto");
    	
    	$conn = Doctrine_Manager::getInstance()->getConnection("default");
    	$campos = "select idAlumno,nombre,seccion";
    		
    	$condicion = " WHERE alumnoActivo=1 AND";
    	
    	if(isset($idCiclo) && !empty($idCiclo))
    	{
    		$condicion= $condicion.= " AND os.id_cliente ='".$idCiclo."'";
    	}
    	
    	if(isset($idGrado) && !empty($idGrado))
    	{
    		$condicion= $condicion.= " AND sos.idGrado ='".$idGrado."'";
    	}
    	if(isset($idgrupo) && !empty($idgrupo))
    	{
    		$condicion= $condicion.= " AND sos.idgrupo ='".$idgrupo."'";
    	}
    	
    	$conn = Doctrine_Manager::getInstance()->getConnection("instituto"); //nombre de mi conexion
    	$sql = $campos. " FROM from ListaAlumnoB".$condicion."
          ORDER BY idAlumno ASC;";
    	// ECHO $sql; die();
    	$st = $conn->execute($sql);
    	
    	return $st->fetchAll(PDO::FETCH_ASSOC);    	 
    }
    
    public static function getSecciones($cicloEscolar){
    	$conn = Doctrine_Manager::getInstance()->getConnection("instituto");
    	$sql = "select idseccion ,seccion
                from ListaCicloEscolar WHERE idcicloescolar=".$cicloEscolar;
    	$st = $conn->execute($sql);
    	return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getGradosByCiclo($cicloEscolar){
    	$conn = Doctrine_Manager::getInstance()->getConnection("instituto");
    	$sql = "select DISTINCT idgrado ,grado
                from ListaGrupo WHERE idseccion=".$seccion." AND idcicloescolar=".$cicloEscolar;
    	$st = $conn->execute($sql);
    	return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function getGruposByGrado($grado,$cicloEscolar){
    	$conn = Doctrine_Manager::getInstance()->getConnection("instituto");
    	$sql = "select idgrupo,nombre 
                from ListaGrupo WHERE idcicloescolar=".$cicloEscolar." AND idgrado=".$grado;
    	$st = $conn->execute($sql);
    	return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getSecciones(){
    	$conn = Doctrine_Manager::getInstance()->getConnection("instituto");
    	$sql = "select nombre,seccion as total
                from ListaAlumnoB";
    	$st = $conn->execute($sql);
    	return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getCiclosEscolares(){
    	$conn = Doctrine_Manager::getInstance()->getConnection("instituto");
    	$sql = "select idcicloescolar ,nombre,estatus 
                from ListaCicloEscolar WHERE estatus IN ('Activo','Programacion')";
    	$st = $conn->execute($sql);
    	return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    
}