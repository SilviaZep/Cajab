<?php
/*
Clase para hacer consultas a la bd
*/

class consultasInstituto
{
 //SISE DESEA USAR EL LOCAL  CAMBIAR
 //'instutto' en $conn = Doctrine_Manager::getInstance()->getConnection("instituto"); por 'default'  
        public static function getListaAlumnosFiltros($idCiclo, $idGrado, $idgrupo,$alumno){    	
    	
    	$campos = "select idalumno,nombre,appat,apmat";
    		
    	$condicion = " WHERE alumnoactivo=1 ";
    	
    	if(isset($idCiclo) && !empty($idCiclo))
    	{
    		$condicion= $condicion.= " AND idcicloescolar ='".$idCiclo."'";
    	}
    	
    	if(isset($idGrado) && !empty($idGrado))
    	{
    		$condicion= $condicion.= " AND idgrado ='".$idGrado."'";
    	}
    	if(isset($idgrupo) && !empty($idgrupo))
    	{
    		$condicion= $condicion.= " AND idgrupo ='".$idgrupo."'";
    	}
    	if(isset($alumno) && !empty($alumno))
    	{
    		$condicion= $condicion.= " AND (nombre LIKE '%" . $alumno . "%' OR appat LIKE '%" . $alumno . "%' OR apmat LIKE '%" . $alumno . "%')";
    	}
    	
    	$conn = Doctrine_Manager::getInstance()->getConnection("default"); //nombre de mi conexion 
    	$sql = $campos. " FROM listaalumnob".$condicion."
          ORDER BY idalumno ASC;";
    	//ECHO $sql; die();
    	$st = $conn->execute($sql);
    	return $st->fetchAll(PDO::FETCH_ASSOC);  	 
    }
    
    public static function getGradosByCiclo($cicloEscolar){
    	$conn = Doctrine_Manager::getInstance()->getConnection("default");
    	$sql = "select DISTINCT idgrado ,grado
                from listagrupo WHERE idcicloescolar=".$cicloEscolar;
    	$st = $conn->execute($sql);
    	return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function getGruposByGrado($grado,$cicloEscolar){
    	$conn = Doctrine_Manager::getInstance()->getConnection("default");
    	$sql = "select idgrupo,nombre 
                from listagrupo WHERE idcicloescolar=".$cicloEscolar." AND grado='".$grado."'";
    	$st = $conn->execute($sql);
    	return $st->fetchAll(PDO::FETCH_ASSOC);
    }  
    public static function getCiclosEscolares(){
    	$conn = Doctrine_Manager::getInstance()->getConnection("default");
    	$sql = "select idcicloescolar ,nombre,estatus 
                from listacicloescolar WHERE estatus IN ('Activo','Programacion')";
    	$st = $conn->execute($sql);
    	return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    
}