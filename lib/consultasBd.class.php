<?php

/*
  Clase para hacer consultas a la bd
 */

class consultasBd {

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
      } */

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
        $sql = sprintf($sql, $id);
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
      ifnull((select nombre from servicio where id=s.id_servicio),'') as servicio_padre,
      (select count(*) from servicio_cliente sc where sc.estatus in (1,2) and sc.id_servicio=s.id) as inscritos
      from servicio s
      where s.activo=1
      and s.fecha_evento >='{$fechaIni}'
      and s.fecha_evento <='{$fechaFin}'
      and s.nombre like '%{$nombreServicio}%'
      {$filtroCategoria}
      order by servicio_padre asc,s.nombre asc
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
      ifnull((select categoria from categoria_servicio where id=s.categoria_id),'NA') as categoria,
      ifnull((select nombre from servicio where id=s.id_servicio),'') as servicio_padre      
      from servicio s
      where s.activo=1
      and s.fecha_inicio<=date(now())
      and date(now())<=s.fecha_fin
      and s.nombre like '%{$nombreServicio}%'
      {$filtroCategoria}
      order by servicio_padre asc,s.fecha_evento desc,s.nombre asc
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

    public static function getListaRutasActivas() {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");

        $sql = "select
    	* from ruta";
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
                s.nombre as nombre_servicio,
                ifnull((select cs.categoria from categoria_servicio cs where id=s.categoria_id),'na') as categoria_servicio,
                date(sc.fecha_registro) as fecha_registro
                from servicio_cliente sc,servicio s
                where sc.id_servicio=s.id) t
                where id_servicio={$idServicio}
                and (cliente like '%{$nombreCliente}%'  or cliente='na')                 
                order by fecha_registro desc
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
                and (cliente like '%{$nombreCliente}%'  or cliente='na')                
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

    public static function getHorariosAlumnos($limit, $offset, $idsAlumno) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");

        $filtroAlumnos = "";
        if ($idsAlumno != "") {
            $filtroAlumnos = "where hr.id_alumno in (" . $idsAlumno . ")";
        }

        $sql = "select hr.*,
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
                from horario_ruta hr 
                " . $filtroAlumnos . "order by fecha_registro desc limit {$limit} offset {$offset};";

        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTotalHorariosAlumnos($idsAlumno) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $filtroAlumnos = "";
        if ($idsAlumno != "") {
            $filtroAlumnos = "where hr.id_alumno in (" . $idsAlumno . ")";
        }

        $sql = "select count(*) as total
                from horario_ruta hr " . $filtroAlumnos . "  ;";
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
                    from lista_ruta lr
                    where lr.fecha='{$fecha}'
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
                    select sc.id as id_ref,0 as guardado,
                    (case hr.tipo when 1 then 'Completo' when 2 then 'Medio' else 'NA' end ) as tipo_transporte,
                    sc.id_alumno,
                    'asistencia' as observacion,
                    0 as id_lista
                    from servicio_cliente sc,servicio s,horario_ruta hr
                    where sc.id_servicio=s.id
                    and sc.id_alumno=hr.id_alumno                   
                    and s.fecha_evento<='{$fecha}'
                    and s.fecha_fin>='{$fecha}'
                    and s.tipo_transporte in (1,2)
                    and s.activo=1 and (sc.estatus=1 or sc.estatus=2)
                    and (hr.r_{$dia}_e={$ruta} or hr.r_{$dia}_s={$ruta})
                    union 
                    select lr.id as id_ref,0 as guardado,
                    (case lr.tipo when 1 then 'Completo' when 2 then 'Medio' when 3 then 'Eventual' else 'NA' end ) as tipo_transporte,
                    lr.id_alumno,
                    ifnull(lr.observacion,'asistencia') as observacion,
                    lr.id as id_lista
                    from lista_ruta lr
                    where lr.fecha='{$fecha}'
                    and lr.id_ruta={$ruta}
                    )t                    ;";
        }
        if ($flagQ == 2) {//guardados
            $sql = "select 0 as id_ref,1 as guardado, 
                    (case lr.tipo when 1 then 'Completo' when 2 then 'Medio' when 3 then 'Eventual' else 'NA' end ) as tipo_transporte,
                    lr.id_alumno,
                    ifnull(lr.observacion,'asistencia') as observacion,
                    lr.id as id_lista
                    from lista_ruta lr
                    where fecha='{$fecha}'
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
                    from lista_ruta lr
                    where lr.fecha='{$fecha}'
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
                    select sc.id as id_ref,
                    (case hr.tipo when 1 then 'Completo' when 2 then 'Medio' else 'NA' end ) as tipo_transporte
                    from servicio_cliente sc,servicio s,horario_ruta hr
                    where sc.id_servicio=s.id
                    and sc.id_alumno=hr.id_alumno                   
                    and s.fecha_evento<='{$fecha}'
                    and s.fecha_fin>='{$fecha}'
                    and s.tipo_transporte in (1,2)
                    and s.activo=1 and (sc.estatus=1 or sc.estatus=2)
                    and (hr.r_{$dia}_e={$ruta} or hr.r_{$dia}_s={$ruta})
                    union 
                    select lr.id as id_ref,
                    (case lr.tipo when 1 then 'Completo' when 2 then 'Medio' when 3 then 'Eventual' else 'NA' end ) as tipo_transporte 
                    from lista_ruta lr
                    where lr.fecha='{$fecha}'
                    and lr.id_ruta={$ruta}
                    )t             ;";
        }
        if ($flagQ == 2) {//guardados
            $sql = "select count(*) as total
                    from lista_ruta lr
                    where fecha='{$fecha}'
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
                from lista_ruta lr
                where lr.fecha='{$fecha}'
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

//-------------------------------------Querys del estado de cuenta--------------------------------


    public static function getServiciosPagandoAlumno($idAlumno) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "
		select s.nombre as servicio,s.aplica_parcialidad,cs.categoria,
		s.precio,
		ifnull((select sum(ifnull(sp.monto,0)+ifnull(sp.descuento,0)) from servicio_pago sp 
		where sp.id_alumno=sc.id_alumno 
		and sp.id_servicio=sc.id and sp.estatus=1),0) as abonado,
		(select count(*) from servicio_pago sp 
		where sp.id_alumno=sc.id_alumno 
		and sp.id_servicio=sc.id and sp.estatus=1) as no_pagos,
		sc.*
		from 
		servicio_cliente sc,servicio s,categoria_servicio cs
		where sc.id_servicio=s.id 
		and s.categoria_id=cs.id
		and sc.id_alumno={$idAlumno}
		and sc.estatus=1;";

        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getActualizarEstatusServicioCliente($idServicioCliente) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        date_default_timezone_set('America/Mexico_City');
        $sql = " call sp_actualizar_estatus_servicio_cliente({$idServicioCliente});";
        $conn->execute($sql);
        return true;
    }

    public static function getDetallesPagosServicioCliente($idServicioCliente) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "

		select fecha_pago,forma_pago,ifnull(monto,0) as monto,ifnull(descuento,0) as descuento 
		from servicio_pago sp 
		where  sp.id_servicio={$idServicioCliente} AND sp.estatus=1";

        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

//*********************************************Cliente servicios



    public static function getServiciosPagandoCliente($idCliente) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "
		select s.nombre as servicio,s.aplica_parcialidad,cs.descripcion as categoria,a.nombre as cliente,
		s.precio,
		ifnull((select sum(ifnull(sp.monto,0)+ifnull(sp.descuento,0)) from servicio_pago sp 
		where sp.id_cliente=sc.id_cliente and sp.estatus=1
		and sp.id_servicio=sc.id),0) as abonado,
		(select count(*) from servicio_pago sp 
		where sp.id_cliente=sc.id_cliente and sp.estatus=1
		and sp.id_servicio=sc.id) as no_pagos,
		sc.*
		from 
		servicio_cliente sc,servicio s,categoria_servicio cs,clientes_externos a
		where sc.id_servicio=s.id 
		and s.categoria_id=cs.id
		and sc.id_cliente=a.id
		and sc.id_cliente={$idCliente}
		and sc.estatus=1;";

        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

//----------------------------------Fin Querys estado de cuenta--------------------------------------
//------------------------------------------------
    public static function getIdsServicioCliente($idServicio) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "select distinct(id_alumno) as id_alumno
from servicio_cliente where id_servicio={$idServicio} and id_alumno is not null;";

        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

//-------------------lo pagado a un servicio
    public static function getPagadoClientesServicio($idServicio, $limit, $offset) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");

        $sql = "select *,if(estatus_descripcion='Cancelado',0,ifnull(((abonado+descuento)-precio),0)) as saldo 
		from (
		select * ,
		(select ifnull(s.precio,0) from servicio s where s.id=sc.id_servicio) as precio,
		(case tipo_cliente
		when 1 then (select ifnull(sum(ifnull(sp.monto,0)),0) from servicio_pago sp
		where sp.id_servicio=sc.id and sp.id_alumno=sc.id_alumno and sp.estatus=1)
		when 2 then (select ifnull(sum(ifnull(sp.monto,0)),0) from servicio_pago sp
		where sp.id_servicio=sc.id and sp.id_cliente=sc.id_cliente and sp.estatus=1)
		end) as abonado,
		(case tipo_cliente
		when 1 then (select ifnull(sum(ifnull(sp.descuento,0)),0) from servicio_pago sp
		where sp.id_servicio=sc.id and sp.id_alumno=sc.id_alumno and sp.estatus=1)
		when 2 then (select ifnull(sum(ifnull(sp.descuento,0)),0) from servicio_pago sp
		where sp.id_servicio=sc.id and sp.id_cliente=sc.id_cliente and sp.estatus=1)
		end) as descuento,
		(case tipo_cliente
		when 1 then (select count(*) from servicio_pago sp
		where sp.id_servicio=sc.id and sp.id_alumno=sc.id_alumno and sp.estatus=1)
		when 2 then (select count(*) from servicio_pago sp
		where sp.id_servicio=sc.id and sp.id_cliente=sc.id_cliente and sp.estatus=1)
		end) as no_abonos,
		(CASE sc.tipo_cliente
		WHEN 1 THEN 'na'
		WHEN 2 THEN ifnull((select nombre from clientes_externos where id=sc.id_cliente),'na')
		ELSE  'na' END) as cliente,
		(CASE sc.tipo_cliente
		WHEN 1 THEN 'Alumno'
		WHEN 2 THEN 'Cliente Externo'
		ELSE  'na' END) as tipo_descripcion,
		(CASE sc.estatus
		WHEN 1 THEN 'Activo'
		WHEN 2 THEN 'Pagado'
		WHEN 3 THEN 'Cancelado'
		WHEN 4 THEN 'Condonado'
		ELSE  'na' END) as estatus_descripcion
		from servicio_cliente sc
		where sc.id_servicio={$idServicio})t 
		order by saldo asc,id_alumno asc
		limit {$limit} offset {$offset};";

        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPagadoClientesServicioAgrupado($idServicio, $limit, $offset) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");

        $sql = "select *,sum(precio) as precio_suma,
sum(abonado) as abonado_suma,sum(descuento) as descuento_suma,
sum((abonado+descuento)-precio) as saldo_suma
from (
select * ,
(select ifnull(s.precio,0) from servicio s where s.id=sc.id_servicio) as precio,
(case tipo_cliente
when 1 then (select ifnull(sum(ifnull(sp.monto,0)),0) from servicio_pago sp
where sp.id_servicio=sc.id and sp.id_alumno=sc.id_alumno and sp.estatus=1)
when 2 then (select ifnull(sum(ifnull(sp.monto,0)),0) from servicio_pago sp
where sp.id_servicio=sc.id and sp.id_cliente=sc.id_cliente and estatus=1)
end) as abonado,
(case tipo_cliente
when 1 then (select ifnull(sum(ifnull(sp.descuento,0)),0) from servicio_pago sp
where sp.id_servicio=sc.id and sp.id_alumno=sc.id_alumno and sp.estatus=1)
when 2 then (select ifnull(sum(ifnull(sp.descuento,0)),0) from servicio_pago sp
where sp.id_servicio=sc.id and sp.id_cliente=sc.id_cliente and sp.estatus=1)
end) as descuento,
(case tipo_cliente
when 1 then (select count(*) from servicio_pago sp
where sp.id_servicio=sc.id and sp.id_alumno=sc.id_alumno and sp.estatus=1)
when 2 then (select count(*) from servicio_pago sp
where sp.id_servicio=sc.id and sp.id_cliente=sc.id_cliente and sp.estatus=1)
end) as no_abonos,
(CASE sc.tipo_cliente
WHEN 1 THEN 'na'
WHEN 2 THEN ifnull((select nombre from clientes_externos where id=sc.id_cliente),'na')
ELSE  'na' END) as cliente,
(CASE sc.tipo_cliente
WHEN 1 THEN 'Alumno'
WHEN 2 THEN 'Cliente Externo'
ELSE  'na' END) as tipo_descripcion,
(CASE sc.estatus
WHEN 1 THEN 'Activo'
WHEN 2 THEN 'Pagado'
WHEN 3 THEN 'Cancelado'
WHEN 4 THEN 'Condonado'
ELSE  'na' END) as estatus_descripcion,
if(id_alumno is null,concat('c_',id_cliente),id_alumno) as id_cliente_ac
from servicio_cliente sc
where sc.id_servicio={$idServicio}
and sc.estatus!=3)t 
group by id_cliente_ac
order by saldo_suma asc;
limit {$limit} offset {$offset};";

        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTotalPagadoClientesServicio($idServicio) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");

        $sql = "select count(*) as total
from (
select * ,
(select ifnull(s.precio,0) from servicio s where s.id=sc.id_servicio) as precio,
(case tipo_cliente
when 1 then (select ifnull(sum(ifnull(sp.monto,0)),0) from servicio_pago sp
where sp.id_servicio=sc.id and sp.id_alumno=sc.id_alumno and sp.estatus=1)
when 2 then (select ifnull(sum(ifnull(sp.monto,0)),0) from servicio_pago sp
where sp.id_servicio=sc.id and sp.id_cliente=sc.id_cliente and sp.estatus=1)
end) as abonado,
(case tipo_cliente
when 1 then (select ifnull(sum(ifnull(sp.descuento,0)),0) from servicio_pago sp
where sp.id_servicio=sc.id and sp.id_alumno=sc.id_alumno and sp.estatus=1)
when 2 then (select ifnull(sum(ifnull(sp.descuento,0)),0) from servicio_pago sp
where sp.id_servicio=sc.id and sp.id_cliente=sc.id_cliente and sp.estatus=1)
end) as descuento,
(case tipo_cliente
when 1 then (select count(*) from servicio_pago sp
where sp.id_servicio=sc.id and sp.id_alumno=sc.id_alumno and sp.estatus=1)
when 2 then (select count(*) from servicio_pago sp
where sp.id_servicio=sc.id and sp.id_cliente=sc.id_cliente and sp.estatus=1)
end) as no_abonos,
(CASE sc.tipo_cliente
WHEN 1 THEN 'na'
WHEN 2 THEN ifnull((select nombre from clientes_externos where id=sc.id_cliente),'na')
ELSE  'na' END) as cliente,
(CASE sc.tipo_cliente
WHEN 1 THEN 'Alumno'
WHEN 2 THEN 'Cliente Externo'
ELSE  'na' END) as tipo_descripcion,
(CASE sc.estatus
WHEN 1 THEN 'Activo'
WHEN 2 THEN 'Pagado'
WHEN 3 THEN 'Cancelado'
WHEN 4 THEN 'Condonado'
ELSE  'na' END) as estatus_descripcion
from servicio_cliente sc
where sc.id_servicio={$idServicio})t 
;";

        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getConsecutivoPago() {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "select (ifnull(max(id_pago),0)+1) as consecutivo 
           from servicio_pago;";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTicketPago($idPago) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "select 
	(select nombre 
	from servicio where id=
	(select sc.id_servicio from servicio_cliente sc where sc.id=sp.id_servicio)) as nombre_servicio,
	(CASE sp.tipo_cliente
	WHEN 1 THEN 'na'
	WHEN 2 THEN ifnull((select nombre from clientes_externos where id=sp.id_cliente),'na')
	ELSE  'na' END) as cliente,
	(CASE sp.tipo_cliente
	WHEN 1 THEN 'Alumno'
	WHEN 2 THEN 'Cliente Externo'
	ELSE  'na' END) as tipo_descripcion,
	sp.monto,sp.descuento,
	sp.forma_pago,sp.id_pago,sp.fecha_pago,sp.id_alumno
	from servicio_pago sp
	where id_pago={$idPago};";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getListadoDiasMora($limit, $offset) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "select *,if(estatus_descripcion='Cancelado',0,ifnull(((abonado+descuento)-precio),0)) as saldo    
		from (
		SELECT 
		s.nombre as servicio,
		(CASE sc.tipo_cliente
		WHEN 1 THEN 'Alumno'
		WHEN 2 THEN 'Cliente Externo'
		ELSE  'na' END) as tipo_descripcion,
		(CASE sc.tipo_cliente
		WHEN 1 THEN 'na'
		WHEN 2 THEN ifnull((select nombre from clientes_externos where id=sc.id_cliente),'na')
		ELSE  'na' END) as cliente,
		s.precio,
		(case sc.tipo_cliente
		when 1 then (select ifnull(sum(ifnull(sp.monto,0)),0) from servicio_pago sp
		where sp.id_servicio=sc.id and sp.id_alumno=sc.id_alumno and sp.estatus=1)
		when 2 then (select ifnull(sum(ifnull(sp.monto,0)),0) from servicio_pago sp
		where sp.id_servicio=sc.id and sp.id_cliente=sc.id_cliente and sp.estatus=1)
		end) as abonado,
		(case sc.tipo_cliente
		when 1 then (select ifnull(sum(ifnull(sp.descuento,0)),0) from servicio_pago sp
		where sp.id_servicio=sc.id and sp.id_alumno=sc.id_alumno and sp.estatus=1)
		when 2 then (select ifnull(sum(ifnull(sp.descuento,0)),0) from servicio_pago sp
		where sp.id_servicio=sc.id and sp.id_cliente=sc.id_cliente and sp.estatus=1)
		end) as descuento,
		(case sc.tipo_cliente
		when 1 then (select count(*) from servicio_pago sp
		where sp.id_servicio=sc.id and sp.id_alumno=sc.id_alumno and sp.estatus=1)
		when 2 then (select count(*) from servicio_pago sp
		where sp.id_servicio=sc.id and sp.id_cliente=sc.id_cliente and sp.estatus=1)
		end) as no_abonos,
		date(s.fecha_fin) as fecha_fin,
		date(now()) as hoy,
		DATEDIFF(now(),s.fecha_fin) as dias_mora,
		(CASE sc.estatus
		WHEN 1 THEN 'Activo'
		WHEN 2 THEN 'Pagado'
		WHEN 3 THEN 'Cancelado'
		WHEN 4 THEN 'Condonado'
		ELSE  'na' END) as estatus_descripcion,
		sc.id_alumno,sc.id
		FROM servicio_cliente sc,servicio s
		where sc.id_servicio=s.id and sc.estatus=1)t 
		order by dias_mora desc,saldo asc
		limit {$offset},{$limit} ;
		";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTotalListadoDiasMora() {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "select count(*) as total
from (
SELECT 
s.nombre as servicio,
(CASE sc.tipo_cliente
WHEN 1 THEN 'Alumno'
WHEN 2 THEN 'Cliente Externo'
ELSE  'na' END) as tipo_descripcion,
(CASE sc.tipo_cliente
WHEN 1 THEN 'na'
WHEN 2 THEN ifnull((select nombre from clientes_externos where id=sc.id_cliente),'na')
ELSE  'na' END) as cliente,
s.precio,
(case sc.tipo_cliente
when 1 then (select ifnull(sum(ifnull(sp.monto,0)),0) from servicio_pago sp
where sp.id_servicio=sc.id and sp.id_alumno=sc.id_alumno and sp.estatus=1)
when 2 then (select ifnull(sum(ifnull(sp.monto,0)),0) from servicio_pago sp
where sp.id_servicio=sc.id and sp.id_cliente=sc.id_cliente and sp.estatus=1)
end) as abonado,
(case sc.tipo_cliente
when 1 then (select ifnull(sum(ifnull(sp.descuento,0)),0) from servicio_pago sp
where sp.id_servicio=sc.id and sp.id_alumno=sc.id_alumno and sp.estatus=1)
when 2 then (select ifnull(sum(ifnull(sp.descuento,0)),0) from servicio_pago sp
where sp.id_servicio=sc.id and sp.id_cliente=sc.id_cliente and sp.estatus=1)
end) as descuento,
(case sc.tipo_cliente
when 1 then (select count(*) from servicio_pago sp
where sp.id_servicio=sc.id and sp.id_alumno=sc.id_alumno and sp.estatus=1)
when 2 then (select count(*) from servicio_pago sp
where sp.id_servicio=sc.id and sp.id_cliente=sc.id_cliente and sp.estatus=1)
end) as no_abonos,
s.fecha_fin,
now() as hoy,
DATEDIFF(now(),s.fecha_fin) as dias_mora,
(CASE sc.estatus
WHEN 1 THEN 'Activo'
WHEN 2 THEN 'Pagado'
WHEN 3 THEN 'Cancelado'
WHEN 4 THEN 'Condonado'
ELSE  'na' END) as estatus_descripcion,
sc.id_alumno
FROM servicio_cliente sc,servicio s
where sc.id_servicio=s.id and sc.estatus=1)t ;

";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getEstadoCuentaAlumno($idAlumno, $fechaIni, $fechaFin) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "select * from (
		select sc.id as id_sc,sc.fecha_registro,s.nombre,
		s.precio as adeuda, 0 as pago
		from servicio_cliente sc,servicio s
		where  sc.id_servicio=s.id
		and sc.id_alumno={$idAlumno}
		union 
		select sp.id_servicio as id_sc,sp.fecha_pago,s.nombre,
		0 as adeuda,(ifnull(sp.monto,0)+ifnull(sp.descuento,0)) as pago
		from servicio_pago sp,servicio_cliente sc,servicio s
		where sp.id_servicio=sc.id and sp.estatus=1
		and sc.id_servicio=s.id
		and sp.id_servicio in (select sc.id
		from servicio_cliente sc,servicio s
		where  sc.id_servicio=s.id
		and sc.id_alumno={$idAlumno})
		)t
		where date(fecha_registro)>='{$fechaIni}'
		and date(fecha_registro)<='{$fechaFin}'
		order by fecha_registro
		;
		";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getEstadoCuentaCliente($idCliente, $fechaIni, $fechaFin) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "select * from (
			select sc.id as id_sc,sc.fecha_registro,s.nombre,
			s.precio as adeuda, 0 as pago
			from servicio_cliente sc,servicio s
			where  sc.id_servicio=s.id
			and sc.id_cliente={$idCliente}
			union 
			select sp.id_servicio as id_sc,sp.fecha_pago,s.nombre,
			0 as adeuda,(ifnull(sp.monto,0)+ifnull(sp.descuento,0)) as pago
			from servicio_pago sp,servicio_cliente sc,servicio s
			where sp.id_servicio=sc.id and sp.estatus=1
			and sc.id_servicio=s.id
			and sp.id_servicio in (select sc.id
			from servicio_cliente sc,servicio s
			where  sc.id_servicio=s.id
			and sc.id_cliente={$idCliente})
			)t
			where date(fecha_registro)>='{$fechaIni}'
			and date(fecha_registro)<='{$fechaFin}'
			order by fecha_registro
			;";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getServiciosActivosAlumnos($limit, $offset, $transporte, $mayores) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $filtroTransporte = "";
        $filtroMayores = "";
        if ($transporte == 'true') {//si es true
            $filtroTransporte = "where transporte like '%SI%'";
        } else {
            $filtroTransporte = "where transporte like '%%'";
        }

        if ($mayores == 'true') {
            $filtroMayores = "and no_servicios>1";
        } else {
            $filtroMayores = "and no_servicios>0";
        }

        $sql = "select * from 
(select sc.id_alumno,sum(1) as no_servicios,GROUP_CONCAT(concat('[',cs.categoria,'-',s.nombre,']')) as servicios,
GROUP_CONCAT(if(s.categoria_id=1 and s.tipo_transporte<>3,'SI','NO')) transporte
from servicio_cliente sc,servicio s,categoria_servicio cs
where sc.id_servicio=s.id
and s.categoria_id=cs.id
and sc.id_alumno is not null
and date(fecha_fin)>=date(now())
group by sc.id_alumno
order by no_servicios)t
{$filtroTransporte}
{$filtroMayores}
limit {$offset},{$limit};
";


        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTotalServiciosActivosAlumnos($transporte, $mayores) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");

        $filtroTransporte = "";
        $filtroMayores = "";
        if ($transporte == 'true') {//si es true
            $filtroTransporte = "where transporte like '%SI%'";
        } else {
            $filtroTransporte = "where transporte like '%%'";
        }

        if ($mayores == 'true') {
            $filtroMayores = "and no_servicios>1";
        } else {
            $filtroMayores = "and no_servicios>0";
        }

        $sql = "select count(*) as total from            
(select sc.id_alumno,sum(1) as no_servicios,GROUP_CONCAT(concat('[',cs.categoria,'-',s.nombre,']')) as servicios,
GROUP_CONCAT(if(s.categoria_id=1 and s.tipo_transporte<>3,'SI','NO')) transporte
from servicio_cliente sc,servicio s,categoria_servicio cs
where sc.id_servicio=s.id
and s.categoria_id=cs.id
and sc.id_alumno is not null
and date(fecha_fin)>=date(now())
group by sc.id_alumno
order by no_servicios)t
{$filtroTransporte}
{$filtroMayores}
;
";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getIngresosEgresosServicio($idServicio) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");


        $sql = "
		select 
                concat(sp.id,'i') as idx,                
                s.nombre,s.precio,sp.monto as pago,ifnull(sp.descuento,0) as descuento,0 as egreso,sp.fecha_pago,
		sp.tipo_cliente,sp.id_alumno,sp.id_cliente,sp.id as idPago,
		CASE sc.tipo_cliente
		WHEN 1 THEN ifnull((select nombre from alumno_pruebas where id=sc.id_alumno),'na')
		WHEN 2 THEN ifnull((select nombre from clientes_externos where id=sc.id_cliente),'na')
		ELSE  'na' END as cliente,'INGRESO' as modo_pago,
		(CASE sc.tipo_cliente
		WHEN 1 THEN 'Alumno'
		WHEN 2 THEN 'Cliente Externo'
		ELSE  'na' END) as tipo_descripcion,
		(select count(*) from servicio_cliente sc where sc.estatus in (1,2) and sc.id_servicio=s.id) as inscritos
		from servicio_pago sp,servicio_cliente sc,servicio s
		where sp.id_servicio=sc.id and sp.estatus=1
		and sc.id_servicio=s.id
		and s.id={$idServicio}
		union 
		select
                concat(e.id,'e') as idx,
		s.nombre,s.precio,0 as pago,0 as descuento,e.cantidad as egreso,e.fecha_registro as fecha_pago,
		2 as tipo_cliente,null as id_alumno,0 as id_cliente,0 as idPago,
		p.nombre as cliente,'EGRESO' as modo_pago,'PROVEEDOR' as tipo_descripcion,
		(select count(*) from servicio_cliente sc where sc.estatus in (1,2) and sc.id_servicio=s.id) as inscritos
		from egresos e,servicio s,proveedores p
		where e.id_servicio=s.id
		and e.id_proveedor=p.id
		and s.id={$idServicio}
		
		order by fecha_pago;
		";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

     public static function getMovimientosCaja($idPago, $fechaIni, $fechaFin, $formaPago, $nombreServicio, $categoria,$tipoRecibo = null) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $filtroIdPago = "";
        $filtroFormaPago = "";
        $filtroEstatusPago = "";
        $filtroCategoria = "";
        if ($idPago != 0) {
            $filtroIdPago = "and sp.id_pago={$idPago}";
        }
        if ($formaPago != "NA") {
            $filtroFormaPago = "and sp.forma_pago='{$formaPago}'";
        }
        if ($tipoRecibo != null) {
            $filtroEstatusPago = " and sp.estatus=1 ";
        }
        if ($categoria != "0") {
            $filtroCategoria = " and s.categoria_id={$categoria} ";
        }
        $sql = "
            select 
        concat('p_',sp.id) as id,
	s.nombre as nombre_servicio,
        ifnull((select descripcion from categoria_servicio where id=s.categoria_id),'NA') as nombre_categoria,
	(CASE sp.tipo_cliente
	WHEN 1 THEN 'na'
	WHEN 2 THEN ifnull((select nombre from clientes_externos where id=sp.id_cliente),'na')
	ELSE  'na' END) as cliente,
	(CASE sp.tipo_cliente
	WHEN 1 THEN 'Alumno'
	WHEN 2 THEN 'Cliente Externo'
	ELSE  'na' END) as tipo_descripcion,
	ifnull(sp.monto,0) as monto,
	ifnull(sp.descuento,0) as descuento,
	sp.forma_pago,
        sp.id_pago,
	date(sp.fecha_pago) as fecha_pago,
        sp.id_alumno,
	(CASE sp.estatus
	WHEN 1 THEN 'Pagado'
	WHEN 0 THEN 'Cancelado'
	ELSE  '' END) as estatus_pago,
        'ingreso' as tipo
	from servicio_pago sp,servicio_cliente sc,servicio s
	where sp.id_servicio=sc.id
	and sc.id_servicio=s.id
	and '{$fechaIni}'<=date(sp.fecha_pago) and  date(sp.fecha_pago)<='{$fechaFin}'
	{$filtroIdPago}
	{$filtroFormaPago}
	{$filtroEstatusPago}
        {$filtroCategoria}
	    and s.nombre like '%{$nombreServicio}%'
                
union

        SELECT 
        concat('e_',e.id) as id,
        s.nombre as nombre_servicio,
        ifnull((select descripcion from categoria_servicio where id=s.categoria_id),'NA') as nombre_categoria,
        p.nombre as proveedor,
        'Cliente Externo' as tipo_descripcion,
        e.cantidad as monto,
        0 as descuento,
        'na' as forma_pago,
        0 as id_pago,
        date(e.fecha_registro) as fecha_pago,
        0 as id_alumno,
        'Pagado' as estatus_pago,
        'egreso' as tipo
		FROM
		egresos e
		JOIN servicio s ON (s.id = e.id_servicio)
		JOIN proveedores p ON (p.id= e.id_proveedor)
		JOIN conceptos_cobro cc ON (cc.id=e.id_concepto)
		where '{$fechaIni}'<=date(e.fecha_registro) and  date(e.fecha_registro)<='{$fechaFin}'
                    and s.nombre like '%{$nombreServicio}%'


	   ";


        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function getEliminarPagos($idPago) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");

        $sql = "
          call sp_eliminar_pagos({$idPago});
            ";

// echo $sql;
        //$st =
        $conn->execute($sql);
        //return $st->fetchAll(PDO::FETCH_ASSOC);
        return true;
    }

    public static function getHistorialServicios($idAC, $tipoCliente) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $filtro = " ";
        if ($tipoCliente == "A") {
            $filtro = " and sc.id_alumno={$idAC} ";
        } else {
            $filtro = " and sc.id_cliente={$idAC} ";
        }

        $sql = "select 
                     c.categoria,
                     s.nombre ,
            (CASE sc.estatus
            WHEN 1 THEN 'Activo'
            WHEN 2 THEN 'Pagado'
            WHEN 3 THEN 'Cancelado'
            WHEN 4 THEN 'Condonado'
            ELSE  'na' END) as estatus,s.fecha_evento
            from servicio_cliente sc,servicio s,categoria_servicio c
            where sc.id_servicio=s.id
            and s.categoria_id=c.id
            {$filtro}
             and s.fecha_evento>DATE_SUB(date(now()),INTERVAL 365 DAY)
            order by categoria,s.nombre;
           
                        ";
// echo $sql;
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

//nuevo silvia
    public static function getHistorialServiciosDetallePago($idAC, $tipoCliente) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $filtro = " ";
        if ($tipoCliente == "A") {
            $filtro = " sc.id_alumno={$idAC} ";
        } else {
            $filtro = " sc.id_cliente={$idAC} ";
        }

        $sql = "select
    	sc.id,
    	c.categoria,
    	s.nombre ,
    	(CASE sc.estatus
    	WHEN 1 THEN 'Activo'
    	WHEN 2 THEN 'Pagado'
    	WHEN 3 THEN 'Cancelado'
    	WHEN 4 THEN 'Condonado'
    	ELSE  'na' END) as estatus,s.fecha_evento,
    	(SELECT MAX(DATE_FORMAT(sp.fecha_pago,'%d/%m/%Y')) FROM servicio_pago sp WHERE sp.id_servicio=sc.id AND sp.estatus=1) as fecha_pago,
    	(SELECT MAX(sp1.id_pago) FROM servicio_pago sp1 WHERE sp1.id_servicio=sc.id AND sp1.estatus=1) as no_recibo
    	from servicio_cliente sc
    	INNER JOIN servicio s ON sc.id_servicio=s.id
    	INNER JOIN categoria_servicio c ON s.categoria_id=c.id    	
    	where  	{$filtro}
    	and s.fecha_evento>DATE_SUB(date(now()),INTERVAL 365 DAY)
    	order by categoria,s.nombre;
    	 
    	";
        // echo $sql; die();
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

//***
    public static function getListaServiciosHijos($idPapa) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");


        $sql = "
                    select id from servicio
                    where id_servicio={$idPapa}
                    and date(now())<=date(fecha_fin) 
                    and activo=1  ";
// echo $sql;
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Consultar servicios que le puedem aplicar al alumno     */

    public static function getListadoServiciosAplicanAlumno($idAlumno, $idCiclo, $idGrado, $idGrupo, $nombreServicio) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");

        $sql = " 
            select 
 s.*,cs.descripcion as categoria,date(s.fecha_evento) as f_evento,date(s.fecha_fin) as f_fin,
 ifnull((select san.nombre from servicio san where san.id =s.id_servicio),'') as nombre_padre
 from servicio s,categoria_servicio cs
 where s.categoria_id=cs.id 
 and (s.ciclo_id=0 or s.ciclo_id={$idCiclo})
 and (s.grado_id=0 or s.grado_id={$idGrado})
 and (s.grupo_id=0 or s.grupo_id={$idGrupo})
 and ( (select count(*) from servicio_cliente sc where sc.id_servicio=s.id  and sc.id_alumno={$idAlumno}) = 0 or s.categoria_id=4 or (s.categoria_id=1 and s.tipo_transporte=3) )
 and date(now())<=date(s.fecha_fin) 
 and s.nombre like '%{$nombreServicio}%'
 order by nombre;";

//  $rsql = sprintf($sql);
//  -- and date(s.fecha_inicio)<=date(now()) 
// echo $sql;
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTotalListadoServiciosAplicanAlumno($idAlumno, $idCiclo, $idGrado, $idGrupo, $nombreServicio) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");

        $sql = " 
            select 
 count(*) as total
 from servicio s,categoria_servicio cs
 where s.categoria_id=cs.id 
 and (s.ciclo_id=0 or s.ciclo_id={$idCiclo})
 and (s.grado_id=0 or s.grado_id={$idGrado})
 and (s.grupo_id=0 or s.grupo_id={$idGrupo})
 and ( (select count(*) from servicio_cliente sc where sc.id_servicio=s.id  and sc.id_alumno={$idAlumno}) = 0 or s.categoria_id=4 or (s.categoria_id=1 and s.tipo_transporte=3) )
 and date(now())<=date(s.fecha_fin) 
 and s.nombre like '%{$nombreServicio}%'  ;";

//  $rsql = sprintf($sql);
//   and date(s.fecha_inicio)<=date(now()) 
//echo $sql;
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getListaServiciosHijosParaClonar($idPapa) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");


        $sql = "
                    select id from servicio
                    where id_servicio={$idPapa}
                    and activo=1 ";
// echo $sql;
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Servicios con detalle de ingresos /egresos */

    public static function getEstadoCuentaServicio($fechaIni, $fechaFin, $formaPago, $nombreServicio,$categoria) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");

        $filtroFormaPago = "";
        if ($formaPago != "NA") {
            $filtroFormaPago = "and sp.forma_pago='{$formaPago}'";
        }
         $filtroCategoria = "and s.categoria_id={$categoria}";
        if ($categoria == 0) {
            $filtroCategoria = "";
        }

        $sql = "
        select *,
        ifnull((pagado-descuento),0) as pagado_sin_descuento,
        ifnull((pagado-egresos-descuento),0) as total ,
        ifnull((esperado-pagado-descuento),0) as saldo 
        from (
        select s.*,
        cs.categoria,
        @inscritos:=ifnull((select count(*) from servicio_cliente sc 
        where sc.estatus in(1,2) and sc.id_servicio=s.id 
        and '{$fechaIni}' <=date(sc.fecha_registro) and  date(sc.fecha_registro)<='{$fechaFin}'),0) as inscritos,
        @esperado:=ifnull((@inscritos*s.precio),0) as esperado,
        @pagado:=ifnull((select sum(ifnull(sp.monto,0)+ifnull(sp.descuento,0)) as pagado
        from servicio_pago sp,servicio_cliente sc
        where sp.id_servicio=sc.id
        and sc.id_servicio=s.id
        and sp.estatus=1
        {$filtroFormaPago}
        and  '{$fechaIni}' <=date(sp.fecha_pago) and  date(sp.fecha_pago)<='{$fechaFin}'),0) as pagado,
        @egresos:=ifnull((select sum(cantidad)  from egresos e 
        where e.id_servicio=s.id 
        and '{$fechaIni}' <=date(e.fecha_registro) and  date(e.fecha_registro)<='{$fechaFin}'),0) as egresos,
        @descuento:=ifnull((select sum(ifnull(sp.descuento,0)) as descuento
        from servicio_pago sp,servicio_cliente sc
        where sp.id_servicio=sc.id
        and sc.id_servicio=s.id
        and sp.estatus=1
        {$filtroFormaPago}
        and  '{$fechaIni}' <=date(sp.fecha_pago) and  date(sp.fecha_pago)<='{$fechaFin}'),0) as descuento
        from servicio s,categoria_servicio cs
        where s.nombre like '%{$nombreServicio}%'
        and s.categoria_id=cs.id 
         {$filtroCategoria}
        )t
        where (pagado>0 or egresos>0)
	order by categoria asc,nombre asc
        ;   ";

        //  echo $sql;

        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    
       public static function getEliminarRutasHoy() {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = " Delete from lista_ruta where date(fecha)=date(now());";
        $conn->execute($sql);
        return true;
    }

}
