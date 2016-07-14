<?php

/**
 * acceso actions.
 *
 * @package    puntoveta
 * @subpackage acceso
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class consultasActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
      //echo "hola"; die();
     $this->setLayout('index');
   
  }
  public function executeGetCiclosEscolares(sfWebRequest $request) {
  	try {  		
  				
  			//trae los ciclos porgramados y activos
  			$ciclosEscolares = consultasInstituto::getCiclosEscolares();  			
  			return $this->sendJSON($ciclosEscolares);
  		
  	} catch (Doctrine_Exception $e) {
  		throw new sfException($e);
  	}
  }
  
  public function executeGetGradosByCiclo(sfWebRequest $request) {
  	try {
  		
  			// hace un select distict de los grados por cada ciclo
  			$idCiclo = $request->getParameter("idCiclo", 0);  			 
  			$listaGrados = consultasInstituto::getGradosByCiclo($idCiclo);  			
  			return $this->sendJSON($listaGrados);
  	
  	} catch (Doctrine_Exception $e) {
  		throw new sfException($e);
  	}
  }
  
  public function executeGetGruposByGrado(sfWebRequest $request) {
  	try {  		
  			//consigue los grupos por el nombre del grado y por el ciclo
  			$grado = $request->getParameter("grado", 0);
  			$idCiclo = $request->getParameter("idCiclo", 0);
  
  			$listaGrupos = consultasInstituto::getGruposByGrado($grado, $idCiclo);  			
  			return $this->sendJSON($listaGrupos);
  		
  	} catch (Doctrine_Exception $e) {
  		throw new sfException($e);
  	}
  }
  public function executeFiltrosAlumnos(sfWebRequest $request) {
  	try {
  		
  			$idCiclo = $request->getParameter("idCiclo", 0);
  			$idGrado = $request->getParameter("idGrado", 0);
  			$idgrupo = $request->getParameter("idGrupo", 0);
  			$alumno = $request->getParameter("alumno", 0); //busca por alumno se deben bloquear las demas opciones
  			 
  			$listaAlumnosQuery = consultasInstituto::getListaAlumnosFiltros($idCiclo, $idGrado, $idgrupo,$alumno);
  			//print_r($listaAlumnosQuery);die();
  			return $this->sendJSON($listaAlumnosQuery);
  	
  	} catch (Doctrine_Exception $e) {
  		throw new sfException($e);
  	}
  }
}
