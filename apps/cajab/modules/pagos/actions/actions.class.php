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

                for ($i = 0; $i < sizeof($listaServicios); $i ++) {
                    $vecNombreAlumno = consultasInstituto::getAlumnoXId($listaServicios[$i]['id_alumno']);
                    $listaServicios[$i]['cliente'] = $vecNombreAlumno[0]['nombre'];
                }



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
                    $consecutivo = consultasBd::getConsecutivoPago();
                    $consecutivo = $consecutivo[0]['consecutivo'];

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
                        $instServicioPago->setIdPago($consecutivo); //1.- ABONO 2.-DEVOLUCION   
                        $instServicioPago->save();
                    }
                    for ($i = 0; $i < $max; $i++) {
                        $resQ = consultasBd::getActualizarEstatusServicioCliente((int) $vecServicios[$i]);
                    }
                }

                $r = array("mensaje" => "Pagos Realizados correctamente", "idPago" => $consecutivo); //a partir de php 5.4 es con corchetes[]
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
                    $consecutivo = consultasBd::getConsecutivoPago();
                    $consecutivo = $consecutivo[0]['consecutivo'];

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
                        $instServicioPago->setIdPago($consecutivo); //1.- ABONO 2.-DEVOLUCION   
                        $instServicioPago->save();
                    }
                    for ($i = 0; $i < $max; $i++) {
                        $resQ = consultasBd::getActualizarEstatusServicioCliente((int) $vecServicios[$i]);
                    }
                }

                $r = array("mensaje" => "Pagos Realizados correctamente","idPago" => $consecutivo); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "Error Desconocido", "valor" => "0"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    public function executeImprimirTicket(sfWebRequest $request) {
        date_default_timezone_set('America/Mexico_City');

        //$pagos= $request->getParameter("pagos", 0);    
        //$alumno= $request->getParameter("alumno", 0);
        $no_pago = $request->getParameter("idPago", 0);

        $total = 0;


        $pagos = consultasBd::getTicketPago((int) $no_pago);
        for ($i = 0; $i < sizeof($pagos); $i ++) {
            if ($pagos[$i]['tipo_descripcion'] == "Alumno") {
                $nombreAlumno = consultasInstituto::getAlumnoXId($pagos[$i]['id_alumno']);
                $pagos[$i]['cliente'] = $nombreAlumno[0]['nombre'];
            }
        }


        if (isset($pagos) && sizeof($pagos) > 0) {
            $pdf = new FPDF ();
            $pdf->AddPage();
            $pdf->Ln(6);
            $pdf->SetFont('Arial', '', 14);
            $pdf->SetTextColor(88, 89, 91);
            $pdf->Cell(0, 8, utf8_decode('RECIBO POR CUOTA DE TERCEROS'), 'B', 0, 'C');
            $pdf->Ln(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetTextColor(88, 89, 91);
            $pdf->Cell(0, 7, utf8_decode('Recibo Provisional'), 0, 0, 'R');
            $pdf->Ln(7);
            $pdf->Cell(160, 7, "", 0, 0, 'R');
            $pdf->Cell(30, 7, utf8_decode('NO.' . $pagos[0]['id_pago']), 1, 0, 'L');
            $pdf->Ln(7);
            $pdf->Cell(0, 7, utf8_decode($pagos[0]['fecha_pago']), 0, 0, 'R');
            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetTextColor(88, 89, 91);
            $pdf->Cell(15, 8, utf8_decode('Nombre:'), 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(175, 6, utf8_decode($pagos[0]['cliente']), 1, 0, 'L');
            $pdf->Ln(8);

            $pdf->Cell(60, 8, utf8_decode('Servicio'), 'B', 0, 'L');
            $pdf->Cell(90, 8, utf8_decode('Monto'), 'B', 0, 'L');
            $pdf->Cell(40, 8, utf8_decode('Forma de Pago'), 'B', 0, 'L');
            $pdf->Ln(8);
            $pdf->SetFont('Arial', '', 10);

            for ($i = 0; $i < sizeof($pagos); $i ++) {
                $pdf->Cell(60, 8, utf8_decode($pagos[$i]['nombre_servicio']), 0, 0, 'L');
                $pdf->Cell(90, 8, utf8_decode('$' . $pagos[$i]['monto']), 0, 0, 'L');
                $pdf->Cell(40, 8, utf8_decode($pagos[$i]['forma_pago']), 0, 0, 'L');
                $pdf->Ln(8);
                $total+=(int) $pagos[$i]['monto'];
            }


            $pdf->Ln(8);
            //   $pdf->Cell(160, 8, utf8_decode('Sub-Total: ' . "$"), 0, 0, 'R');
            $pdf->Ln(8);
            //   $pdf->Cell(160, 8, utf8_decode('IVA: ' . "$"), 0, 0, 'R');
            $pdf->Ln(8);
            $pdf->Cell(160, 8, utf8_decode('Total: ' . "$" . $total), 0, 0, 'R');
            $pdf->Ln(8);
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            $pdf->Rect(10, $y - 22, 90, 40, 'D');
            $pdf->SetXY(10, $y - 22);
            $pdf->Cell(15, 6, 'Sello Caja', 0, 1);

            $response = new sfWebResponse($pdf->Output());
            $response->headers->set('Content-Type', 'application/pdf');
            return $response;
        } else {
            return "";
        }
    }

}
