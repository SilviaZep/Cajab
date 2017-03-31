<?php

/*
  Clase para hacer consultas a la bd
 */
//$GLOBALS['instBD'] = "default";

$GLOBALS['instBD']="instituto";
class consultasInstituto {

    //SISE DESEA USAR EL LOCAL  CAMBIAR
    //'instutto' en $conn = Doctrine_Manager::getInstance()->getConnection("instituto"); por 'default'  
    public static function getListaAlumnosFiltros($idCiclo, $idGrado, $idgrupo, $alumno, $limit, $offset, $idsVenta, $idsPadre) {

        $campos = "select idalumno as id,CONCAT(appat,' ',apmat,' ',nombre) as nombre,seccion as nivel,GradoPuro as grado,if(NombreGrupo='',null,NombreGrupo) as grupo,ifnull(idseccion,0) as idCiclo,ifnull(idgrado,0) as idGrado,ifnull(idgrupo,0) as idGrupo";

        $condicion = " WHERE alumnoactivo=1 ";

        if (isset($idCiclo) && !empty($idCiclo)) {
            $condicion = $condicion.= " AND idcicloescolar ='" . $idCiclo . "'";
        }

        if (isset($idGrado) && !empty($idGrado)) {
            $condicion = $condicion.= " AND idgrado ='" . $idGrado . "'";
        }
        if (isset($idgrupo) && !empty($idgrupo)) {
            $condicion = $condicion.= " AND NombreGrupo ='" . $idgrupo . "'";
        }
        if (isset($alumno) && !empty($alumno)) {
            $condicion = $condicion.= " AND (CONCAT( appat,' ',apmat,' ',nombre) LIKE '%" . $alumno . "%')";
        }

        if ($idsVenta != "") {//si trae ids
            $condicion = $condicion.= " AND idalumno not in(" . $idsVenta . ")";
        }
        if ($idsPadre != "") {//si trae ids
            $condicion = $condicion.= " AND idalumno in(" . $idsPadre . ")";
        }


        $conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['instBD']); //nombre de mi conexion 
        $sql = $campos . " FROM ListaAlumnoB" . $condicion . "
          ORDER BY nombre ASC  limit " . $limit . " offset  " . $offset . "  ;";

        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTotalListaAlumnosFiltros($idCiclo, $idGrado, $idgrupo, $alumno, $idsVenta, $idsPadre) {

        $campos = "select count(*) as total ";

        $condicion = " WHERE alumnoactivo=1 ";

        if (isset($idCiclo) && !empty($idCiclo)) {
            $condicion = $condicion.= " AND idcicloescolar ='" . $idCiclo . "'";
        }

        if (isset($idGrado) && !empty($idGrado)) {
            $condicion = $condicion.= " AND idgrado ='" . $idGrado . "'";
        }
        if (isset($idgrupo) && !empty($idgrupo)) {
            $condicion = $condicion.= " AND NombreGrupo ='" . $idgrupo . "'";
        }
        if (isset($alumno) && !empty($alumno)) {
            $condicion = $condicion.= " AND (CONCAT(appat,' ',apmat,' ',nombre) LIKE '%" . $alumno . "%')";
        }

        if ($idsVenta != "") {//si trae ids
            $condicion = $condicion.= " AND idalumno not in(" . $idsVenta . ")";
        }
        if ($idsPadre != "") {//si trae ids
            $condicion = $condicion.= " AND idalumno in(" . $idsPadre . ")";
        }

        $conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['instBD']); //nombre de mi conexion 
        $sql = $campos . " FROM ListaAlumnoB " . $condicion . ";";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getGradosByCiclo($cicloEscolar) {
        $conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['instBD']);
        $sql = "select DISTINCT idgrado ,grado
                from ListaGrupo WHERE idcicloescolar=" . $cicloEscolar;
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getGruposByGrado($grado, $cicloEscolar) {
        $conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['instBD']);
        $sql = "select idgrupo,nombre 
                from ListaGrupo WHERE idcicloescolar=" . $cicloEscolar . " AND idgrado=" . $grado;
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCiclosEscolares() {
        $conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['instBD']);
        $sql = "select idcicloescolar ,nombre,estatus 
                from ListaCicloEscolar WHERE estatus IN ('Activo','Programacion')";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    //Consulta de alumno por ID

    public static function getAlumnoXId($idAlumno) {
        $sql = "select ifnull(CONCAT(appat,' ',apmat,' ',nombre),'') as nombre 
                   from ListaAlumnoB where idalumno =" . $idAlumno . " limit 0,1;";
        $conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['instBD']); //nombre de mi conexion         
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getDatosAlumnoXId($idAlumno) {
        $sql = "select ifnull(CONCAT(appat,' ',apmat,' ',nombre,'  *' ,ifnull(NombreGrado,' '),' ',ifnull(NombreGrupo,' ')),' ') as nombre 
                   from ListaAlumnoB where idalumno =" . $idAlumno . " limit 0,1;";
        $conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['instBD']); //nombre de mi conexion         
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    //nueva---
  public static function getDatosCompletosAlumnoXId($idAlumno) {
        $sql = "select ifnull(CONCAT(appat,' ',apmat,' ',nombre,' ' ,ifnull(seccion,' '),' ',ifnull(GradoPuro,' '),' ',ifnull(NombreGrupo,' ')),' ') as nombre 
                   from ListaAlumnoB where idalumno =" . $idAlumno . " limit 0,1;";
        $conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['instBD']); //nombre de mi conexion         
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    //----

    public static function getDatosAlumnoXIdSeccion($idAlumno, $seccion) {
        $sql = "select ifnull(CONCAT(appat,' ',apmat,' ',nombre,'  *' ,ifnull(NombreGrado,' '),' ',ifnull(NombreGrupo,' ')),' ') as nombre 
                   from ListaAlumnoB where idalumno =" . $idAlumno .
                " and ifnull(CONCAT(ifnull(NombreGrado,' '),' ',ifnull(NombreGrupo,' ')),' ') like '%" . $seccion . "%'   limit 0,1;";
        $conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['instBD']); //nombre de mi conexion         
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getDatosAlumnoXIdSeccionSeparados($idAlumno, $seccion) {
        $sql = "select ifnull(CONCAT(appat,' ',apmat,' ',nombre),' ') as nombre ,
                ifnull(CONCAT('* ',ifnull(NombreGrado,' '),' ',ifnull(NombreGrupo,' ')),' ') as seccion
                   from ListaAlumnoB where idalumno =" . $idAlumno .
                " and ifnull(CONCAT(ifnull(NombreGrado,' '),' ',ifnull(NombreGrupo,' ')),' ') like '%" . $seccion . "%'   limit 0,1;";
        $conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['instBD']); //nombre de mi conexion         
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getSoloDatosAlumnoXId($idAlumno) {
        $sql = "select ifnull(CONCAT(ifnull(NombreGrado,' '),' ',ifnull(NombreGrupo,' ')),' ') as datos 
                   from ListaAlumnoB where idalumno =" . $idAlumno . " limit 0,1;";
        $conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['instBD']); //nombre de mi conexion         
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getIdsAlumnos($nombre) {
        $sql = "select  idalumno
                   from ListaAlumnoB 
                   where CONCAT(appat,' ',apmat,' ',nombre) like'%" . $nombre . "%' ;";

        $conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['instBD']); //nombre de mi conexion         
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getNombreGrupoPorId($idGrupo) {
        $conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['instBD']);
        $sql = "select nombre
                from ListaGrupo WHERE idgrupo={$idGrupo};";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getMasDatosAlumnoXId($idAlumno, $fecha) {
        $sql = "select ifnull(CONCAT(ifnull(NombreGrado,' '),' ',ifnull(NombreGrupo,' ')),' ') as datos,
            if(bajasolo=1,'SI','NO') as baja_solo,ifnull(direccionBajada,'NA') as direccion_baja,ifnull(celular,'NA') as celular,
            ifnull(personarecibe,'NA') as persona_recibe,ifnull(Observaciones,'NA') as observaciones,
            if(ifnull(dia,' ') like concat('%',@dia,'%') ,'SI','NO') as extracurricular,
            @dia:=(WEEKDAY('$fecha')+1) as dia_hoy,
            @t:=ifnull(LENGTH(dia),0) as tamanio,
            @pi:=ifnull(LOCATE(@dia,dia),0) as pi,
            @sub:=if(@pi<>0,SUBSTRING(dia,@pi,(@t-(@pi-1))),'') as  sub,
            @tsub:=ifnull(LENGTH(@sub),0) as tamanio_sub,
            @pf:=ifnull(if(LOCATE('-',@sub)=0 and @tsub>0,@tsub,LOCATE('-',@sub)),0) as pf,
            @ext:=if(@pi<>0 and @pf<>0,SUBSTRING(@sub,1,@pf),'NA') as ext,
            @extB:=REPLACE(@ext,@dia,'') as extB,
            @extC:=REPLACE(@extB,'-','') as extC,
            REPLACE(@extC,'|','') as extracurricular
            from ListaAlumnoB where idalumno =" . $idAlumno . " limit 0,1;";
        $conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['instBD']); //nombre de mi conexion         
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

}
