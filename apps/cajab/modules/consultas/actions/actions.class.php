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
  		if ($request->isMethod(sfWebRequest::POST)) {  			
  			 
  			$ciclosEscolares = consultasInstituto::getCiclosEscolares();
  			return $this->sendJSON($ciclosEscolares);
  		}
  	} catch (Doctrine_Exception $e) {
  		throw new sfException($e);
  	}
  }
  
  public function executeGetGradosByCiclo(sfWebRequest $request) {
  	try {
  		if ($request->isMethod(sfWebRequest::POST)) {
  			$idCiclo = $request->getParameter("idCiclo", 0);
  			 
  			$listaGrados = consultasInstituto::getGradosByCiclo($idCiclo);
  			return $this->sendJSON($listaGrados);
  		}
  	} catch (Doctrine_Exception $e) {
  		throw new sfException($e);
  	}
  }
  
  public function executeGetGruposByGrado(sfWebRequest $request) {
  	try {
  		if ($request->isMethod(sfWebRequest::POST)) {
  			$idGrado = $request->getParameter("idGrado", 0);
  
  			$listaGrupos = consultasInstituto::getGruposByGrado($idSeccion, $idGrado, $idgrupo);
  			return $this->sendJSON($listaGrupos);
  		}
  	} catch (Doctrine_Exception $e) {
  		throw new sfException($e);
  	}
  }
  public function executeFiltrosAlumnos(sfWebRequest $request) {
  	try {
  		if ($request->isMethod(sfWebRequest::POST)) {
  			$idCiclo = $request->getParameter("idCiclo", 0);
  			$idGrado = $request->getParameter("idGrado", 0);
  			$idgrupo = $request->getParameter("idGrupo", 0);
  			 
  			$listaAlumnosQuery = consultasInstituto::getListaAlumnosFiltros($idCiclo, $idGrado, $idgrupo);
  			return $this->sendJSON($listaAlumnosQuery);
  		}
  	} catch (Doctrine_Exception $e) {
  		throw new sfException($e);
  	}
  }
}
