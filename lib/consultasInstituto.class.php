<?php

/*
  Clase para hacer consultas a la bd
 */
$GLOBALS['instBD'] = "default";
$GLOBALS['default']="default";
$GLOBALS['cie']="instituto";

//$GLOBALS['instBD']="instituto";
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
        $sql = "select ifnull(CONCAT(appat,' ',apmat,' ',nombre,' ' ,ifnull(seccion,' '),' ',ifnull(GradoPuro,' '),' ',ifnull(if(NombreGrupo='','',NombreGrupo),' ')),' ') as nombre 
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
            ifnull(telefono,'NA') as telefono,
            ifnull(personarecibe,'NA') as persona_recibe,ifnull(Observaciones,'NA') as observaciones,
            dia as dia,
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
    public static function getListaAlumnosFiltrosTest() {
    
    	$campos = "select idalumno as id,CONCAT(appat,' ',apmat,' ',nombre) as nombre,seccion as nivel,GradoPuro as grado,if(NombreGrupo='',null,NombreGrupo) as grupo,ifnull(idseccion,0) as idCiclo,ifnull(idgrado,0) as idGrado,ifnull(idgrupo,0) as idGrupo";
    
    	$condicion = " WHERE alumnoactivo=1 ";
        $condicion = $condicion.= " AND idalumno in(11353)";   	
    
    
    	$conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['instBD']); //nombre de mi conexion
    	$sql = $campos . " FROM ListaAlumnoB" . $condicion . "
          ORDER BY nombre ASC;";
    
    	$st = $conn->execute($sql);
    	return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public static function cronUpdateCIEAlumnos(){
    	
    	$connInstituto = Doctrine_Manager::getInstance()->getConnection($GLOBALS['cie']);//cie
    	//contar registros en cie de  ListaAlumnoB
    	$countQuery = "select count(idalumno) as total FROM ListaAlumnoB WHERE alumnoactivo=1";
    	$st = $connInstituto->execute($countQuery);
    	$totalCie=$st->fetchAll(PDO::FETCH_ASSOC);
    	$totalCie=sizeof($totalCie>0)?$totalCie[0]['total']:0;
    	$connInstituto->close();
    	
    	$conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['default']);    	    	
    	//borrar tabla en CAJA B
    	$query = "TRUNCATE TABLE ListaAlumnoB";    
    	$conn->execute($query);    	    	
    	$conn->close();
    	$consultasInstituto= new consultasInstituto();
    	$offset=0;
    	$count=0;
    	
    	    	
    	while($offset<=$totalCie){   
    		echo "offset:".$offset;
    		$connInstituto = Doctrine_Manager::getInstance()->getConnection($GLOBALS['cie']);//cie
    		$campos = "select * FROM ListaAlumnoB WHERE alumnoactivo=1";
    		$sql =$campos." ORDER BY nombre ASC  limit " . 1000 . " offset  " . $offset . "  ;";
    		$stAlumnos = $connInstituto->execute($sql);
    		$result = $stAlumnos->fetchAll(PDO::FETCH_ASSOC);
    		$connInstituto->close();
    		
    		echo " size:".sizeof($result);
    		$count+=sizeof($result); 		
    		
            $offset+=1000;	
            $consultasInstituto->insertarAlumnos($result);  	
    		
    	}
    	
    	$consultasInstituto->insertarCron('UpdateCIEAlumnos-'.$count);
    	return "OK";
    }
    
    public function insertarCron($tipo){
    	
    	$date=date('Y-m-d h:i:s');
    	$cron=new CronEjecutado();
    	$cron->setTipo($tipo);
    	$cron->setFechaEjecucion($date);
    	$cron->save();
    }
    
  public function insertarAlumnos($result){
  	$conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['default']);
    	if(sizeof($result)>0){
    	 for($i=0; $i<=sizeof($result); $i++){
    		
    		if(isset($result[$i]) && $result[$i]['idalumno']!=null){
    			 $form= new ListaAlumnoB();
    			 $form->setIdcolonia($result[$i]['idcolonia']);
    			 $form->setNombre($result[$i]['nombre']);
    			 $form->setAppat($result[$i]['appat']);
    			 $form->setApmat($result[$i]['apmat']);
    			 $form->setCuentaactiva($result[$i]['cuentaactiva']);
    			 $form->setRfc($result[$i]['rfc']);
    			 $form->setCurp($result[$i]['curp']);
    			 $form->setDireccion($result[$i]['direccion']);
    			 $form->setCelular($result[$i]['celular']);
    			 $form->setTelefono($result[$i]['telefono']);
    			 $form->setEmail($result[$i]['email']);
    			 $form->setIdalumno($result[$i]['idalumno']);
    			 $form->setIdcicloescolar($result[$i]['idcicloescolar']);
    			 $form->setIdgrado($result[$i]['idgrado']);
    			 $form->setIdgrupo($result[$i]['idgrupo']);
    			 $form->setMatricula($result[$i]['matricula']);
    			 $form->setFechaingreso($result[$i]['fechaingreso']);
    			 $form->setAlumnoactivo($result[$i]['alumnoactivo']);
    			 $form->setMotivoseparacion($result[$i]['motivoseparacion']);
    			 $form->setFechabaja($result[$i]['fechabaja']);
    			 $form->setFechanacimiento($result[$i]['fechanacimiento']);
    			 $form->setSexo($result[$i]['sexo']);
    			 $form->setEscuelaprocedencia($result[$i]['escuelaprocedencia']);
    			 $form->setUsuarioactivo($result[$i]['usuarioactivo']);
    			 $form->setNombrecompleto($result[$i]['nombrecompleto']);
    			 $form->setNombrecicloEscolar($result[$i]['NombreCicloEscolar']);
    			 $form->setNombregrupo($result[$i]['NombreGrupo']);
    			 $form->setNombregrado($result[$i]['NombreGrado']);
    			 $form->setNombreseccion($result[$i]['NombreSeccion']);
    			 $form->setGradopuro($result[$i]['GradoPuro']);
    			 $form->setIdseccion($result[$i]['idseccion']);
    			 $form->setSeccion($result[$i]['seccion']);
    			 $form->setGrado($result[$i]['grado']);
    			 $form->setTiposeccion($result[$i]['TipoSeccion']);
    			 
    			 $form->setBajasolo($result[$i]['bajasolo']);
    			 $form->setDireccionbajada($result[$i]['direccionBajada']);
    			 $form->setPersonarecibe($result[$i]['personarecibe']);
    			 $form->setObservaciones($result[$i]['Observaciones']);
    			 $form->setDia($result[$i]['dia']);
    			 $form->save();
    		}
    	 }
    	}
    	$conn->close();
    	return "OK";
    }
    public static function cronUpdateCIECicloEscolares(){
    	
    	$conne = Doctrine_Manager::getInstance()->getConnection($GLOBALS['cie']);//cie
    	$sql = "select * FROM ListaCicloEscolar  ORDER BY nombre ASC ";
    	$ciclos = $conne->execute($sql);
    	$result=$ciclos->fetchAll(PDO::FETCH_ASSOC);
    	$conne->close();
    	
    	$conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['default']);
    	$query = "TRUNCATE TABLE ListaCicloEscolar";
    	$st = $conn->execute($query);
    	
        $consultasInstituto= new consultasInstituto(); 
        $count=sizeof($result);   
    	
    		for($i=0; $i<=sizeof($result); $i++){
    			if(isset($result[$i]) && $result[$i]['idcicloescolar']!=null){
    			
    				$form= new Listacicloescolar();    			
					$form ->setIdcicloescolar($result[$i]['idcicloescolar']);
					$form ->setFechainicio($result[$i]['fechainicio'] );
					$form ->setFechatermino($result[$i]['fechatermino'] );
					$form ->setEstatus($result[$i]['estatus']);
					$form ->setSeccion($result[$i]['seccion']);
					$form ->setNombre($result[$i]['nombre']);   
					$form ->setPrefijomatricula($result[$i]['prefijomatricula']);
					$form ->setIdseccion($result[$i]['idseccion']);  
	    
	    			$form->save();
    			}
    		}
    		
    	
    	$consultasInstituto->insertarCron('UpdateCIECicloEscolares-'.$count);
    	return "OK";
    }
    
    public static function cronUpdateCIEGrupos(){
    	
    	$conne = Doctrine_Manager::getInstance()->getConnection($GLOBALS['cie']);//cie
    	$campos = "select * FROM ListaGrupo";
    	$sql =$campos." ORDER BY nombre ASC; ";
    	$st = $conne->execute($sql);
    	$result = $st->fetchAll(PDO::FETCH_ASSOC);
    	$conne->close();
    	//echo "<pre>";print_r($result);die();
    	
    	$conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['default']);
    	//borrar tabla en CAJA B
    	$query = "TRUNCATE TABLE ListaGrupo";
    	$st = $conn->execute($query);
    
    	
    	$count=sizeof($result);
    	
    	$consultasInstituto= new consultasInstituto();
    	
    	//sleccionar registros de CIE
    
            
    		for($i=0; $i<=sizeof($result); $i++){
    		  if(isset($result[$i]) && $result[$i]['idgrupo']!=null){
    			$form= new Listagrupo();    			
    			$form->setIdgrupo($result[$i]['idgrupo']);       
				$form->setNombre($result[$i]['nombre']);        
				$form->setGrado($result[$i]['grado']);          
				$form->setCiclo($result[$i]['ciclo']);         
				$form->setProfesor($result[$i]['profesor']);       
				$form->setSeccion($result[$i]['seccion']);        
				$form->setIdgrado($result[$i]['idgrado']);        
				$form->setIdcuenta($result[$i]['idcuenta']);       
				$form->setIdcicloescolar($result[$i]['idcicloescolar']); 
				$form->setIdseccion($result[$i]['idseccion']);     
				$form->setOficial($result[$i]['oficial']);
    
    			$form->save();
    		 }
    		}
    	
    	
    	
    	$consultasInstituto->insertarCron('UpdateCIEGrupos-'.$count);
    
    	return "OK";
    }
    
    public static function getDatosAlumnoXIdTiket($idAlumno) {
    	$sql = "select ifnull(CONCAT(appat,' ',apmat,' ',nombre),' ') as nombre ,
           ifnull(CONCAT(ifnull(NombreGrado,' '),' ',ifnull(NombreGrupo,' ')),' ') as seccion
                  from ListaAlumnoB where idalumno =" . $idAlumno . " limit 0,1;";
    	$conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['instBD']); //nombre de mi conexion
    	$st = $conn->execute($sql);
    	return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
   /* public static function cronUpdateCIECicloEscolares(){
    	$conn = Doctrine_Manager::getInstance()->getConnection($GLOBALS['default']);
    	//borrar tabla en CAJA B
    	$query = "TRUNCATE TABLE ListaCicloEscolar";
    	$st = $conn->execute($query);
    
    	$conne = Doctrine_Manager::getInstance()->getConnection($GLOBALS['cie']);//cie
    	//contar registros en cie de  ListaAlumnoB ListaCicloEscolar ListaGrupo
    	$countCiclos = "select count(idcicloescolar) as total FROM ListaCicloEscolar ";
    	$st = $conne->execute($countCiclos);
    	$totalCieCiclos=$st->fetchAll(PDO::FETCH_ASSOC);
    	$totalCieCiclos=sizeof($totalCieCiclos>0)?$totalCieCiclos[0]['total']:0;
    	$offset=1;
    	$consultasInstituto= new consultasInstituto();
    	$count=0;
    	 
    	//sleccionar registros de CIE
    	while($offset<=$totalCieCiclos){
    
    		$campos = "select * FROM ListaCicloEscolar";
    		$sql =$campos." ORDER BY nombre ASC  limit " . 1000 . " offset  " . $offset . "  ;";
    		$st = $conne->execute($sql);
    		$result = $st->fetchAll(PDO::FETCH_ASSOC);
    
    		$count+=sizeof($result);
    		 
    		for($i=0; $i<=sizeof($result); $i++){
    			if(isset($result[$i]) && $result[$i]['idcicloescolar']!=null){
    				 
    				$form= new Listacicloescolar();
    				$form ->setIdcicloescolar($result[$i]['idcicloescolar']);
    				$form ->setFechainicio($result[$i]['fechainicio'] );
    				$form ->setFechatermino($result[$i]['fechatermino'] );
    				$form ->setEstatus($result[$i]['estatus']);
    				$form ->setSeccion($result[$i]['seccion']);
    				$form ->setNombre($result[$i]['nombre']);
    				$form ->setPrefijomatricula($result[$i]['prefijomatricula']);
    				$form ->setIdseccion($result[$i]['idseccion']);
    				 
    				$form->save();
    			}
    		}
    		$offset=$offset+1000;
    	}
    	$consultasInstituto->insertarCron('UpdateCIECicloEscolares-'.$count);
    	return "OK";
    }*/
}
