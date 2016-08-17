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
    


}
