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
  
  public function actualizarListaAlumnoBEscolares(sfWebRequest $request) {
  	try {  
  		$update = consultasInstituto::cronUpdateCIEAlumnos();
  		
  		return $this->sendJSON($update);
  	} catch (Doctrine_Exception $e) {
  		throw new sfException($e);
  	}
  }
  
  public function actualizarListagrupo(sfWebRequest $request) {
  	try {
  		$update = consultasInstituto::cronUpdateCIEGrupos();
  
  		return $this->sendJSON($update);
  	} catch (Doctrine_Exception $e) {
  		throw new sfException($e);
  	}
  }
  
  public function actualizarListacicloescolar(sfWebRequest $request) {
  	try {
  		$update = consultasInstituto::cronUpdateCIECicloEscolares();
  
  		return $this->sendJSON($update);
  	} catch (Doctrine_Exception $e) {
  		throw new sfException($e);
  	}
  }
}
