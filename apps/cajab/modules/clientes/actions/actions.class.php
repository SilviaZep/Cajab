<?php

/**
 * general actions.
 *
 * @package    skindepile
 * @subpackage general
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class clientesActions extends baseCajabProjectActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $this->setLayout('menu'); 
	    $this->clientes = consultasBd::getClientesExternosList(); 
              
        $this->setTemplate('index');
    }


    public function executeAgregarNuevoCliente(sfWebRequest $request) {

        try {

              $reponse="";
            if ($request->isXmlHttpRequest()) {
                $this->nombre = $request->getParameter("nombre", 0);
                $this->domicilio = $request->getParameter("domicilio", 0);
                $this->telCasa = $request->getParameter("tel", 0);
                $this->email = $request->getParameter("correo", 0);
              
				$clientesForm = new ClientesExternos();										  
				
				$clientesForm->setNombre($this->nombre); 
				$clientesForm->setDireccion($this->domicilio);
				$clientesForm->setTelefono($this->telCasa);
				$clientesForm->setEmail($this->email);                  
				$clientesForm->save();
                                 
                
            } else {
                echo $clientesForm;
                die();
               
                
            }
            return $this->sendJSON("OK");
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
       
    }
 
    
    public function executeClientesModificar(sfWebRequest $request) {

        try {

              $reponse="";
            if ($request->isXmlHttpRequest()) {
				$id = $request->getParameter("id", 0);
                $this->nombre = $request->getParameter("nombre", 0);
                $this->domicilio = $request->getParameter("domicilio", 0);
                $this->tel = $request->getParameter("tel", 0);
                $this->email = $request->getParameter("correo", 0);
                        
				$clientesForm= Doctrine::getTable('ClientesExternos')->find($id); 
				$clientesForm->setNombre($this->nombre); 
				$clientesForm->setDireccion($this->domicilio);
				$clientesForm->setTelefono($this->tel);
				$clientesForm->setEmail($this->email);                  
				$clientesForm->save();
                                 
                
            } else {
                echo $this->clientes;
                die();
               
                
            }
            return $this->sendJSON("OK");
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
        //$this->setTemplate('clientes');
    }
    
 
}
