<?php
/*
Clase para hacer consultas a la bd
*/

class consultasInstituto
{
  
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