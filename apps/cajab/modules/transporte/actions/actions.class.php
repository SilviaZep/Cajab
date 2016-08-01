<?php

/**
 * transporte actions.
 *
 * @package    puntoveta
 * @subpackage transporte
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class transporteActions extends baseCajabProjectActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $this->forward('default', 'module');
    }

    public function executeHorarios(sfWebRequest $request) {
        $this->setTemplate('horarios');
    }

    public function executeRutas(sfWebRequest $request) {
        $this->setTemplate('rutas');
    }

    public function executeListasRutas(sfWebRequest $request) {
        $this->setTemplate('listasRutas');
    }

    //-----------------FUNCIONES DE RUTAS----------------------------
    public function executeListadoRutasActivas(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');


                $nombreRuta = $request->getParameter("nombreRuta", "");
                $offset = $request->getParameter("offset", 0);
                $limit = $request->getParameter("limit", 0);



                $listaRutas = consultasBd::getListadoRutas((int) $limit, (int) $offset, $nombreRuta);

                $totalListaRutas = consultasBd::getTotalListadoRutas($nombreRuta);
                $totalListaRutas = $totalListaRutas[0]['total'];


                $r = array("mensaje" => "Ok", "listaRutas" => $listaRutas, "total" => $totalListaRutas); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "Error Desconocido", "valor" => "0"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    //listado de las rutas y sus totales de inscritos
    public function executeListadoRutas(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');
                $fechaActual = new DateTime();
                $fechaActual = $fechaActual->format('Y-m-d');


                $nombreRuta = $request->getParameter("nombreRuta", "");
                $offset = $request->getParameter("offset", 0);
                $limit = $request->getParameter("limit", 0);
                $fecha = $request->getParameter("fecha", 0);


                //---------Dia
                $diaSem = consultasBd::getDiaSemana($fecha);
                $diaSem = $diaSem[0]['dia'];

                $dia = '';
                switch ($diaSem) {
                    case '0':
                        $dia = "lun";
                        break;
                    case '1':
                        $dia = "mar";
                        break;
                    case '2':
                        $dia = "mie";
                        break;
                    case '3':
                        $dia = "jue";
                        break;
                    case '4':
                        $dia = "vie";
                        break;
                }

                if ($dia == '') {
                    echo "no hay servicio";
                    die();
                }
                //---------------


                if ($fechaActual > $fecha) {//dias pasados
                    $listaRutas = consultasBd::getListadoRutasAntiguas($fecha, $nombreRuta);
                    $totalListaRutas = consultasBd::getTotalListadoRutasAntiguas($fecha, $nombreRuta);
                    $totalListaRutas = $totalListaRutas[0]['total'];
                } else {//hoy o dias futuros
                    $listaRutas = consultasBd::getListadoRutas((int) $limit, (int) $offset, $nombreRuta);
                    //---------Cuantos llevan
                    for ($i = 0; $i < sizeof($listaRutas); $i++) {
                        $totalAlumRuta = consultasBd::getTotalListasInscritosDiaRuta($fecha, $dia, (int) $listaRutas[$i]['id']);
                        $listaRutas[$i]['tot_alum_ruta'] = $totalAlumRuta[0]['total'];
                    }

                    //-----------
                    $totalListaRutas = consultasBd::getTotalListadoRutas($nombreRuta);
                    $totalListaRutas = $totalListaRutas[0]['total'];
                }


                $r = array("mensaje" => "Ok", "listaRutas" => $listaRutas, "total" => $totalListaRutas); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "Error Desconocido", "valor" => "0"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    public function executeGuardarRuta(sfWebRequest $request) {//guarda y edita
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                // date_default_timezone_set('America/Mexico_City');

                $idRuta = $request->getParameter("mIdRuta", 0);
                $nombre = $request->getParameter("mNombre", 0);
                $descripcion = $request->getParameter("mDescripcion", 0);
                $horario = $request->getParameter("mHorario", 0);
                $capacidad = $request->getParameter("mCapacidad", 0);
                $conductor = $request->getParameter("mConductor", 0);


                if ($idRuta == 0) {
                    $rutaForm = new Ruta();
                } else {//Actualizar                     
                    $rutaForm = Doctrine::getTable('Ruta')->find((int) $idRuta);
                    if (!isset($rutaForm) || empty($rutaForm)) {
                        $r = array("mensaje" => "No se encuentra la ruta en la Base de Datos", 'error' => true);
                        return $this->sendJSON($r);
                    }
                }


                $rutaForm->setNombre($nombre);
                $rutaForm->setDescripcion($descripcion);
                $rutaForm->setHorario($horario);
                $rutaForm->setCapacidad((int) $capacidad);
                $rutaForm->setChofer($conductor);
                $rutaForm->setEstatus(1);
                $rutaForm->save();

                $r = array("mensaje" => "Ok", 'error' => false); //a partir de php 5.4 es con corchetes[]
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

    public function executeEliminarRuta(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {
                $idRuta = $request->getParameter("idRuta", 0);
                $rutaForm = Doctrine::getTable('Ruta')->find((int) $idRuta);

                if (!isset($rutaForm) || empty($rutaForm)) {
                    $r = array("mensaje" => "No se encuentra el servicio en la Base de Datos", 'error' => true);
                    return $this->sendJSON($r);
                }
                $rutaForm->setEstatus(0);
                $rutaForm->save();

                $r = array("mensaje" => "Ok", 'error' => false); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    //---------------Horarios

    public function executeHorariosAlumnos(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {
                $nombre = $request->getParameter("nombre", "");
                $limit = $request->getParameter("limit", 0);
                $offset = $request->getParameter("offset", 0);

                $generarHorarios = consultasBd::getGenerarHorariosActivos();

                $idsAlumnos = "";
                if ($nombre != "") {
                    $buscados = consultasInstituto::getIdsAlumnos($nombre);
                    $tam = sizeof($buscados);
                    for ($i = 0; $i < $tam; $i ++) {
                        if ($tam == 1) {//si solo tienen uno 
                            $idsAlumnos = $buscados[$i]['idalumno'];
                        } else {
                            if (($tam - 1) == $i) {
                                $idsAlumnos = $idsAlumnos . $buscados[$i]['idalumno'];
                            } else {
                                $idsAlumnos = $idsAlumnos . $buscados[$i]['idalumno'] . ",";
                            }
                        }
                    }
                }



                $listaHorarios = consultasBd::getHorariosAlumnos((int) $limit, (int) $offset, $idsAlumnos);
                $totalListaHorarios = consultasBd::getTotalHorariosAlumnos($idsAlumnos);
                for ($i = 0; $i < sizeof($listaHorarios); $i ++) {
                    $vecNombreAlumno = consultasInstituto::getAlumnoXId($listaHorarios[$i]['id_alumno']);
                    $listaHorarios[$i]['nombre'] = $vecNombreAlumno[0]['nombre'];
                }

                $totalListaHorarios = $totalListaHorarios[0]['total'];


                $r = array("mensaje" => "Ok", "listaHorarios" => $listaHorarios, "total" => $totalListaHorarios); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    public function executeCambiarHorarioAlumno(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');
                $fechaActual = new DateTime();

                $idHorario = $request->getParameter("idHorario", 0);

                $rutaLunE = $request->getParameter("rutaLunE", 0);
                $rutaLunS = $request->getParameter("rutaLunS", 0);
                $rutaMarE = $request->getParameter("rutaMarE", 0);
                $rutaMarS = $request->getParameter("rutaMarS", 0);
                $rutaMieE = $request->getParameter("rutaMieE", 0);
                $rutaMieS = $request->getParameter("rutaMieS", 0);
                $rutaJueE = $request->getParameter("rutaJueE", 0);
                $rutaJueS = $request->getParameter("rutaJueS", 0);
                $rutaVieE = $request->getParameter("rutaVieE", 0);
                $rutaVieS = $request->getParameter("rutaVieS", 0);

                $horarioForm = Doctrine::getTable('HorarioRuta')->find((int) $idHorario);

                if (!isset($horarioForm) || empty($horarioForm)) {
                    $r = array("mensaje" => "No se encuentra el horario en la Base de Datos", 'error' => true);
                    return $this->sendJSON($r);
                }

                $horarioForm->setRLunE((int) $rutaLunE);
                $horarioForm->setRLunS((int) $rutaLunS);
                $horarioForm->setRMarE((int) $rutaMarE);
                $horarioForm->setRMarS((int) $rutaMarS);
                $horarioForm->setRMieE((int) $rutaMieE);
                $horarioForm->setRMieS((int) $rutaMieS);
                $horarioForm->setRJueE((int) $rutaJueE);
                $horarioForm->setRJueS((int) $rutaJueS);
                $horarioForm->setRVieE((int) $rutaVieE);
                $horarioForm->setRVieS((int) $rutaVieS);

                $horarioForm->setFechaRegistro($fechaActual->format('Y-m-d H:i:s'));
                $horarioForm->setUsuarioRegistro((int) $this->getUser()->getUserId());
                $horarioForm->save();




                $r = array("mensaje" => "Actualizacion de horario completada correctamente", "error" => false); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    public function executeAlumnosPorRutaDia(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');
                $fechaActual = new DateTime();

                $fecha = $request->getParameter("fecha", 0);
                $idRuta = $request->getParameter("idRuta", 0);

                $diaSem = consultasBd::getDiaSemana($fecha);
                $diaSem = $diaSem[0]['dia'];

                $dia = '';
                switch ($diaSem) {
                    case '0':
                        $dia = "lun";
                        break;
                    case '1':
                        $dia = "mar";
                        break;
                    case '2':
                        $dia = "mie";
                        break;
                    case '3':
                        $dia = "jue";
                        break;
                    case '4':
                        $dia = "vie";
                        break;
                }

                if ($dia == '') {
                    echo "no hay servicio";
                    die();
                }


                $listaAlumnos = consultasBd::getListasInscritosDiaRuta($fecha, $dia, (int) $idRuta);
                for ($i = 0; $i < sizeof($listaAlumnos); $i ++) {
                    $vecNombreAlumno = consultasInstituto::getAlumnoXId($listaAlumnos[$i]['id_alumno']);
                    $listaAlumnos[$i]['nombre'] = $vecNombreAlumno[0]['nombre'];
                }


                //$totalListaInscritos = consultasBd::getTotalHorariosAlumnos($nombre);
                //$totalListaHorarios = $totalListaHorarios[0]['total'];


                $r = array("mensaje" => "Ok", "listaAlumnos" => $listaAlumnos, "total" => 10); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    //----------guardarAlumnos Eventuales

    public function executeGuardarAlumnosEventuales(sfWebRequest $request) {//guarda y edita
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                // date_default_timezone_set('America/Mexico_City');

                $idAlumnos = $request->getParameter("idAlumnos", "");
                $idRuta = $request->getParameter("idRuta", 0);
                $fecha = $request->getParameter("fecha", 0);


                if (!empty($idAlumnos)) {
                    $vecAlumnos = explode(",", $idAlumnos);
                    $max = (sizeof($vecAlumnos) - 1); //agarra uno de mas   

                    for ($i = 0; $i < $max; $i++) {
                        $instListaRuta = new ListaRuta();
                        $instListaRuta->setIdAlumno((int) $vecAlumnos[$i]);
                        $instListaRuta->setIdRuta((int) $idRuta);
                        $instListaRuta->setFecha($fecha);
                        $instListaRuta->setEstatus(1); //0.-Iniciado 1.-Guardado 2.- Eliminado
                        $instListaRuta->setTipo(3); //1.-Completo 2.-Medio 3.- Eventual                        
                        $instListaRuta->save();
                    }
                }


                $r = array("mensaje" => "Agregados correctamente", 'error' => false); //a partir de php 5.4 es con corchetes[]
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

    public function executeEliminarAlumnoEventual(sfWebRequest $request) {//guarda y edita
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                // date_default_timezone_set('America/Mexico_City');

                $idAlumnoEventual = $request->getParameter("idAlumnoEventual", 0);

                $instListaRuta = Doctrine::getTable('ListaRuta')->find((int) $idAlumnoEventual);
                $instListaRuta->delete();



                $r = array("mensaje" => "Eliminado correctamente", 'error' => false); //a partir de php 5.4 es con corchetes[]
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

    //-----------------FIN FUNCIONES DE RUTAS------------------------------------------------------
    //-------------Guardar Rutas-----------------------
    public function executeGuardarListasPorRuta(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');
                $fechaActual = new DateTime();
                $fechaActual = $fechaActual->format('Y-m-d');

                $fecha = $request->getParameter("fecha", 0);

                $listaRutas = consultasBd::getListadoRutas((int) 100, (int) 0, "");
                //---------Cuantos llevan
                for ($i = 0; $i < sizeof($listaRutas); $i++) {
                    $flagConsulta = consultasBd::getGuardarListasPorRuta($fecha, (int) $listaRutas[$i]['id']);
                }

                $r = array("mensaje" => "Las listas se guardaron correctamente"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "Error Desconocido", "valor" => "0"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    public function executeVerificaGuardado(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');
                $fechaActual = new DateTime();
                $fechaActual = $fechaActual->format('Y-m-d');

                $fecha = $request->getParameter("fecha", 0);



                $flag = false; //no esta guardado
                $total = consultasBd::getVerificarGuardado($fecha);
                $total = $total[0]['total'];
                if ($total > 0) {
                    $flag = true; //ya esta guardado
                }

                $r = array("guardado" => $flag);
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "Error Desconocido", "valor" => "0"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    //-------------------------------------------------------

    public function executeImprimirRutasAlumnos(sfWebRequest $request) {

        date_default_timezone_set('America/Mexico_City');
        $fechaActual = new DateTime();

        $fecha = $request->getParameter("fecha", 0);
        $idRuta = $request->getParameter("idRuta");
        //$idRuta=0;
        //$fecha=date('Y-m-d');

        $diaSem = consultasBd::getDiaSemana($fecha);
        $diaSem = $diaSem[0]['dia'];

        $dia = '';
        switch ($diaSem) {
            case '0':
                $dia = "lun";
                break;
            case '1':
                $dia = "mar";
                break;
            case '2':
                $dia = "mie";
                break;
            case '3':
                $dia = "jue";
                break;
            case '4':
                $dia = "vie";
                break;
        }

        if ($dia == '') {
            echo "no hay servicio";
            die();
        }
        //$pdf = new \FPDF ();
        $pdf = new FPDF ();

        //$pdf->AddPage ('L');
        $pdf->AddPage();
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 18);
        $pdf->SetTextColor(88, 89, 91);
        $pdf->Cell(0, 8, utf8_decode('Listado de Rutas'), 'B', 0, 'C');
        $pdf->Ln(15);

        if (isset($idRuta) && $idRuta > 0) {
            $listaAlumnos = consultasBd::getListasInscritosDiaRuta($fecha, $dia, (int) $idRuta);
            for ($i = 0; $i < sizeof($listaAlumnos); $i ++) {
                $vecNombreAlumno = consultasInstituto::getAlumnoXId($listaAlumnos[$i]['id_alumno']);
                $listaAlumnos[$i]['nombre'] = $vecNombreAlumno[0]['nombre'];
            }
            //  $rutaDetail = Doctrine::getTable('Ruta')->find((int) $idRuta);
            //print_r($listaAlumnos);die();    			
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetTextColor(88, 89, 91);
            $pdf->Cell(50, 8, utf8_decode('Ruta: ' . $listaRutas[$i]['nombre']), 'B', 0, 'L');
            $pdf->Cell(50, 8, utf8_decode('Horario: ' . $listaRutas[$i]['horario']), 'B', 0, 'L');
            $pdf->Cell(40, 8, utf8_decode('Fecha: ' . $fecha), 'B', 0, 'L');
            $pdf->Cell(50, 8, utf8_decode('Conductor: ' . $listaRutas[$i]['chofer']), 'B', 0, 'L');
            $pdf->Ln(8);
            $this->pdfListaAlumnos($pdf, $listaAlumnos);
        } else {
            $listaRutas = consultasBd::getListadoRutas((int) 100, (int) 0, "");

            $y = 1;
            for ($i = 0; $i < sizeof($listaRutas); $i ++) {
                //$rutaDetail = Doctrine::getTable('Ruta')->find((int) $listaRutas[$i]['id']);

                $listaAlumnos = consultasBd::getListasInscritosDiaRuta($fecha, $dia, (int) $listaRutas[$i]['id']);
                for ($j = 0; $j < sizeof($listaAlumnos); $j ++) {
                    $vecNombreAlumno = consultasInstituto::getAlumnoXId($listaAlumnos[$j]['id_alumno']);
                    $listaAlumnos[$j]['nombre'] = $vecNombreAlumno[0]['nombre'];
                }
                if (sizeof($listaAlumnos) > 0) {
                    if ($y == 1) {//si es la primera fila 
                        $y = 2;
                    } else {
                        $pdf->Ln(30);
                    }
                    $pdf->SetFont('Arial', '', 18);
                    $pdf->SetTextColor(88, 89, 91);
                    $pdf->Cell(0, 8, utf8_decode(''), 'B', 0, 'C');
                    $pdf->Ln(10);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->SetTextColor(88, 89, 91);
                    $pdf->Cell(50, 8, utf8_decode('Ruta: ' . $listaRutas[$i]['nombre']), 'B', 0, 'L');
                    $pdf->Cell(50, 8, utf8_decode('Horario: ' . $listaRutas[$i]['horario']), 'B', 0, 'L');
                    $pdf->Cell(40, 8, utf8_decode('Fecha: ' . $fecha), 'B', 0, 'L');
                    $pdf->Cell(50, 8, utf8_decode('Conductor: ' . $listaRutas[$i]['chofer']), 'B', 0, 'L');
                    $pdf->Ln(15);
                    $this->pdfListaAlumnos($pdf, $listaAlumnos);
                    // $y++;
                    //if ($y <= sizeof($listaRutas)) {
                    //$pdf->AddPage();
                    // }
                }
            }
        }


        $response = new sfWebResponse($pdf->Output());
        $response->headers->set('Content-Type', 'application/pdf');
        return $response;
    }

    private function pdfListaAlumnos($pdf, $listaAlumnos) {
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFillColor(136, 138, 140);
        $pdf->Cell(20, 8, utf8_decode("#"), 'B', 0, 'L', true);
        $pdf->Cell(110, 8, utf8_decode("Alumno"), 'B', 0, 'L', true);
        $pdf->Cell(30, 8, utf8_decode("Tipo"), 'B', 0, 'L', true);
        $pdf->Cell(30, 8, utf8_decode("Observaciones   " . ": "), 'B', 0, 'L', true);
        $pdf->Ln(8);

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(88, 89, 91);
        $y = 1;
        for ($x = 0; $x < sizeof($listaAlumnos); $x ++) {
            $pdf->Cell(20, 8, utf8_decode($y), 'B', 0, 'L');
            $pdf->Cell(110, 8, utf8_decode($listaAlumnos[$x]['nombre']), 'B', 0, 'L');
            $pdf->Cell(30, 8, utf8_decode($listaAlumnos[$x]['tipo_transporte']), 'B', 0, 'L');
            $pdf->Cell(30, 8, utf8_decode(""), 'B', 0, 'L');
            $y++;
            $pdf->Ln(8);
        }
    }

}
