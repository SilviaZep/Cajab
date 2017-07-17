<?php

/**
 * parametros actions.
 *
 * @package    skindepile
 * @subpackage parametros
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class parametrosActions extends baseCajabProjectActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {   
       $this->setLayout('menu');
     try {
           $this->empleados=consultasBd::getUsuarios();     //se envia la lista de inscritos en JSON
		   //$this->newALumnos=consultasBd::getAlumnosInstituto();
		  // print_r($this->newALumnos);die();
         } catch (Doctrine_Exception $e) {
      throw new Exception($e);
    }
       $this->setTemplate('index');
    }
	
		
	public function executeAgregarEmpleado(sfWebRequest $request) {

        try {   
              $reponse="";
            if ($request->isXmlHttpRequest()) {
                $this->nombre = $request->getParameter("nombre", 0);
				$this->rol = $request->getParameter("rol", 0);
                $this->usuario = $request->getParameter("usuario", 0);
                $this->pass = $request->getParameter("pass", 0);
                  
			     	$user = Doctrine::getTable('Usuario')->findOneBy('usuario', $this->usuario); 
				
					if(isset($user) && !empty($user))
				   {			   
					   
						$response="El Usuario: ".$this->usuario." ya existe, Por modifica el campo usuario";
				   }  
				else{
					
										
					$form_user = new Usuario(); 
					$form_user->setNombreCompleto($this->nombre);
					$form_user->setUsuario($this->usuario);
					$form_user->setPassword($this->pass);
					$form_user->setFechaCreacion(date('Y-m-d'));					
					$form_user->setIdEmpleado(1);
					$form_user->setRol($this->rol);
					$form_user->setEstatus(1); 
					$form_user->save();
					
					$response="OK";
				}		   
            } else {               
				echo $form_user;
                die();
               
                
            }
            return $this->sendJSON($response);
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
        //$this->setTemplate('clientes');
    }
	
	public function executeNuevaPassword(sfWebRequest $request) {

        try {   
              $reponse="";
            if ($request->isXmlHttpRequest()) {
				
                $this->id = $request->getParameter("id2", 0); 
			
                $this->pass = $request->getParameter("pass1", 0);             
			   	$form = Doctrine::getTable('Usuario')->find($this->id);  
				$form->setPassword($this->pass);
				$form->save();
                
            } else {
            
				echo $form_user;
                die();
               
                
            }
            return $this->sendJSON("OK");
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
        //$this->setTemplate('clientes');
    }
	
	public function executeDetalleEmpleado(sfWebRequest $request) {
        try {
                $id = $request->getParameter("id");
                $this->empleado = Doctrine::getTable('Usuario')->find($id);  
                
                return $this->sendJSON($this->empleado);
          
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }
 public function executeActualizarEmpleado(sfWebRequest $request) {
       try {   
              $reponse="";
            if ($request->isXmlHttpRequest()) {
                $this->nombre = $request->getParameter("nombre1", 0);
				$this->id = $request->getParameter("id1", 0);               
				$this->rol = $request->getParameter("rol1", 0);
                $this->usuario = $request->getParameter("usuario1", 0);
                $this->pass = $request->getParameter("pass1", 0);              
				$this->estatusCuenta = $request->getParameter("estatusCuenta", 0);	
				
				$form_user = Doctrine::getTable('Usuario')->find($this->id); 
                
				$form_user->setNombreCompleto($this->nombre);
				$form_user->setUsuario($this->usuario);
				$form_user->setRol($this->rol);
                $form_user->setEstatus($this->estatusCuenta); 			   
				$form_user->save();
                
            } else {
                echo $form;
				echo $form_user;
                die();
               
                
            }
            return $this->sendJSON("OK");
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
 }
 
 
 	public function executeCategoriasList(sfWebRequest $request)
  {   
       $this->setLayout('menu');
     try {
          //$this->categorias=consultasBd::getListaAlumnosFiltrosTest();     //se envia la lista de inscritos en JSON
          //print_r( $this->categorias);die();
     	   $this->categorias=consultasBd::getCategoriasList();
          } catch (Doctrine_Exception $e) {
      throw new Exception($e);
    }
       $this->setTemplate('categorias');
    }

	 public function executeAgregarCategoria(sfWebRequest $request) {

        try {   
              $reponse="";
            if ($request->isXmlHttpRequest()) {
                $this->nombre = $request->getParameter("nombre", 0);
				$this->des = $request->getParameter("des", 0);
				$this->tipo = $request->getParameter("tipo", 0);
               
                $form = new CategoriaServicio();                                             

                    $form->setCategoria($this->nombre);
					$form->setDescripcion($this->des);
					$form->setTipo($this->tipo);
                    $form->setEstatus(1);                   
                  
                    $form->save();
                                 
                
            } else {
                echo $form;
                die();
               
                
            }
            return $this->sendJSON("OK");
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
        //$this->setTemplate('clientes');
    }
	
	 public function executeModificarCategoria(sfWebRequest $request) {

        try {   
              $reponse="";
            if ($request->isXmlHttpRequest()) {
                $this->nombre = $request->getParameter("nombre1", 0);
				$this->id = $request->getParameter("id1", 0);
				$this->estatus = $request->getParameter("estatus", 0); 
				$this->des = $request->getParameter("des1", 0);
				$this->tipo = $request->getParameter("tipo1", 0);				
                                                           
				$form = Doctrine::getTable('CategoriaServicio')->find($this->id);   
				$form->setCategoria($this->nombre);
				$form->setDescripcion($this->des);
			    $form->setTipo($this->tipo);
				$form->setEstatus($this->estatus);                   
                $form->save();
                
            } else {
                echo $form;
                die();
               
                
            }
            return $this->sendJSON("OK");
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
        //$this->setTemplate('clientes');
    }
}
