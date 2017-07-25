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

    public function executeMovimientosCaja(sfWebRequest $request) {
        $this->setTemplate('movimientosCaja');
    }

    public function executeEstadoCuentaServicio(sfWebRequest $request) {
        $this->setTemplate('estadoCuentaXServicio');
    }

    public function executeServiciosPagandoAlumno(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {
                date_default_timezone_set('America/Mexico_City');
                $idAlumno = $request->getParameter("idAlumno", 0);
                $listaServicios = consultasBd::getServiciosPagandoAlumno((int) $idAlumno);

                for ($i = 0; $i < sizeof($listaServicios); $i ++) {
                    $vecNombreAlumno = consultasInstituto::getDatosCompletosAlumnoXId($listaServicios[$i]['id_alumno']);
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
                $montosDescuento = $request->getParameter("montosDescuento", 0);
                $formaPagos = $request->getParameter("formaPagos", 0);




                if (!empty($idServicios)) {
                    $vecServicios = explode(",", $idServicios);
                    $vecMontosPagara = explode(",", $montosPagara);
                    $vecMontosDescuento = explode(",", $montosDescuento);
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
                        $instServicioPago->setDescuento((double) $vecMontosDescuento[$i]);
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
                $montosDescuento = $request->getParameter("montosDescuento", 0);
                $formaPagos = $request->getParameter("formaPagos", 0);




                if (!empty($idServicios)) {
                    $vecServicios = explode(",", $idServicios);
                    $vecMontosPagara = explode(",", $montosPagara);
                    $vecMontosDescuento = explode(",", $montosDescuento);
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
                        $instServicioPago->setDescuento((double) $vecMontosDescuento[$i]);
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

    public function executeImprimirTicket(sfWebRequest $request) {
        date_default_timezone_set('America/Mexico_City');

        //$pagos= $request->getParameter("pagos", 0);    
        //$alumno= $request->getParameter("alumno", 0);
        $no_pago = $request->getParameter("idPago", 0);
        $totalIngresado = $request->getParameter("totalIngresado", 0);

        $total = 0;


        $pagos = consultasBd::getTicketPago((int) $no_pago);
        for ($i = 0; $i < sizeof($pagos); $i ++) {
            if ($pagos[$i]['tipo_descripcion'] == "Alumno") {
                $nombreAlumno = consultasInstituto::getDatosAlumnoXId($pagos[$i]['id_alumno']);
                $pagos[$i]['cliente'] = $nombreAlumno[0]['nombre'];
            }
        }


        if (isset($pagos) && sizeof($pagos) > 0) {
            $pdf = new FPDF ();
            $pdf->AddPage();

            /*     $pdf->Ln(6);
              $pdf->SetFont('Arial', '', 11);
              $pdf->SetTextColor(88, 89, 91);
              $pdf->Cell(0, 8, utf8_decode('RECIBO POR CUOTA DE TERCEROS'), 'B', 0, 'C'); */



            // $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetTextColor(88, 89, 91);
            $pdf->Cell(80, 6, utf8_decode('RECIBO POR CUOTA DE TERCEROS:'), 1, 0, 'L');
            $pdf->Cell(10, 8, utf8_decode(' '), 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(30, 6, utf8_decode('NO:  ' . $pagos[0]['id_pago']), 1, 0, 'L');
            $pdf->Cell(10, 8, utf8_decode(' '), 0, 0, 'L');
            $pdf->Cell(60, 6, utf8_decode('Fecha Pago: ' . $pagos[0]['fecha_pago']), 1, 0, 'L');
            $pdf->Ln(8);


            /*    $pdf->SetFont('Arial', '', 9);
              $pdf->SetTextColor(88, 89, 91);
              $pdf->Cell(30, 8, utf8_decode('Recibo Provisional'), 0, 0, 'R');
              $pdf->Ln(7);
              $pdf->Cell(60, 7, "", 0, 0, 'R');
              $pdf->Cell(40, 5, utf8_decode('NO.' . $pagos[0]['id_pago']), 1, 0, 'L');
              $pdf->Ln(7);
              $pdf->Cell(175, 6, utf8_decode($pagos[0]['fecha_pago']), 0, 0, 'R');
              $pdf->Ln(10); */
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetTextColor(88, 89, 91);
            $pdf->Cell(15, 6, utf8_decode('Nombre:'), 1, 0, 'L');
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(175, 6, utf8_decode($pagos[0]['cliente']), 1, 0, 'L');
            $pdf->Ln(8);

            $pdf->Cell(110, 8, utf8_decode('Servicio'), 'B', 0, 'L');
            $pdf->Cell(30, 8, utf8_decode('Monto'), 'B', 0, 'L');
            $pdf->Cell(30, 8, utf8_decode('Descuento'), 'B', 0, 'L');
            $pdf->Cell(35, 8, utf8_decode('Forma de Pago'), 'B', 0, 'L');
            $pdf->Ln(8);
            $pdf->SetFont('Arial', '', 8);


            $subTotal = 0;
            $decuentoTotal = 0;

            for ($i = 0; $i < sizeof($pagos); $i ++) {
                $ts = strlen($pagos[$i]['nombre_servicio']);
                if ($ts > 45) {
                    $pagos[$i]['nombre_servicio'] = substr($pagos[$i]['nombre_servicio'], 0, 45);
                }


                $pdf->Cell(90, 6, utf8_decode($pagos[$i]['nombre_servicio']), 0, 0, 'L');
                $pdf->Cell(30, 6, utf8_decode('$' . $pagos[$i]['monto']), 0, 0, 'R');
                $pdf->Cell(30, 6, utf8_decode('$' . $pagos[$i]['descuento']), 0, 0, 'R');
                $pdf->Cell(35, 6, utf8_decode($pagos[$i]['forma_pago']), 0, 0, 'R');
                $pdf->Ln(6);
                $total+=(double) $pagos[$i]['monto'];
                $subTotal +=(double) $pagos[$i]['monto'] + (double) $pagos[$i]['descuento'];
                $decuentoTotal+=(double) $pagos[$i]['descuento'];
            }
            $importeLetra = $this->numtoletras($total);


            $pdf->Ln(8);
            //   $pdf->Cell(160, 8, utf8_decode('Sub-Total: ' . "$"), 0, 0, 'R');
            //  $pdf->Ln(8);
            //   $pdf->Cell(160, 8, utf8_decode('IVA: ' . "$"), 0, 0, 'R');
            //  $pdf->Ln(8);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(130, 8, "", 0, 0, 'L');
            $pdf->Cell(30, 8, utf8_decode('SubTotal: '), 1, 0, 'L');
            $pdf->Cell(20, 8, utf8_decode("$" . $subTotal), 1, 0, 'R');
            $pdf->Ln(8);
            $pdf->Cell(130, 8, "", 0, 0, 'L');
            $pdf->Cell(30, 8, utf8_decode('Descuento: '), 1, 0, 'L');
            $pdf->Cell(20, 8, utf8_decode("$" . $decuentoTotal), 1, 0, 'R');
            $pdf->Ln(8);
            //  $pdf->Cell(10, 8, "", 0, 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(30, 8, utf8_decode('Importe con letra:'), 1, 0, 'L');
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(100, 8, utf8_decode($importeLetra), 1, 0, 'L');
            $pdf->Cell(30, 8, utf8_decode('Total: '), 1, 0, 'L');
            $pdf->Cell(20, 8, utf8_decode("$" . $total), 1, 0, 'R');

            $pdf->Ln(8);
            $pdf->Cell(130, 8, "", 0, 0, 'L');
            if ($totalIngresado > 0) {
                $pdf->Cell(30, 8, utf8_decode('Cambio: '), 1, 0, 'L');
                $pdf->Cell(20, 8, utf8_decode("$" . ($totalIngresado - $total)), 1, 0, 'R');
                $pdf->Ln(8);
            }


            //   $pdf->Ln(8);


            $x = $pdf->GetX();
            $y = $pdf->GetY();
            /*   $pdf->Rect(115, $y - 22, 90, 40, 'D');
              $pdf->SetXY(115, $y - 22);
              $pdf->Cell(15, 6, 'Sello Caja', 0, 1); */

            $response = new sfWebResponse($pdf->Output());
            $response->headers->set('Content-Type', 'application/pdf');
            return $response;
        } else {
            return "";
        }
    }
    public function executeImprimirTicketFormato(sfWebRequest $request) {
        date_default_timezone_set('America/Mexico_City');

        //$pagos= $request->getParameter("pagos", 0);    
        //$alumno= $request->getParameter("alumno", 0);
        $no_pago = $request->getParameter("idPago", 0);
        $totalIngresado = $request->getParameter("totalIngresado", 0);

        $total = 0;


        $pagos = consultasBd::getTicketPago((int) $no_pago);
        for ($i = 0; $i < sizeof($pagos); $i ++) {
            if ($pagos[$i]['tipo_descripcion'] == "Alumno") {
                $nombreAlumno = consultasInstituto::getDatosAlumnoXIdTiket($pagos[$i]['id_alumno']);
                $pagos[$i]['cliente'] = $nombreAlumno[0]['nombre'];
                $pagos[$i]['seccion'] = $nombreAlumno[0]['seccion'];
            }
        }


        if (isset($pagos) && sizeof($pagos) > 0) {
            $pdf = new FPDF ();
            $pdf->AddPage('P', array(100, 150));

            /*     $pdf->Ln(6);
              $pdf->SetFont('Arial', '', 11);
              $pdf->SetTextColor(88, 89, 91);
              $pdf->Cell(0, 8, utf8_decode('RECIBO POR CUOTA DE TERCEROS'), 'B', 0, 'C'); */



            // $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetTextColor(88, 89, 91);
            $pdf->Cell(85, 6, utf8_decode('RECIBO POR CUOTA DE TERCEROS:'), 1, 0, 'L');
            //     $pdf->Cell(10, 8, utf8_decode(' '), 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Ln(8);
            $pdf->Cell(30, 6, utf8_decode('NO:  ' . $pagos[0]['id_pago']), 1, 0, 'L');
            //   $pdf->Cell(10, 8, utf8_decode(' '), 0, 0, 'L');
            $pdf->Cell(55, 6, utf8_decode('Fecha Pago: ' . $pagos[0]['fecha_pago']), 1, 0, 'L');
            $pdf->Ln(8);


            /*    $pdf->SetFont('Arial', '', 9);
              $pdf->SetTextColor(88, 89, 91);
              $pdf->Cell(30, 8, utf8_decode('Recibo Provisional'), 0, 0, 'R');
              $pdf->Ln(7);
              $pdf->Cell(60, 7, "", 0, 0, 'R');
              $pdf->Cell(40, 5, utf8_decode('NO.' . $pagos[0]['id_pago']), 1, 0, 'L');
              $pdf->Ln(7);
              $pdf->Cell(175, 6, utf8_decode($pagos[0]['fecha_pago']), 0, 0, 'R');
              $pdf->Ln(10); */
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetTextColor(88, 89, 91);
            $pdf->Cell(85, 6, utf8_decode('Nombre(N) | SECCION(S)'), 1, 0, 'L');
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Ln(8);
            $pdf->Cell(85, 6, utf8_decode("(N):" . $pagos[0]['cliente']), 1, 0, 'L');
            $pdf->Ln(8);
            $pdf->Cell(85, 6, utf8_decode("(S):" . $pagos[0]['seccion']), 1, 0, 'L');

            $pdf->Ln(8);
            $pdf->Cell(85, 8, utf8_decode('Servicio (S) | Monto (M) | Descuento (D) | Forma de Pago (FP)'), 1, 0, 'L');
            $pdf->Ln(8);
            $pdf->SetFont('Arial', '', 8);


            $subTotal = 0;
            $decuentoTotal = 0;

            for ($i = 0; $i < sizeof($pagos); $i ++) {
                $ts = strlen($pagos[$i]['nombre_servicio']);
                if ($ts > 45) {
                    $pagos[$i]['nombre_servicio'] = substr($pagos[$i]['nombre_servicio'], 0, 45);
                }


                $pdf->Cell(85, 6, utf8_decode(($i + 1) . '.- (S): ' . $pagos[$i]['nombre_servicio']), 0, 0, 'L');
                $pdf->Ln(6);
                $pdf->Cell(30, 6, utf8_decode('(M): $' . $pagos[$i]['monto']), 0, 0, 'R');
                $pdf->Cell(25, 6, utf8_decode('(D): $' . $pagos[$i]['descuento']), 0, 0, 'R');
                $pdf->Cell(30, 6, utf8_decode('(FP): ' . $pagos[$i]['forma_pago']), 0, 0, 'R');
                $pdf->Ln(6);
                $total+=(double) $pagos[$i]['monto'];
                $subTotal +=(double) $pagos[$i]['monto'] + (double) $pagos[$i]['descuento'];
                $decuentoTotal+=(double) $pagos[$i]['descuento'];
            }
            $importeLetra = $this->numtoletras($total);

   $pdf->Ln(5);

            $pdf->SetFont('Arial', 'B', 8);
            // $pdf->Cell(130, 8, "", 0, 0, 'L');
            $pdf->Cell(20, 8, utf8_decode('SubTotal: '), 1, 0, 'L');
            $pdf->Cell(25, 8, utf8_decode("$" . $subTotal), 1, 0, 'R');

            //  $pdf->Cell(30, 8, "", 0, 0, 'L');
            $pdf->Cell(20, 8, utf8_decode('Descuento: '), 1, 0, 'L');
            $pdf->Cell(20, 8, utf8_decode("$" . $decuentoTotal), 1, 0, 'R');


            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Ln(8);
            $pdf->Cell(85, 8, utf8_decode('Total: $'.$total), 1, 0, 'L');

            $pdf->Ln(8);
            $pdf->Cell(85, 8, utf8_decode("Importe con letra : " ), 1, 0, 'L');
 $pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(85, 8, utf8_decode( $importeLetra), 1, 0, 'L');


            $pdf->Ln(8);
           // $pdf->Cell(130, 8, "", 0, 0, 'L');
            if ($totalIngresado > 0) {
                $pdf->Cell(85, 8, utf8_decode('Cambio: '."$" . ($totalIngresado - $total)), 1, 0, 'L');
              //  $pdf->Cell(20, 8, utf8_decode("$" . ($totalIngresado - $total)), 1, 0, 'R');
                $pdf->Ln(8);
            }



            //   $pdf->Ln(8);


            $x = $pdf->GetX();
            $y = $pdf->GetY();
            /*   $pdf->Rect(115, $y - 22, 90, 40, 'D');
              $pdf->SetXY(115, $y - 22);
              $pdf->Cell(15, 6, 'Sello Caja', 0, 1); */

            $response = new sfWebResponse($pdf->Output());
            $response->headers->set('Content-Type', 'application/pdf');
            return $response;
        } else {
            return "";
        }
    }

    //Estado Cuenta Alumno

    public function executeEstadoCuentaAlumno(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                $idAlumno = $request->getParameter("idAlumno", 0);
                $fechaIni = $request->getParameter("fechaIni", 0);
                $fechaFin = $request->getParameter("fechaFin", 0);
                $listadoMovimientos = consultasBd::getEstadoCuentaAlumno((int) $idAlumno, $fechaIni, $fechaFin);
                $r = array("mensaje" => "Ok", "listadoMovimientos" => $listadoMovimientos); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "Error Desconocido", "valor" => "0"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    public function executeEstadoCuentaCliente(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                $idCliente = $request->getParameter("idCliente", 0);
                $fechaIni = $request->getParameter("fechaIni", 0);
                $fechaFin = $request->getParameter("fechaFin", 0);
                $listadoMovimientos = consultasBd::getEstadoCuentaCliente((int) $idCliente, $fechaIni, $fechaFin);
                $r = array("mensaje" => "Ok", "listadoMovimientos" => $listadoMovimientos); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "Error Desconocido", "valor" => "0"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    private function numtoletras($xcifra) {
        $xarray = array(0 => "Cero",
            1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
            "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
            "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
            100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
        );
        //
        $xcifra = trim($xcifra);
        $xlength = strlen($xcifra);
        $xpos_punto = strpos($xcifra, ".");
        $xaux_int = $xcifra;
        $xdecimales = "00";
        if (!($xpos_punto === false)) {
            if ($xpos_punto == 0) {
                $xcifra = "0" . $xcifra;
                $xpos_punto = strpos($xcifra, ".");
            }
            $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
            $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
        }

        $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
        $xcadena = "";
        for ($xz = 0; $xz < 3; $xz++) {
            $xaux = substr($XAUX, $xz * 6, 6);
            $xi = 0;
            $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
            $xexit = true; // bandera para controlar el ciclo del While
            while ($xexit) {
                if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                    break; // termina el ciclo
                }

                $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
                $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
                for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                    switch ($xy) {
                        case 1: // checa las centenas
                            if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                            } else {
                                $key = (int) substr($xaux, 0, 3);
                                if (TRUE === array_key_exists($key, $xarray)) {  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                    if (substr($xaux, 0, 3) == 100)
                                        $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                                }
                                else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                    $key = (int) substr($xaux, 0, 1) * 100;
                                    $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 0, 3) < 100)
                            break;
                        case 2: // checa las decenas (con la misma lógica que las centenas)
                            if (substr($xaux, 1, 2) < 10) {
                                
                            } else {
                                $key = (int) substr($xaux, 1, 2);
                                if (TRUE === array_key_exists($key, $xarray)) {
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux);
                                    if (substr($xaux, 1, 2) == 20)
                                        $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3;
                                }
                                else {
                                    $key = (int) substr($xaux, 1, 1) * 10;
                                    $xseek = $xarray[$key];
                                    if (20 == substr($xaux, 1, 1) * 10)
                                        $xcadena = " " . $xcadena . " " . $xseek;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 1, 2) < 10)
                            break;
                        case 3: // checa las unidades
                            if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                            } else {
                                $key = (int) substr($xaux, 2, 1);
                                $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                                $xsub = $this->subfijo($xaux);
                                $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                            } // ENDIF (substr($xaux, 2, 1) < 1)
                            break;
                    } // END SWITCH
                } // END FOR
                $xi = $xi + 3;
            } // ENDDO

            if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
                $xcadena.= " DE";

            if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
                $xcadena.= " DE";

            // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
            if (trim($xaux) != "") {
                switch ($xz) {
                    case 0:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN BILLON ";
                        else
                            $xcadena.= " BILLONES ";
                        break;
                    case 1:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN MILLON ";
                        else
                            $xcadena.= " MILLONES ";
                        break;
                    case 2:
                        if ($xcifra < 1) {
                            $xcadena = "CERO PESOS $xdecimales/100 M.N.";
                        }
                        if ($xcifra >= 1 && $xcifra < 2) {
                            $xcadena = "UN PESO $xdecimales/100 M.N. ";
                        }
                        if ($xcifra >= 2) {
                            $xcadena.= " PESOS $xdecimales/100 M.N. "; //
                        }
                        break;
                } // endswitch ($xz)
            } // ENDIF (trim($xaux) != "")
            // ------------------      en este caso, para México se usa esta leyenda     ----------------
            $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
        } // ENDFOR ($xz)
        return trim($xcadena);
    }

    // END FUNCTION

    private function subfijo($xx) { // esta función regresa un subfijo para la cifra
        $xx = trim($xx);
        $xstrlen = strlen($xx);
        if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
            $xsub = "";
        //
        if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
            $xsub = "MIL";
        //
        return $xsub;
    }

  public function executeListadoMovimientosCaja(sfWebRequest $request) {//guarda y edita
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');

                $numRecibo = $request->getParameter("numRecibo", 0);
                $formaPago = $request->getParameter("formaPago", "NA");

                $fechaIni = $request->getParameter("fechaIni", 0);
                $fechaFin = $request->getParameter("fechaFin", 0);

                $nombreServicio = $request->getParameter("nombreServicio", '');
                $nombreSeccion = $request->getParameter("nombreSeccion", '');
                $categoria = $request->getParameter("categoria", '');

                $listadoMovimientos = consultasBd::getMovimientosCaja($numRecibo, $fechaIni, $fechaFin, $formaPago, $nombreServicio,$categoria);
                $listadoMovimientosRefinada = [];

                for ($i = 0; $i < sizeof($listadoMovimientos); $i ++) {
                    if ($nombreSeccion != '') {
                        if ($listadoMovimientos[$i]['tipo_descripcion'] == "Alumno") {
                            $nombreAlumno = consultasInstituto::getDatosAlumnoXIdSeccion($listadoMovimientos[$i]['id_alumno'], $nombreSeccion);
                            if (sizeof($nombreAlumno) > 0) {
                                $listadoMovimientos[$i]['cliente'] = $nombreAlumno[0]['nombre'];
                                array_push($listadoMovimientosRefinada, $listadoMovimientos[$i]);
                            }
                        }
                    } else {
                        if ($listadoMovimientos[$i]['tipo_descripcion'] == "Alumno") {
                            $nombreAlumno = consultasInstituto::getDatosAlumnoXId($listadoMovimientos[$i]['id_alumno']);
                            $listadoMovimientos[$i]['cliente'] = $nombreAlumno[0]['nombre'];
                        }
                    }
                }

                if ($nombreSeccion != '') {
                    $listadoMovimientos = $listadoMovimientosRefinada;
                }


                $r = array("mensaje" => "Ok", 'listadoMovimientos' => $listadoMovimientos); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "No se pudo guardar Err:001 ", "error" => true); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            // throw new sfException($e);
            $r = array("mensaje" => "No se pudo guardar Err:002 ", "error" => true); //a partir de php 5.4 es con corchetes[]
            return $this->sendJSON($r);
        }
    }

    public function executeListadoMovimientosCajaImprimir(sfWebRequest $request) {
        try {


            date_default_timezone_set('America/Mexico_City');

            $numRecibo = $request->getParameter("numRecibo", 0);
            $formaPago = $request->getParameter("formaPago", "NA");

            $fechaIni = $request->getParameter("fechaIni", 0);
            $fechaFin = $request->getParameter("fechaFin", 0);

            $nombreServicio = $request->getParameter("nombreServicio", '');
            $nombreSeccion = $request->getParameter("nombreSeccion", '');
             $categoria = $request->getParameter("categoria", '');

            $listadoMovimientos = consultasBd::getMovimientosCaja($numRecibo, $fechaIni, $fechaFin, $formaPago, $nombreServicio,$categoria);
            $listadoMovimientosRefinada = [];

            for ($i = 0; $i < sizeof($listadoMovimientos); $i ++) {
                if ($nombreSeccion != '') {
                    if ($listadoMovimientos[$i]['tipo_descripcion'] == "Alumno") {
                        $nombreAlumno = consultasInstituto::getDatosAlumnoXIdSeccionSeparados($listadoMovimientos[$i]['id_alumno'], $nombreSeccion);
                        if (sizeof($nombreAlumno) > 0) {
                            $listadoMovimientos[$i]['cliente'] = $nombreAlumno[0]['nombre'];
                            $listadoMovimientos[$i]['seccion'] = $nombreAlumno[0]['seccion'];
                            array_push($listadoMovimientosRefinada, $listadoMovimientos[$i]);
                        }
                    }
                } else {
                    if ($listadoMovimientos[$i]['tipo_descripcion'] == "Alumno") {
                        $nombreAlumno = consultasInstituto::getDatosAlumnoXIdSeccionSeparados($listadoMovimientos[$i]['id_alumno'], $nombreSeccion);
                        $listadoMovimientos[$i]['cliente'] = $nombreAlumno[0]['nombre'];
                        $listadoMovimientos[$i]['seccion'] = $nombreAlumno[0]['seccion'];
                    } else {
                        $listadoMovimientos[$i]['seccion'] = "";
                    }
                }
            }

            if ($nombreSeccion != '') {
                $listadoMovimientos = $listadoMovimientosRefinada;
            }

            //-------------imprimir

            $pdf = new FPDF ();

            $pdf->AddPage('L'); // orientacion de la hoja!
            //  $pdf->AddPage();

            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(120, 8, utf8_decode('Listado Movimientos de  : ' . $fechaIni . ' a ' . $fechaFin), 'B', 0, 'L');

            $pdf->Ln(8);


            $pdf->SetFont('Arial', 'B', 7);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFillColor(136, 138, 140);
            $pdf->Cell(6, 8, utf8_decode("#"), 'B', 0, 'L', true);
            $pdf->Cell(65, 8, utf8_decode("Nombre Servicio"), 'B', 0, 'L', true);
            $pdf->Cell(20, 8, utf8_decode("Tipo Cli."), 'B', 0, 'L', true);
            $pdf->Cell(55, 8, utf8_decode("Nombre"), 'B', 0, 'L', true);
            $pdf->Cell(20, 8, utf8_decode("Monto"), 'B', 0, 'R', true);
            $pdf->Cell(20, 8, utf8_decode("Descuento"), 'B', 0, 'R', true);
            $pdf->Cell(25, 8, utf8_decode("Fecha Pago"), 'B', 0, 'L', true);
            $pdf->Cell(23, 8, utf8_decode("Forma Pago"), 'B', 0, 'L', true);
            $pdf->Cell(12, 8, utf8_decode("# Recibo"), 'B', 0, 'R', true);
            $pdf->Cell(17, 8, utf8_decode("Tipo"), 'B', 0, 'R', true);
            $pdf->Cell(17, 8, utf8_decode("Estatus"), 'B', 0, 'R', true);

            $pdf->Ln(8);

            $pdf->SetFont('Arial', '', 8);
            $pdf->SetTextColor(88, 89, 91);
            $y = 1;
            //ordenar la lista de alumnos

            if (sizeof($listadoMovimientos) == 0) {
                echo 'No hay datos para imprimir..';
                die();
            }

            /*     foreach ($listadoMovimientos as $key => $row) {
              $aux[$key] = $row['cliente'];
              }
              array_multisort($aux, SORT_ASC, $listaDiasMora); */
            //--------------------

            $totalDescuento = 0;
            $totalPagado = 0;
            $totalEgreso = 0;
            $totalMonto = 0;
            for ($x = 0; $x < sizeof($listadoMovimientos); $x ++) {

                $pdf->Cell(6, 8, utf8_decode($y), 'B', 0, 'L');
                $pdf->Cell(65, 8, utf8_decode($listadoMovimientos[$x]['nombre_servicio']), 'B', 0, 'L');
                $pdf->Cell(20, 8, utf8_decode($listadoMovimientos[$x]['tipo_descripcion']), 'B', 0, 'L');
                $pdf->Cell(55, 8, utf8_decode($listadoMovimientos[$x]['cliente']), 'B', 0, 'L');
                $pdf->Cell(20, 8, utf8_decode('$' . $listadoMovimientos[$x]['monto']), 'B', 0, 'R');
                $pdf->Cell(20, 8, utf8_decode('$' . $listadoMovimientos[$x]['descuento']), 'B', 0, 'R');
                $pdf->Cell(25, 8, utf8_decode($listadoMovimientos[$x]['fecha_pago']), 'B', 0, 'L');
                $pdf->Cell(23, 8, utf8_decode($listadoMovimientos[$x]['forma_pago']), 'B', 0, 'L');
                $pdf->Cell(12, 8, utf8_decode('#' . $listadoMovimientos[$x]['id_pago']), 'B', 0, 'R');
                $pdf->Cell(17, 8, utf8_decode(strtoupper($listadoMovimientos[$x]['tipo'])), 'B', 0, 'R');
                $pdf->Cell(17, 8, utf8_decode($listadoMovimientos[$x]['estatus_pago']), 'B', 0, 'R');

                $pdf->Ln(4);
                $pdf->Cell(98, 4, "", 0, 0, 'L');
                $pdf->Cell(70, 4, utf8_decode($listadoMovimientos[$x]['seccion']), 'B', 0, 'L');


                $y++;
                if ($listadoMovimientos[$x]['estatus_pago'] == 'Pagado') {
                    if ($listadoMovimientos[$x]['tipo'] == 'ingreso') {
                        $totalPagado+= $listadoMovimientos[$x]['monto'];
                    } else if ($listadoMovimientos[$x]['tipo'] == 'egreso') {
                        $totalEgreso+= $listadoMovimientos[$x]['monto'];
                    }
                    $totalDescuento+= $listadoMovimientos[$x]['descuento'];
                }


                $pdf->Ln(4);
            }
            $totalMonto = $totalPagado - $totalEgreso - $totalDescuento;
            $pdf->Ln(8);
            $pdf->SetFont('Arial', 'B', 8);

            $pdf->Cell(100, 8, "", 0, 0, 'L');
            $pdf->Cell(40, 8, utf8_decode("Total Ingresos "), 1, 0, 'L');
            $pdf->Cell(40, 8, utf8_decode("Total Descuento: "), 1, 0, 'L');
            $pdf->Cell(40, 8, utf8_decode("Total Egresos: "), 1, 0, 'L');
            $pdf->Cell(40, 8, utf8_decode("Total Cobrado: "), 1, 0, 'L');

            $pdf->Ln(8);
            $pdf->Cell(100, 8, "", 0, 0, 'L');
            $pdf->Cell(40, 8, utf8_decode("$" . $totalPagado), 1, 0, 'R');
            $pdf->Cell(40, 8, utf8_decode("$" . $totalDescuento), 1, 0, 'R');
            $pdf->Cell(40, 8, utf8_decode("$" . $totalEgreso), 1, 0, 'R');
            $pdf->Cell(40, 8, utf8_decode("$" . $totalMonto), 1, 0, 'R');








            $response = new sfWebResponse($pdf->Output());
            $response->headers->set('Content-Type', 'application/pdf');
            return $response;
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
            $r = array("error" => true, "mensaje" => "Error Desconocido_02");
            return $this->sendJSON($r);
        }
    }
    public function executeEliminarPagos(sfWebRequest $request) {//guarda y edita
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');

                $numRecibo = $request->getParameter("numRecibo", 0);

                consultasBd::getEliminarPagos($numRecibo);

                $r = array("mensaje" => "Ok"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "No se pudo guardar Err:001 ", "error" => true); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            // throw new sfException($e);
            $r = array("mensaje" => "No se pudo guardar Err:002 ", "error" => true); //a partir de php 5.4 es con corchetes[]
            return $this->sendJSON($r);
        }
    }

    public function executeHistorialPagos(sfWebRequest $request) {//guarda y edita
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');

                $idAlumno = $request->getParameter("idAlumno", 0);
                $idCliente = $request->getParameter("idCliente", 0);

                $historialServicios = null;
                if ($idAlumno > 0) {
                    $historialServicios = consultasBd::getHistorialServiciosDetallePago($idAlumno, "A");
                } else {
                    $historialServicios = consultasBd::getHistorialServiciosDetallePago($idCliente, "C");
                }

                //echo "<pre>";   print_r($historialServicios);die();
                $r = array("mensaje" => "Ok", "historialServicios" => $historialServicios); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "No se pudo guardar Err:001 ", "error" => true); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            // throw new sfException($e);
            $r = array("mensaje" => "No se pudo guardar Err:002 ", "error" => true); //a partir de php 5.4 es con corchetes[]
            return $this->sendJSON($r);
        }
    }

    /* Consultar los datos del servicio con su detalle de pagos */

    public function executeListaServiciosInformacion(sfWebRequest $request) {//guarda y edita
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');

                $formaPago = $request->getParameter("formaPago", "NA");
                $fechaIni = $request->getParameter("fechaIni", 0);
                $fechaFin = $request->getParameter("fechaFin", 0);

                $nombreServicio = $request->getParameter("nombreServicio", '');
   $categoria = $request->getParameter("categoria", '');


                $listaServiciosInfo = consultasBd::getEstadoCuentaServicio($fechaIni, $fechaFin, $formaPago, $nombreServicio,$categoria);



                $r = array("mensaje" => "Ok", "listaServiciosInfo" => $listaServiciosInfo); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "No se pudo guardar Err:001 ", "error" => true); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            // throw new sfException($e);
            $r = array("mensaje" => "No se pudo guardar Err:002 ", "error" => true); //a partir de php 5.4 es con corchetes[]
            return $this->sendJSON($r);
        }
    }

    public function executeListaServiciosInformacionImprimir(sfWebRequest $request) {//guarda y edita
        try {


            date_default_timezone_set('America/Mexico_City');

            $formaPago = $request->getParameter("formaPago", "NA");
            $fechaIni = $request->getParameter("fechaIni", 0);
            $fechaFin = $request->getParameter("fechaFin", 0);

            $nombreServicio = $request->getParameter("nombreServicio", '');
   $categoria = $request->getParameter("categoria", '');


            $listadoMovimientos = consultasBd::getEstadoCuentaServicio($fechaIni, $fechaFin, $formaPago, $nombreServicio,$categoria);

            /* Imprimir */
            //-------------imprimir

            $pdf = new FPDF ();

            $pdf->AddPage('L'); // orientacion de la hoja!
            //  $pdf->AddPage();

            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(120, 8, utf8_decode('Listado De Servicios   : ' . $fechaIni . ' a ' . $fechaFin), 'B', 0, 'L');

            $pdf->Ln(8);


            $pdf->SetFont('Arial', 'B', 7);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFillColor(136, 138, 140);
            $pdf->Cell(6, 8, utf8_decode("#"), 'B', 0, 'L', true);
            $pdf->Cell(65, 8, utf8_decode("Categoria"), 'B', 0, 'L', true);
            $pdf->Cell(90, 8, utf8_decode("Nombre Servicio"), 'B', 0, 'L', true);
            $pdf->Cell(20, 8, utf8_decode("Precio"), 'B', 0, 'R', true);
            $pdf->Cell(20, 8, utf8_decode("Ingresos"), 'B', 0, 'R', true);
            $pdf->Cell(20, 8, utf8_decode("Descuento"), 'B', 0, 'R', true);
            $pdf->Cell(20, 8, utf8_decode("Egresos"), 'B', 0, 'R', true);
            $pdf->Cell(20, 8, utf8_decode("Total"), 'B', 0, 'R', true);

            $pdf->Ln(8);

            $pdf->SetFont('Arial', '', 8);
            $pdf->SetTextColor(88, 89, 91);
            $y = 1;
            //ordenar la lista de alumnos

            if (sizeof($listadoMovimientos) == 0) {
                echo 'No hay datos para imprimir..';
                die();
            }

            /*     foreach ($listadoMovimientos as $key => $row) {
              $aux[$key] = $row['cliente'];
              }
              array_multisort($aux, SORT_ASC, $listaDiasMora); */
            //--------------------
            $totalPrecio = 0;
            $totalPagado = 0;
            $totalDescuento = 0;
            $totalEgreso = 0;
            $totalTotal = 0;
            for ($x = 0; $x < sizeof($listadoMovimientos); $x ++) {

                $pdf->Cell(6, 8, utf8_decode($y), 'B', 0, 'L');
                $pdf->Cell(65, 8, utf8_decode($listadoMovimientos[$x]['categoria']), 'B', 0, 'L');
                $pdf->Cell(90, 8, utf8_decode($listadoMovimientos[$x]['nombre']), 'B', 0, 'L');
                $pdf->Cell(20, 8, utf8_decode('$' . $listadoMovimientos[$x]['precio']), 'B', 0, 'R');
                $pdf->Cell(20, 8, utf8_decode('$' . $listadoMovimientos[$x]['pagado_sin_descuento']), 'B', 0, 'R');
                $pdf->Cell(20, 8, utf8_decode('$' . $listadoMovimientos[$x]['descuento']), 'B', 0, 'R');
                $pdf->Cell(20, 8, utf8_decode('$' . $listadoMovimientos[$x]['egresos']), 'B', 0, 'R');
                $pdf->Cell(20, 8, utf8_decode('$' . $listadoMovimientos[$x]['total']), 'B', 0, 'R');

                $totalPrecio+=$listadoMovimientos[$x]['precio'];
                $totalPagado+=$listadoMovimientos[$x]['pagado_sin_descuento'];
                $totalDescuento+=$listadoMovimientos[$x]['descuento'];
                $totalEgreso+=$listadoMovimientos[$x]['egresos'];
                $totalTotal+=$listadoMovimientos[$x]['total'];

                $y++;
                $pdf->Ln(8);
                //   $pdf->Ln(4);
            }

            $pdf->Ln(8);
            $pdf->SetFont('Arial', 'B', 8);

            $pdf->Cell(6, 8, utf8_decode(""), 'B', 0, 'L');
            $pdf->Cell(65, 8, utf8_decode(""), 'B', 0, 'L');
            $pdf->Cell(90, 8, utf8_decode("Totales:"), 'B', 0, 'L');
            $pdf->Cell(20, 8, utf8_decode('$' . $totalPrecio), 'B', 0, 'R');
            $pdf->Cell(20, 8, utf8_decode('$' . $totalPagado), 'B', 0, 'R');
            $pdf->Cell(20, 8, utf8_decode('$' . $totalDescuento), 'B', 0, 'R');
            $pdf->Cell(20, 8, utf8_decode('$' . $totalEgreso), 'B', 0, 'R');
            $pdf->Cell(20, 8, utf8_decode('$' . $totalTotal), 'B', 0, 'R');


            $response = new sfWebResponse($pdf->Output());
            $response->headers->set('Content-Type', 'application/pdf');
            return $response;

            /* Fin imprimir */
        } catch (Doctrine_Exception $e) {
            // throw new sfException($e);
            $r = array("mensaje" => "No se pudo guardar Err:002 ", "error" => true); //a partir de php 5.4 es con corchetes[]
            return $this->sendJSON($r);
        }
    }

}
