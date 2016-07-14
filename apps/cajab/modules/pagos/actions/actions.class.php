<?php

/**
 * pagos actions.
 *
 * @package    puntoveta
 * @subpackage pagos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pagosActions extends baseCajabProjectActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        //$this->forward('default', 'module');
    }

    public function executePagarServicio(sfWebRequest $request) {
        $this->setTemplate('pagarServicio');
    }

    public function executePagarServicioCliente(sfWebRequest $request) {
        $this->setTemplate('pagarServicioCliente');
    }

    public function executeServiciosPagandoAlumno(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {
                date_default_timezone_set('America/Mexico_City');
                $idAlumno = $request->getParameter("idAlumno", 0);
                $listaServicios = consultasBd::getServiciosPagandoAlumno((int) $idAlumno);
                $r = array("mensaje" => "Ok", "listaServicios" => $listaServicios); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "Error Desconocido", "valor" => "0"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    public function executePagoServiciosAlumno(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');
                $fechaActual = new DateTime();

                $idAlumno = $request->getParameter("idAlumno", 0);
                $idServicios = $request->getParameter("idServicios", 0);
                $montosPagara = $request->getParameter("montosPagara", 0);
                $formaPagos = $request->getParameter("formaPagos", 0);




                if (!empty($idServicios)) {
                    $vecServicios = explode(",", $idServicios);
                    $vecMontosPagara = explode(",", $montosPagara);
                    $vecFormaPagos = explode(",", $formaPagos);
                    $max = (sizeof($vecServicios) - 1); //agarra uno de mas   

                    for ($i = 0; $i < $max; $i++) {
                        $instServicioPago = new ServicioPago();
                        $instServicioPago->setIdServicio((int) $vecServicios[$i]);
                        $instServicioPago->setTipoCliente(1); //1.- Alumno; 2.- Cliente Externo
                        $instServicioPago->setIdAlumno((int) $idAlumno);
                        $instServicioPago->setFechaPago($fechaActual->format('Y-m-d H:i:s'));
                        $instServicioPago->setUsuarioRegistro($this->getUser()->getUserId());
                        $instServicioPago->setFechaRegistro($fechaActual->format('Y-m-d H:i:s'));
                        $instServicioPago->setMonto((double) $vecMontosPagara[$i]);
                        $instServicioPago->setTipoPago(1); //1.- ABONO 2.-DEVOLUCION                        
                        $instServicioPago->setFormaPago($vecFormaPagos[$i]);
                        $instServicioPago->save();
                    }
                    for ($i = 0; $i < $max; $i++) {
                        $resQ = consultasBd::getActualizarEstatusServicioCliente((int) $vecServicios[$i]);
                    }
                }

                $r = array("mensaje" => "Pagos Realizados correctamente"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "Error Desconocido", "valor" => "0"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    public function executeDetallesPagosServicioCliente(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                $idServicioCliente = $request->getParameter("idServicioCliente", 0);
                $listaPagos = consultasBd::getDetallesPagosServicioCliente((int) $idServicioCliente);
                $r = array("mensaje" => "Ok", "listaPagos" => $listaPagos); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "Error Desconocido", "valor" => "0"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    //+*************Pagos Cliente

    public function executeServiciosPagandoCliente(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {
                date_default_timezone_set('America/Mexico_City');
                $idCliente = $request->getParameter("idCliente", 0);
                $listaServicios = consultasBd::getServiciosPagandoCliente((int) $idCliente);
                $r = array("mensaje" => "Ok", "listaServicios" => $listaServicios); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "Error Desconocido", "valor" => "0"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    public function executePagoServiciosCliente(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');
                $fechaActual = new DateTime();

                $idCliente = $request->getParameter("idCliente", 0);
                $idServicios = $request->getParameter("idServicios", 0);
                $montosPagara = $request->getParameter("montosPagara", 0);
                $formaPagos = $request->getParameter("formaPagos", 0);




                if (!empty($idServicios)) {
                    $vecServicios = explode(",", $idServicios);
                    $vecMontosPagara = explode(",", $montosPagara);
                    $vecFormaPagos = explode(",", $formaPagos);
                    $max = (sizeof($vecServicios) - 1); //agarra uno de mas   

                    for ($i = 0; $i < $max; $i++) {
                        $instServicioPago = new ServicioPago();
                        $instServicioPago->setIdServicio((int) $vecServicios[$i]);
                        $instServicioPago->setTipoCliente(2); //1.- Alumno; 2.- Cliente Externo
                        $instServicioPago->setIdCliente((int) $idCliente);
                        $instServicioPago->setFechaPago($fechaActual->format('Y-m-d H:i:s'));
                        $instServicioPago->setUsuarioRegistro($this->getUser()->getUserId());
                        $instServicioPago->setFechaRegistro($fechaActual->format('Y-m-d H:i:s'));
                        $instServicioPago->setMonto((double) $vecMontosPagara[$i]);
                        $instServicioPago->setTipoPago(1); //1.- ABONO 2.-DEVOLUCION                        
                        $instServicioPago->setFormaPago($vecFormaPagos[$i]);
                        $instServicioPago->save();
                    }
                    for ($i = 0; $i < $max; $i++) {
                        $resQ = consultasBd::getActualizarEstatusServicioCliente((int) $vecServicios[$i]);
                    }
                }

                $r = array("mensaje" => "Pagos Realizados correctamente"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "Error Desconocido", "valor" => "0"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

}
