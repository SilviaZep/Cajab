<?php

/*
  Clase para hacer consultas a la bd
 */

class consultasInstituto {

    //SISE DESEA USAR EL LOCAL  CAMBIAR
    //'instutto' en $conn = Doctrine_Manager::getInstance()->getConnection("instituto"); por 'default'  
    public static function getListaAlumnosFiltros($idCiclo, $idGrado, $idgrupo, $alumno, $limit, $offset) {

        $campos = "select idalumno as id,CONCAT(nombre,' ', appat,' ',apmat) as nombre,seccion as nivel,GradoPuro as grado,NombreGrupo as grupo";

        $condicion = " WHERE alumnoactivo=1 ";

        if (isset($idCiclo) && !empty($idCiclo)) {
            $condicion = $condicion.= " AND idcicloescolar ='" . $idCiclo . "'";
        }

        if (isset($idGrado) && !empty($idGrado)) {
            $condicion = $condicion.= " AND idgrado ='" . $idGrado . "'";
        }
        if (isset($idgrupo) && !empty($idgrupo)) {
            $condicion = $condicion.= " AND idgrupo ='" . $idgrupo . "'";
        }
        if (isset($alumno) && !empty($alumno)) {
            $condicion = $condicion.= " AND (CONCAT(nombre,' ', appat,' ',apmat) LIKE '%" . $alumno . "%')";
        }

        $conn = Doctrine_Manager::getInstance()->getConnection("default"); //nombre de mi conexion 
        $sql = $campos . " FROM listaalumnob" . $condicion . "
          ORDER BY nombre ASC  limit " . $limit . " offset  " . $offset . "  ;";
        //ECHO $sql; die();
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTotalListaAlumnosFiltros($idCiclo, $idGrado, $idgrupo, $alumno) {

        $campos = "select count(*) as total ";

        $condicion = " WHERE alumnoactivo=1 ";

        if (isset($idCiclo) && !empty($idCiclo)) {
            $condicion = $condicion.= " AND idcicloescolar ='" . $idCiclo . "'";
        }

        if (isset($idGrado) && !empty($idGrado)) {
            $condicion = $condicion.= " AND idgrado ='" . $idGrado . "'";
        }
        if (isset($idgrupo) && !empty($idgrupo)) {
            $condicion = $condicion.= " AND idgrupo ='" . $idgrupo . "'";
        }
        if (isset($alumno) && !empty($alumno)) {
           $condicion = $condicion.= " AND (CONCAT(nombre,' ', appat,' ',apmat) LIKE '%" . $alumno . "%')";
        }
        $conn = Doctrine_Manager::getInstance()->getConnection("default"); //nombre de mi conexion 
        $sql = $campos . " FROM listaalumnob " . $condicion . ";";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getGradosByCiclo($cicloEscolar) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "select DISTINCT idgrado ,grado
                from listagrupo WHERE idcicloescolar=" . $cicloEscolar;
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getGruposByGrado($grado, $cicloEscolar) {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "select idgrupo,nombre 
                from listagrupo WHERE idcicloescolar=" . $cicloEscolar . " AND idgrado=" . $grado;
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCiclosEscolares() {
        $conn = Doctrine_Manager::getInstance()->getConnection("default");
        $sql = "select idcicloescolar ,nombre,estatus 
                from listacicloescolar WHERE estatus IN ('Activo','Programacion')";
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    //Consulta de alumno por ID

    public static function getAlumnoXId($idAlumno) {
        $sql = "select ifnull(CONCAT(nombre,' ', appat,' ',apmat),'') as nombre 
                   from listaalumnob where idalumno =".$idAlumno." limit 0,1;";
        $conn = Doctrine_Manager::getInstance()->getConnection("default"); //nombre de mi conexion         
        $st = $conn->execute($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

}
