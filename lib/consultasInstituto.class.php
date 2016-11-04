<?php

/*
  Clase para hacer consultas a la bd
 */
$GLOBALS['instBD'] = "default";

//$GLOBALS['instBD']="instituto";
class consultasInstituto {

    //SISE DESEA USAR EL LOCAL  CAMBIAR
    //'instutto' en $conn = Doctrine_Manager::getInstance()->getConnection("instituto"); por 'default'  
    public static function getListaAlumnosFiltros($idCiclo, $idGrado, $idgrupo, $alumno, $limit, $offset, $idsVenta, $idsPadre) {

        $campos = "select idalumno as id,CONCAT(appat,' ',apmat,' ',nombre) as nombre,seccion as nivel,GradoPuro as grado,NombreGrupo as grupo";

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

    public static function getTotalListaAlumnosFiltros($idCiclo, $idGrado, $idgrupo, $alumno,$idsVenta, $idsPadre) {

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
    
    
    

}
