<?php

/**
 * crones actions.
 *
 * @package    puntoveta
 * @subpackage crones
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cronesActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //$this->forward('default', 'module');
  }
  
  public function executeActualizarListaAlumnoB(sfWebRequest $request) {
  	try {  
  		$update = consultasInstituto::cronUpdateCIEAlumnos();
  		die();
  		//return $update;
  	} catch (Doctrine_Exception $e) {
  		throw new sfException($e);
  	}
  }
  
  public function executeActualizarListagrupo(sfWebRequest $request) {
  	try {
  		$update = consultasInstituto::cronUpdateCIEGrupos();
        die();
  		
  	} catch (Doctrine_Exception $e) {
  		throw new sfException($e);
  	}
  }
  
  public function executeActualizarListacicloescolar(sfWebRequest $request) {
  	try {
  		$update = consultasInstituto::cronUpdateCIECicloEscolares();
         die();
  		
  	} catch (Doctrine_Exception $e) {
  		throw new sfException($e);
  	}
  }
}
