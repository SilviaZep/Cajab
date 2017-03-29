<?php

/**
 * egresos actions.
 *
 * @package    puntoveta
 * @subpackage egresos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class egresosActions extends baseCajabProjectActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {  
   try{
	  $this->setLayout('menu'); 
	  $this->egresos = consultasBd::getEgresossList();
	  $this->proveedores = consultasBd::getProveedoresList();
	  $this->servicios = consultasBd::getServiciosList();	  
	  
	 } catch (Doctrine_Exception $e) {
				throw new sfException($e);
			}	  
		//$this->forward('default', 'module');
	 }
  
  public function executeProveedores(sfWebRequest $request)
  {
	  
	  $this->setLayout('menu'); 
    $this->proveedores = consultasBd::getProveedoresList(); 
              
    $this->setTemplate('proveedores');
  }
  
   public function executeImprimirEgresos(sfWebRequest $request)
  {
	  
	   $pdf = new \FPDF ();
		$pdf->AddPage ('L');		
		$pdf->Ln ( 10 );
		$pdf->SetFont ( 'Arial', 'B', 16 );
		$pdf->SetTextColor ( 88, 89, 91 );
		$pdf->Cell ( 190, 10, utf8_decode ( 'Egresos' ), 0, 1, 'R' );
		$pdf->Ln ( 8 );			
		$egresos = consultasBd::getEgresossList();
		$pdf->SetFont ( 'Arial', 'B', 11 );
		$pdf->SetTextColor ( 255, 255, 255 );
		$pdf->SetFillColor ( 136, 138, 140 );
		$pdf->Cell ( 60, 8, "Servicio", 'B', 0, 'L', true );
		$pdf->Cell ( 45, 8, "Proveedor", 'B', 0, 'C', true );
		$pdf->Cell ( 50, 8, "Concepto de Cobro",'B', 0, 'C', true );
		$pdf->Cell ( 20, 8, "Fecha", 'B', 0, 'C', true );
		$pdf->Cell ( 22, 8, "Tipo Pago", 'B', 0, 'C', true );
		$pdf->Cell ( 28, 8, "#Factura", 'B', 0, 'C', true );
		$pdf->Cell ( 29, 8, "Observaciones", 'B', 0, 'C', true );
		$pdf->Cell ( 30, 8, "Monto", 'B', 0, 'C', true );
		$pdf->Ln ( 8 );
		//print_r($this->egresos);die();
		$pdf->SetFont ( 'Arial', '', 7 );
		$pdf->SetTextColor ( 88, 89, 91 );
		$sum=0;
		for($i=0; $i<sizeof($egresos); $i++){
			$tipo=($egresos[$i]['tipo_pago']==1)?'Adeudo':'Liquidacion';
			$pdf->Cell ( 60, 8, $egresos[$i]['servicio'], 'B', 0, 'L' );
			$pdf->Cell ( 45, 8, $egresos[$i]['proveedor'], 'B', 0, 'L' );
			$pdf->Cell ( 50, 8, $egresos [$i]['concepto'], 'B', 0, 'L' );
			$pdf->Cell ( 20, 8, $egresos [$i]['fecha_registro'], 'B', 0, 'L' );
			$pdf->Cell ( 22, 8, $tipo, 'B', 0, 'L' );
			$pdf->Cell ( 28, 8, $egresos [$i]['referencia'], 'B', 0, 'L' );
			$pdf->Cell ( 29, 8, $egresos [$i]['observaciones'], 'B', 0, 'L' );
			$pdf->Cell ( 30, 8, $egresos [$i]['cantidad'], 'B', 0, 'R' );
			$sum=$sum+(int)$egresos [$i]['cantidad'];
			$pdf->Ln ( 8 );
		}
		$pdf->Cell ( 60, 8, '', 'B', 0, 'L' );
		$pdf->Cell ( 45, 8, '', 'B', 0, 'L' );
		$pdf->Cell ( 50, 8, '', 'B', 0, 'L' );
		$pdf->Cell ( 20, 8, '', 'B', 0, 'L' );
		$pdf->Cell ( 22, 8, '', 'B', 0, 'L' );
		$pdf->Cell ( 28, 8, '', 'B', 0, 'L' );
		$pdf->Cell ( 29, 8, 'Total', 'B', 0, 'L');
		$pdf->Cell ( 30, 8, '$'.$sum, 'B', 0, 'R' );
		$response = new sfWebResponse ( $pdf->Output () );
		$response->headers->set ( 'Content-Type', 'application/pdf' );
		return $response;
  } 
     public function executeExcelEgresos(sfWebRequest $request)
  {
	  
	   $pdf = new \FPDF ();
		$pdf->AddPage ();		
		$pdf->Ln ( 10 );
		$pdf->SetFont ( 'Arial', 'B', 18 );
		$pdf->SetTextColor ( 25, 47, 98 );
		$pdf->Cell ( 190, 10, utf8_decode ( 'MSDS Binder' ), 0, 1, 'R' );
		$pdf->Ln ( 8 );			
		
		$response = new sfWebResponse ( $pdf->Output () );
		$response->headers->set ( 'Content-Type', 'application/pdf' );
		return $response;
  }
  public function executeAgregarNuevoProveedor(sfWebRequest $request) {

        try {

              $reponse="";
            if ($request->isXmlHttpRequest()) {
                $this->nombre = $request->getParameter("nombre", 0);
                $this->domicilio = $request->getParameter("domicilio", 0);
                $this->tel = $request->getParameter("tel", 0);
                $this->email = $request->getParameter("correo", 0);
              
				$form = new Proveedores();										  
				
				$form->setNombre($this->nombre); 
				$form->setDireccion($this->domicilio);
				$form->setTelefono($this->tel);
				$form->setEmail($this->email);                  
				$form->save();
                                 
                
            } else {
                echo $form;
                die();
               
                
            }
            return $this->sendJSON("OK");
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
       
    }
 
    
    public function executeProveedorModificar(sfWebRequest $request) {

        try {

              $reponse="";
            if ($request->isXmlHttpRequest()) {
				
                $id = $request->getParameter("id", 0);
                $this->nombre = $request->getParameter("nombre", 0);
                $this->domicilio = $request->getParameter("domicilio", 0);
                $this->tel = $request->getParameter("tel", 0);
                $this->email = $request->getParameter("correo", 0);
                        
				$form= Doctrine::getTable('Proveedores')->find($id); 
				$form->setNombre($this->nombre); 
				$form->setDireccion($this->domicilio);
				$form->setTelefono($this->tel);
				$form->setEmail($this->email);                  
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
  
  public function executeAgregarEgreso(sfWebRequest $request) {

        try {

              $reponse="";
            if ($request->isXmlHttpRequest()) {
                $idServicio = $request->getParameter("servicio", 0);
                $idProveedor = $request->getParameter("proveedor", 0);
                $idConcepto = $request->getParameter("concepto", 0);
                $referencia = $request->getParameter("referencia", 0);
				$cantidad = $request->getParameter("cantidad", 0);
				$tipo = $request->getParameter("tipo", 0);
				$observaciones = $request->getParameter("observaciones", 0);
              
				$form = new Egresos();										  
				
				$form->setIdServicio($idServicio); 
				$form->setIdProveedor($idProveedor);
				$form->setIdConcepto($idConcepto);
				$form->setFechaRegistro(date('Y-m-d'));  
				$form->setCantidad($cantidad); 
				$form->setReferencia($referencia); 
				$form->setTipoPago($tipo); 
			    $form->setObservaciones($observaciones); 
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
       
    }
 public function executeCatalogoConceptosPago(sfWebRequest $request) {
    try {
		
        if ($request->isXmlHttpRequest()) {
            $id = $request->getParameter("id", 0);
			$this->conceptos = consultasBd::getConceptoPagoList($id);	
           
		}
		 return $this->sendJSON($this->conceptos);
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
		
    }

//conceptos de cobro
public function executeAgregarConceptos(sfWebRequest $request) {
    try {
			
              $reponse="";
            if ($request->isXmlHttpRequest()) {
                $idServicio = $request->getParameter("idServicio", 0);
		
                $concepto = $request->getParameter("concepto", 0);
                             
				$form = new ConceptosCobro();										  
				
				$form->setIdServicio($idServicio); 
				$form->setConcepto($concepto);
				$form->setFechaRegistro(date('Y-m-d')); 
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
       
    }
public function executeGetConceptosList(sfWebRequest $request) {
    try {
		$this->setLayout('menu');       
			
	        $this->servicios = consultasBd::getServiciosList();	  
			$this->conceptos = consultasBd::getConceptoList();			
		 
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
		$this->setTemplate('conceptos');
    }
public function executeConceptoModificar(sfWebRequest $request) {
    try {
			
              $reponse="";
            if ($request->isXmlHttpRequest()) {
                $id = $request->getParameter("id1", 0);
				
                $concepto = $request->getParameter("concepto1", 0);
				$estatus = $request->getParameter("estatus", 0);
                             
				$form= Doctrine::getTable('ConceptosCobro')->find($id); 
				
				$form->setConcepto($concepto);
				$form->setEstatus($estatus); 
				
				$form->save();                                 
                
            } else {
                echo $form;
                die();
               
                
            }
            return $this->sendJSON("OK");
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
       
    }
}
