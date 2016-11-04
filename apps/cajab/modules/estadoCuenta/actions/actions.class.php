<?php

/**
 * pagos actions.
 *
 * @package    puntoveta
 * @subpackage pagos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class estadoCuentaActions extends baseCajabProjectActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        //$this->forward('default', 'module');
    }

    public function executeServiciosEstatus(sfWebRequest $request) {
        $this->setTemplate('serviciosEstatus');
    }

    public function executeServiciosActivosAlumnos(sfWebRequest $request) {
        $this->setTemplate('serviciosActivosAlumnos');
    }

    public function executeAsignadosAServicio(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');


                $nombreCliente = $request->getParameter("nombreCliente", "");
                $idServicio = $request->getParameter("idServicio", 0);
                $offset = $request->getParameter("offset", 0);
                $limit = $request->getParameter("limit", 0);

                $tam = 0;
                $count = 0;
                $flagFiltroNombre = false;
                $listaAsignadosFiltro = array();

                $idsAlumnos = "";
                if ($nombreCliente != "") {
                    $buscados = consultasInstituto::getIdsAlumnos($nombreCliente);
                    $tam = sizeof($buscados);
                    //if ($tam > 0) {
                    $flagFiltroNombre = true;
                    //}
                }



                $listaAsignados = consultasBd::getPagadoClientesServicio((int) $idServicio, (int) $limit, (int) $offset);
                for ($i = 0; $i < sizeof($listaAsignados); $i ++) {
                    if ($listaAsignados[$i]['cliente'] == "na" && $listaAsignados[$i]['tipo_descripcion'] == "Alumno") {
                        $vecNombreAlumno = consultasInstituto::getAlumnoXId($listaAsignados[$i]['id_alumno']);
                        $listaAsignados[$i]['cliente'] = $vecNombreAlumno[0]['nombre'];
                        if ($flagFiltroNombre) {
                            for ($j = 0; $j < $tam; $j ++) {
                                //echo "<br/>".$buscados[$j]['idalumno']."==".$listaAsignados[$i]['id_alumno'];
                                if ($buscados[$j]['idalumno'] == $listaAsignados[$i]['id_alumno']) {
                                    array_push($listaAsignadosFiltro, $listaAsignados[$i]);
                                    $count++;
                                }
                            }
                        }
                    } else {
                        if ($flagFiltroNombre && $listaAsignados[$i]['tipo_descripcion'] == "Cliente Externo") {
                            array_push($listaAsignadosFiltro, $listaAsignados[$i]);
                            $count++;
                        }
                    }
                }

                $totalListaAsignados = consultasBd::getTotalPagadoClientesServicio((int) $idServicio);
                $totalListaAsignados = $totalListaAsignados[0]['total'];


                if ($flagFiltroNombre) {
                    $listaAsignados = $listaAsignadosFiltro;
                    $totalListaAsignados = $count;
                }


                $r = array("error" => false, "mensaje" => "Ok", "listaAsignados" => $listaAsignados, "total" => $totalListaAsignados); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("error" => true, "mensaje" => "Error Desconocido_01");
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
            $r = array("error" => true, "mensaje" => "Error Desconocido_02");
            return $this->sendJSON($r);
        }
    }

    public function executeServiciosDiasMora(sfWebRequest $request) {
        $this->setTemplate('serviciosDiasMora');
    }

    public function executeListadoDiasMora(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');



                $offset = $request->getParameter("offset", 0);
                $limit = $request->getParameter("limit", 0);



                $listaDiasMora = consultasBd::getListadoDiasMora((int) $limit, (int) $offset);
                for ($i = 0; $i < sizeof($listaDiasMora); $i ++) {
                    if ($listaDiasMora[$i]['cliente'] == "na" && $listaDiasMora[$i]['tipo_descripcion'] == "Alumno") {
                        $vecNombreAlumno = consultasInstituto::getAlumnoXId($listaDiasMora[$i]['id_alumno']);
                        $listaDiasMora[$i]['cliente'] = $vecNombreAlumno[0]['nombre'];
                    }
                }

                $totalListaDiasMora = consultasBd::getTotalListadoDiasMora();
                $totalListaDiasMora = $totalListaDiasMora[0]['total'];




                $r = array("error" => false, "mensaje" => "Ok", "listaDiasMora" => $listaDiasMora, "total" => $totalListaDiasMora); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("error" => true, "mensaje" => "Error Desconocido_01");
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
            $r = array("error" => true, "mensaje" => "Error Desconocido_02");
            return $this->sendJSON($r);
        }
    }

    public function executeServiciosActivosAlumnosLista(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');
                $offset = $request->getParameter("offset", 0);
                $limit = $request->getParameter("limit", 0);
                $transporte = $request->getParameter("transporte", false);
                $mayores = $request->getParameter("mayores", false);


                $listaAlumnos = consultasBd::getServiciosActivosAlumnos((int) $limit, (int) $offset, $transporte, $mayores);
                for ($i = 0; $i < sizeof($listaAlumnos); $i ++) {
                    $vecNombreAlumno = consultasInstituto::getAlumnoXId($listaAlumnos[$i]['id_alumno']);
                    $listaAlumnos[$i]['cliente'] = $vecNombreAlumno[0]['nombre'];
                }
                $totalListaAlumnos = consultasBd::getTotalServiciosActivosAlumnos($transporte, $mayores);
                $totalListaAlumnos = $totalListaAlumnos[0]['total'];




                $r = array("error" => false, "mensaje" => "Ok", "listaAlumnos" => $listaAlumnos, "total" => $totalListaAlumnos); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("error" => true, "mensaje" => "Error Desconocido_01");
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
            $r = array("error" => true, "mensaje" => "Error Desconocido_02");
            return $this->sendJSON($r);
        }
    }

    public function executeIngresosEgresos(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');



                $idServicio = $request->getParameter("idServicio", 0);







                $listaIngresosEgresos = consultasBd::getIngresosEgresosServicio((int) $idServicio);
                for ($i = 0; $i < sizeof($listaIngresosEgresos); $i ++) {
                    if ($listaIngresosEgresos[$i]['tipo_cliente'] == 1) {
                        $vecNombreAlumno = consultasInstituto::getAlumnoXId($listaIngresosEgresos[$i]['id_alumno']);
                        $listaIngresosEgresos[$i]['cliente'] = $vecNombreAlumno[0]['nombre'];
                    }
                }




                $r = array("error" => false, "mensaje" => "Ok", "listaIngresosEgresos" => $listaIngresosEgresos); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("error" => true, "mensaje" => "Error Desconocido_01");
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
            $r = array("error" => true, "mensaje" => "Error Desconocido_02");
            return $this->sendJSON($r);
        }
    }

    //***************Impresiones reportes*************************

    public function executeIngresosEgresosImprimir(sfWebRequest $request) {
        try {

            date_default_timezone_set('America/Mexico_City');
            $idServicio = $request->getParameter("idServicio", 0);
            $nombreServicio = $request->getParameter("nombreServicio", "");
            $listaIngresosEgresos = consultasBd::getIngresosEgresosServicio((int) $idServicio);
            for ($i = 0; $i < sizeof($listaIngresosEgresos); $i ++) {
                if ($listaIngresosEgresos[$i]['tipo_cliente'] == 1) {
                    $vecNombreAlumno = consultasInstituto::getAlumnoXId($listaIngresosEgresos[$i]['id_alumno']);
                    $listaIngresosEgresos[$i]['cliente'] = $vecNombreAlumno[0]['nombre'];
                }
            }

            //-------------imprimir

            $pdf = new FPDF ();

            $pdf->AddPage('L'); // orientacion de la hoja!
            //  $pdf->AddPage();

            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(100, 8, utf8_decode('Detalles de movimientos '), 'B', 0, 'L');
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(100, 8, utf8_decode('Servicio: ' . utf8_decode($nombreServicio)), 'B', 0, 'L');
            $pdf->Ln(8);


            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFillColor(136, 138, 140);
            $pdf->Cell(8, 8, utf8_decode("#"), 'B', 0, 'L', true);
            $pdf->Cell(20, 8, utf8_decode("Tipo Cli."), 'B', 0, 'L', true);
            $pdf->Cell(80, 8, utf8_decode("Nombre"), 'B', 0, 'C', true);
            $pdf->Cell(30, 8, utf8_decode("Tipo Mov."), 'B', 0, 'L', true);
            $pdf->Cell(30, 8, utf8_decode("Fecha"), 'B', 0, 'L', true);
            $pdf->Cell(30, 8, utf8_decode("Pagado"), 'B', 0, 'R', true);
            $pdf->Cell(30, 8, utf8_decode("Descuento   "), 'B', 0, 'R', true);
            $pdf->Cell(30, 8, utf8_decode("Egreso   "), 'B', 0, 'R', true);
            $pdf->Ln(8);

            $pdf->SetFont('Arial', '', 9);
            $pdf->SetTextColor(88, 89, 91);
            $y = 1;
            //ordenar la lista de alumnos
            if (sizeof($listaIngresosEgresos) == 0) {
                echo 'No hay datos para imprimir..';
                die();
            }
            foreach ($listaIngresosEgresos as $key => $row) {
                $aux[$key] = $row['cliente'];
            }
            array_multisort($aux, SORT_ASC, $listaIngresosEgresos);
            //--------------------
            $totalEsperado = 0;
            $totalPagado = 0;
            $totalDescuento = 0;
            $totalEgreso = 0;
            $totalTotal = 0;

            for ($x = 0; $x < sizeof($listaIngresosEgresos); $x ++) {

                $pdf->Cell(8, 8, utf8_decode($y), 'B', 0, 'L');
                $pdf->Cell(20, 8, utf8_decode($listaIngresosEgresos[$x]['tipo_descripcion']), 'B', 0, 'L');
                $pdf->Cell(80, 8, utf8_decode($listaIngresosEgresos[$x]['cliente']), 'B', 0, 'L');
                $pdf->Cell(30, 8, utf8_decode($listaIngresosEgresos[$x]['modo_pago']), 'B', 0, 'L');
                $pdf->Cell(30, 8, utf8_decode($listaIngresosEgresos[$x]['fecha_pago']), 'B', 0, 'L');
                $pdf->Cell(30, 8, utf8_decode('$' . $listaIngresosEgresos[$x]['pago']), 'B', 0, 'R');
                $pdf->Cell(30, 8, utf8_decode('$' . $listaIngresosEgresos[$x]['descuento']), 'B', 0, 'R');
                $pdf->Cell(30, 8, utf8_decode('$' . $listaIngresosEgresos[$x]['egreso']), 'B', 0, 'R');

                $y++;
                $pdf->Ln(8);

                $totalEsperado = (double) $listaIngresosEgresos[0]['inscritos'] * (double) $listaIngresosEgresos[0]['precio'];
                $totalPagado +=(double) $listaIngresosEgresos[$x]['pago'] + (double) $listaIngresosEgresos[$x]['descuento'];
                $totalDescuento +=(double) $listaIngresosEgresos[$x]['descuento'];
                $totalEgreso +=(double) $listaIngresosEgresos[$x]['egreso'];
            }
            $totalTotal = $totalPagado - $totalDescuento - $totalEgreso;
            $pdf->Ln(8);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(30, 8, utf8_decode('Esperado: '), 1, 0, 'L');
            $pdf->Cell(30, 8, utf8_decode('Pagado: '), 1, 0, 'L');
            $pdf->Cell(30, 8, utf8_decode('Descuento: '), 1, 0, 'L');
            $pdf->Cell(30, 8, utf8_decode('Egreso: '), 1, 0, 'L');
            $pdf->Cell(30, 8, utf8_decode('Total: '), 1, 0, 'L');
            $pdf->Ln(8);
            $pdf->Cell(30, 8, utf8_decode("$" . $totalEsperado), 1, 0, 'R');
            $pdf->Cell(30, 8, utf8_decode("$" . $totalPagado), 1, 0, 'R');
            $pdf->Cell(30, 8, utf8_decode("$" . $totalDescuento), 1, 0, 'R');
            $pdf->Cell(30, 8, utf8_decode("$" . $totalEgreso), 1, 0, 'R');
            $pdf->Cell(30, 8, utf8_decode("$" . $totalTotal), 1, 0, 'R');



            $response = new sfWebResponse($pdf->Output());
            $response->headers->set('Content-Type', 'application/pdf');
            return $response;

            //----------------
            //  $r = array("error" => false, "mensaje" => "Ok", "listaIngresosEgresos" => $listaIngresosEgresos); //a partir de php 5.4 es con corchetes[]
            // return $this->sendJSON($r);
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
            $r = array("error" => true, "mensaje" => "Error Desconocido_02");
            return $this->sendJSON($r);
        }
    }

    public function executeAsignadosAServicioImprimir(sfWebRequest $request) {
        try {


            date_default_timezone_set('America/Mexico_City');


            $nombreCliente = $request->getParameter("nombreCliente", "");
            $nombreServicio = $request->getParameter("nombreServicio", "");
            $idServicio = $request->getParameter("idServicio", 0);
            $offset = $request->getParameter("offset", 0);
            $limit = $request->getParameter("limit", 10000);

            $tam = 0;
            $count = 0;
            $flagFiltroNombre = false;
            $listaAsignadosFiltro = array();

            $idsAlumnos = "";
            if ($nombreCliente != "") {
                $buscados = consultasInstituto::getIdsAlumnos($nombreCliente);
                $tam = sizeof($buscados);
                //if ($tam > 0) {
                $flagFiltroNombre = true;
                //}
            }



            $listaAsignados = consultasBd::getPagadoClientesServicio((int) $idServicio, (int) $limit, (int) $offset);
            for ($i = 0; $i < sizeof($listaAsignados); $i ++) {
                if ($listaAsignados[$i]['cliente'] == "na" && $listaAsignados[$i]['tipo_descripcion'] == "Alumno") {
                    $vecNombreAlumno = consultasInstituto::getAlumnoXId($listaAsignados[$i]['id_alumno']);
                    $listaAsignados[$i]['cliente'] = $vecNombreAlumno[0]['nombre'];
                    if ($flagFiltroNombre) {
                        for ($j = 0; $j < $tam; $j ++) {
                            //echo "<br/>".$buscados[$j]['idalumno']."==".$listaAsignados[$i]['id_alumno'];
                            if ($buscados[$j]['idalumno'] == $listaAsignados[$i]['id_alumno']) {
                                array_push($listaAsignadosFiltro, $listaAsignados[$i]);
                                $count++;
                            }
                        }
                    }
                } else {
                    if ($flagFiltroNombre && $listaAsignados[$i]['tipo_descripcion'] == "Cliente Externo") {
                        array_push($listaAsignadosFiltro, $listaAsignados[$i]);
                        $count++;
                    }
                }
            }

            $totalListaAsignados = consultasBd::getTotalPagadoClientesServicio((int) $idServicio);
            $totalListaAsignados = $totalListaAsignados[0]['total'];


            if ($flagFiltroNombre) {
                $listaAsignados = $listaAsignadosFiltro;
                $totalListaAsignados = $count;
            }


            //-------------imprimir

            $pdf = new FPDF ();

            $pdf->AddPage('L'); // orientacion de la hoja!
            //  $pdf->AddPage();

            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(120, 8, utf8_decode('Detalles de pagos de los clientes asignados al servicio '), 'B', 0, 'L');
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(100, 8, utf8_decode('Servicio: ' . utf8_decode($nombreServicio)), 'B', 0, 'L');
            $pdf->Ln(8);


            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFillColor(136, 138, 140);
            $pdf->Cell(8, 8, utf8_decode("#"), 'B', 0, 'L', true);
            $pdf->Cell(20, 8, utf8_decode("Tipo Cli."), 'B', 0, 'L', true);
            $pdf->Cell(80, 8, utf8_decode("Nombre"), 'B', 0, 'C', true);
            $pdf->Cell(30, 8, utf8_decode("Precio"), 'B', 0, 'L', true);
            $pdf->Cell(30, 8, utf8_decode("Abonado"), 'B', 0, 'L', true);
            $pdf->Cell(30, 8, utf8_decode("Descuento"), 'B', 0, 'R', true);
            $pdf->Cell(30, 8, utf8_decode("Saldo"), 'B', 0, 'R', true);
            $pdf->Cell(30, 8, utf8_decode("Estatus"), 'B', 0, 'R', true);
            $pdf->Ln(8);

            $pdf->SetFont('Arial', '', 9);
            $pdf->SetTextColor(88, 89, 91);
            $y = 1;
            //ordenar la lista de alumnos
            if (sizeof($listaAsignados) == 0) {
                echo 'No hay datos para imprimir..';
                die();
            }
            foreach ($listaAsignados as $key => $row) {
                $aux[$key] = $row['saldo'];
            }
            array_multisort($aux, SORT_ASC, $listaAsignados);
            //--------------------


            for ($x = 0; $x < sizeof($listaAsignados); $x ++) {

                $pdf->Cell(8, 8, utf8_decode($y), 'B', 0, 'L');
                $pdf->Cell(20, 8, utf8_decode($listaAsignados[$x]['tipo_descripcion']), 'B', 0, 'L');
                $pdf->Cell(80, 8, utf8_decode($listaAsignados[$x]['cliente']), 'B', 0, 'L');
                $pdf->Cell(30, 8, utf8_decode($listaAsignados[$x]['precio']), 'B', 0, 'L');
                $pdf->Cell(30, 8, utf8_decode($listaAsignados[$x]['abonado']), 'B', 0, 'L');
                $pdf->Cell(30, 8, utf8_decode('$' . $listaAsignados[$x]['descuento']), 'B', 0, 'R');
                $pdf->Cell(30, 8, utf8_decode('$' . $listaAsignados[$x]['saldo']), 'B', 0, 'R');
                $pdf->Cell(30, 8, utf8_decode($listaAsignados[$x]['estatus_descripcion']), 'B', 0, 'R');

                $y++;
                $pdf->Ln(8);
            }



            $response = new sfWebResponse($pdf->Output());
            $response->headers->set('Content-Type', 'application/pdf');
            return $response;
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
            $r = array("error" => true, "mensaje" => "Error Desconocido_02");
            return $this->sendJSON($r);
        }
    }

    public function executeListadoDiasMoraImprimir(sfWebRequest $request) {
        try {


            date_default_timezone_set('America/Mexico_City');


            $offset = $request->getParameter("offset", 0);
            $limit = $request->getParameter("limit", 10000);



            $listaDiasMora = consultasBd::getListadoDiasMora((int) $limit, (int) $offset);
            for ($i = 0; $i < sizeof($listaDiasMora); $i ++) {
                if ($listaDiasMora[$i]['cliente'] == "na" && $listaDiasMora[$i]['tipo_descripcion'] == "Alumno") {
                    $vecNombreAlumno = consultasInstituto::getAlumnoXId($listaDiasMora[$i]['id_alumno']);
                    $listaDiasMora[$i]['cliente'] = $vecNombreAlumno[0]['nombre'];
                }
            }

            $totalListaDiasMora = consultasBd::getTotalListadoDiasMora();
            $totalListaDiasMora = $totalListaDiasMora[0]['total'];


            //-------------imprimir

            $pdf = new FPDF ();

            $pdf->AddPage('L'); // orientacion de la hoja!
            //  $pdf->AddPage();

            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(120, 8, utf8_decode('Listado Dias de mora al dia de : ' . date("d.m.y")), 'B', 0, 'L');

            $pdf->Ln(8);


            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFillColor(136, 138, 140);
            $pdf->Cell(8, 8, utf8_decode("#"), 'B', 0, 'L', true);
            $pdf->Cell(5, 8, utf8_decode("T.C."), 'B', 0, 'L', true);
            $pdf->Cell(73, 8, utf8_decode("Nombre"), 'B', 0, 'C', true);
            $pdf->Cell(70, 8, utf8_decode("Servicio"), 'B', 0, 'L', true);
            $pdf->Cell(20, 8, utf8_decode("Precio"), 'B', 0, 'R', true);
            $pdf->Cell(20, 8, utf8_decode("Abonado"), 'B', 0, 'R', true);
            $pdf->Cell(20, 8, utf8_decode("Descuento"), 'B', 0, 'R', true);
            $pdf->Cell(20, 8, utf8_decode("Saldo"), 'B', 0, 'R', true);
            $pdf->Cell(25, 8, utf8_decode("Fecha Fin"), 'B', 0, 'C', true);
            $pdf->Cell(15, 8, utf8_decode("Dias Mora"), 'B', 0, 'R', true);
            $pdf->Ln(8);

            $pdf->SetFont('Arial', '', 7);
            $pdf->SetTextColor(88, 89, 91);
            $y = 1;
            //ordenar la lista de alumnos

            if (sizeof($listaDiasMora) == 0) {
                echo 'No hay datos para imprimir..';
                die();
            }

            foreach ($listaDiasMora as $key => $row) {
                $aux[$key] = $row['cliente'];
            }
            array_multisort($aux, SORT_ASC, $listaDiasMora);
            //--------------------


            for ($x = 0; $x < sizeof($listaDiasMora); $x ++) {

                $pdf->Cell(8, 8, utf8_decode($y), 'B', 0, 'L');
                $listaDiasMora[$x]['tipo_descripcion'] = substr($listaDiasMora[$x]['tipo_descripcion'], 0, 1);
                $pdf->Cell(5, 8, utf8_decode($listaDiasMora[$x]['tipo_descripcion']), 'B', 0, 'L');
                $ts = strlen($listaDiasMora[$x]['cliente']);
                if ($ts > 37) {
                    $pdf->SetFont('Arial', '', 5);
                    //  $listaDiasMora[$x]['cliente'] = substr($listaDiasMora[$x]['cliente'], 0, 37);
                }

                $pdf->Cell(70, 8, utf8_decode($listaDiasMora[$x]['cliente']), 'B', 0, 'L');

                $pdf->SetFont('Arial', '', 7);

                $ts = strlen($listaDiasMora[$x]['servicio']);
                if ($ts > 40) {
                    $pdf->SetFont('Arial', '', 5);
                    // $listaDiasMora[$x]['servicio'] = substr($listaDiasMora[$x]['servicio'], 0, 50);
                }
                $pdf->SetFont('Arial', '', 7);
                $pdf->Cell(70, 8, utf8_decode($listaDiasMora[$x]['servicio']), 'B', 0, 'L');
                //     $pdf->SetFont('Arial', '', 7);
                $pdf->Cell(20, 8, utf8_decode('$' . $listaDiasMora[$x]['precio']), 'B', 0, 'R');
                $pdf->Cell(20, 8, utf8_decode('$' . $listaDiasMora[$x]['abonado']), 'B', 0, 'R');
                $pdf->Cell(20, 8, utf8_decode('$' . $listaDiasMora[$x]['descuento']), 'B', 0, 'R');
                $pdf->Cell(20, 8, utf8_decode('$' . $listaDiasMora[$x]['saldo']), 'B', 0, 'R');
                $pdf->Cell(25, 8, utf8_decode($listaDiasMora[$x]['fecha_fin']), 'B', 0, 'C');
                $pdf->Cell(15, 8, utf8_decode($listaDiasMora[$x]['dias_mora']), 'B', 0, 'R');

                $y++;
                $pdf->Ln(8);
            }



            $response = new sfWebResponse($pdf->Output());
            $response->headers->set('Content-Type', 'application/pdf');
            return $response;
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
            $r = array("error" => true, "mensaje" => "Error Desconocido_02");
            return $this->sendJSON($r);
        }
    }

}
