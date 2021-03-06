<?php

/**
 * servicios actions.
 *
 * @package    puntoveta
 * @subpackage servicios
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class serviciosActions extends baseCajabProjectActions {

    public function executeIndex(sfWebRequest $request) {
        $this->setTemplate('servicios');
    }

    public function executeAsignarServicios(sfWebRequest $request) {
        $this->setTemplate('asignarServicios');
    }

    public function executeAsignarAlumnoServicio(sfWebRequest $request) {
        $this->setTemplate('asignarAlumnoServicio');
    }

    public function executeGuardarNuevoServicio(sfWebRequest $request) {//guarda y edita
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');

                $idServicio = $request->getParameter("mIdServicio", 0);
                $categoria = $request->getParameter("mCategoria", 0);
                $nombre = $request->getParameter("mNombre", 0);
                $precio = $request->getParameter("mPrecio", 0);
                //   $pagoObligarotio = $request->getParameter("mPagoObligarotio", 0);
                $aplicaParcialidad = $request->getParameter("mAplicaParcialidad", 0);
                $fechaEvento = $request->getParameter("mFechaEvento", 0);
                $fechaIni = $request->getParameter("mFechaIni", 0);
                $fechaFin = $request->getParameter("mFechaFin", 0);
                $tipoClientes = $request->getParameter("mTipoClientes", 0);
                $capacidad = $request->getParameter("mCapacidad", 0);
                $tipoTransporte = $request->getParameter("mTipoServicio", 0);

                $ciclo = $request->getParameter("mselCiclo", 0); // id de los grados y grupos 
                $grado = $request->getParameter("mselGrado", 0);
                $grupo = $request->getParameter("mselGrupo", 0);



                $idServicioReferencia = $request->getParameter("mIdServicioReferencia", 0); //CLONAR
                $idServicioPadre = $request->getParameter("mIdServicioPadre", 0); //HIJO


                $fechaActual = new DateTime();
                $fechaEvento = new DateTime($fechaEvento);
                $fechaIni = new DateTime($fechaIni);
                $fechaFin = new DateTime($fechaFin);

                if ($idServicio == 0) {
                    $servicioForm = new Servicio();
                } else {//Actualizar                     
                    $servicioForm = Doctrine::getTable('Servicio')->find((int) $idServicio);
                    if (!isset($servicioForm) || empty($servicioForm)) {
                        $r = array("mensaje" => "No se encuentra el servicio en la Base de Datos", 'error' => true);
                        return $this->sendJSON($r);
                    }
                }


                $servicioForm->setCategoriaId((int) $categoria);
                $servicioForm->setNombre(utf8_decode($nombre));
                $servicioForm->setPrecio((double) $precio);
                //$servicioForm->setPagoObligatorio((int) $pagoObligarotio);
                $servicioForm->setAplicaParcialidad((int) $aplicaParcialidad);
                $servicioForm->setFechaEvento($fechaEvento->format('Y-m-d'));
                $servicioForm->setFechaInicio($fechaIni->format('Y-m-d'));
                $servicioForm->setFechaFin($fechaFin->format('Y-m-d'));
                $servicioForm->setUsuarioRegistro((int) $this->getUser()->getUserId());
                $servicioForm->setFechaRegistro($fechaActual->format('Y-m-d H:i:s'));
                $servicioForm->setActivo(1);
                $servicioForm->setTipoCliente((int) $tipoClientes);
                $servicioForm->setCapacidad((int) $capacidad);
                // $servicioForm->setIdServicio(null);
                $servicioForm->setTipoTransporte((int) $tipoTransporte);
                $servicioForm->setCicloId((int) $ciclo);
                $servicioForm->setGradoId((int) $grado);
                $servicioForm->setGrupoId((int) $grupo);

                $servicioForm->save();


                if ($idServicioReferencia != 0) {//clonar servicios
                    $servicioReferencia = Doctrine::getTable('Servicio')->find((int) $idServicioReferencia);
                    $idServPadre = $servicioReferencia->getIdServicio();
                    $servicioForm->setIdServicio((int) $idServPadre);
                    $servicioForm->save();
                    $clon = consultasBd::getClonarServicio((int) $idServicioReferencia, (int) $servicioForm->getId(), (int) $this->getUser()->getUserId());
                }
                if ($idServicioPadre != 0) {//Servicio Hijo
                    $servicioForm->setIdServicio((int) $idServicioPadre);
                    $servicioForm->save();
                }

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

    public function executeListadoServicios(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');

                $fechaIni = $request->getParameter("fechaIni", 0);
                $fechaFin = $request->getParameter("fechaFin", 0);
                $nombreServicio = $request->getParameter("nombreServicio", "");
                $offset = $request->getParameter("offset", 0);
                $limit = $request->getParameter("limit", 0);
                $categoria = $request->getParameter("categoria", 0);




                $listaServicios = consultasBd::getListadoServicios($fechaIni, $fechaFin, (int) $limit, (int) $offset, $nombreServicio, (int) $categoria);
                $totalListaServicios = consultasBd::getTotalListadoServicios($fechaIni, $fechaFin, $nombreServicio, (int) $categoria);
                $totalListaServicios = $totalListaServicios[0]['total'];


                $r = array("mensaje" => "Ok", "listaServicios" => $listaServicios, "total" => $totalListaServicios); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "Error Desconocido", "valor" => "0"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    public function executeEliminarServicio(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {
                $idServicio = $request->getParameter("idServicio", 0);


                $servicioForm = Doctrine::getTable('Servicio')->find((int) $idServicio);
                if (!isset($servicioForm) || empty($servicioForm)) {
                    $r = array("mensaje" => "No se encuentra el servicio en la Base de Datos", 'error' => true);
                    return $this->sendJSON($r);
                }
                $servicioForm->setActivo(0);
                $servicioForm->save();

                $r = array("mensaje" => "Ok", 'error' => false); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    public function executeListadoCategoriasServicios(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                $listaCategoriasServicios = consultasBd::getListadoCategoriasServicios();
                $r = array("mensaje" => "Ok", 'error' => false, "listaCategoriaServicios" => $listaCategoriasServicios); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "Ocurrio un problema en la consulta de las categorias", 'error' => true, "valor" => "0"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    //----------------Asingar servicios------------------

    public function executeListadoServiciosVigentes(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');


                $nombreServicio = $request->getParameter("nombreServicio", "");
                $offset = $request->getParameter("offset", 0);
                $limit = $request->getParameter("limit", 0);
                $categoria = $request->getParameter("categoria", 0);


                $listaServicios = consultasBd::getListadoServiciosVigentes((int) $limit, (int) $offset, $nombreServicio, (int) $categoria);
                $totalListaServicios = consultasBd::getTotalListadoServiciosVigentes($nombreServicio, (int) $categoria);
                $totalListaServicios = $totalListaServicios[0]['total'];


                $r = array("mensaje" => "Ok", "listaServicios" => $listaServicios, "total" => $totalListaServicios); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "Error Desconocido", "valor" => "0"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    //------------------Fin asignar servicios------------------
    //listado Alumnos
    public function executeListadoAlumnos(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');


                $nombreAlumno = $request->getParameter("nombreAlumno", "");
                $idServicio = $request->getParameter("idServicio", 0);
                $idCategoria = $request->getParameter("idCategoria", 0); //si es false se toman en cuenta los que ya estan en el servicio
                $offset = $request->getParameter("offset", 0);
                $limit = $request->getParameter("limit", 0);
                $tipoTransporte = $request->getParameter("tipoTransporte", 0);

                $flagVenta = false;
                if ($idCategoria == 4 || ($idCategoria == 1 && $tipoTransporte == 3)) {//Ventas esta en id:4 hay que revisar cuando este en produccion
                    $flagVenta = true;
                }
                $idPapa = 0;
                if (((int) $idServicio) > 0) {
                    $servicioForm = Doctrine::getTable('Servicio')->find((int) $idServicio);
                    $idPapa = $servicioForm->getIdServicio();
                }


                $listaAlumnos = consultasBd::getListadoAlumnos((int) $limit, (int) $offset, $nombreAlumno, (int) $idServicio, $flagVenta, $idPapa);
                $totalListaAlumnos = consultasBd::getTotalListadoAlumnos($nombreAlumno, (int) $idServicio, $flagVenta, $idPapa);
                $totalListaAlumnos = $totalListaAlumnos[0]['total'];


                $r = array("mensaje" => "Ok", "listaAlumnos" => $listaAlumnos, "total" => $totalListaAlumnos); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "Error Desconocido", "valor" => "0"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    //************
    //listado Clientes Externos
    public function executeListadoClientesExternos(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');


                $nombreCliente = $request->getParameter("nombreCliente", "");
                $offset = $request->getParameter("offset", 0);
                $limit = $request->getParameter("limit", 0);

                $idServicio = $request->getParameter("idServicio", 0);
                $idCategoria = $request->getParameter("idCategoria", 0); //si es false se toman en cuenta los que ya estan en el servicio
                $tipoTransporte = $request->getParameter("tipoTransporte", 0);
                $flagVenta = false;

                if ($idCategoria == 4 || ($idCategoria == 1 && $tipoTransporte == 3)) {//Ventas esta en id:4 hay que revisar cuando este en produccion
                    $flagVenta = true;
                }

                $idPapa = 0;
                if (((int) $idServicio) > 0) {
                    $servicioForm = Doctrine::getTable('Servicio')->find((int) $idServicio);
                    $idPapa = $servicioForm->getIdServicio();
                }



                $listaClientes = consultasBd::getListadoClientesExternos((int) $limit, (int) $offset, $nombreCliente, (int) $idServicio, $flagVenta, $idPapa);
                $totalListaClientes = consultasBd::getTotalListadoClientesExternos($nombreCliente, (int) $idServicio, $flagVenta, $idPapa);
                $totalListaClientes = $totalListaClientes[0]['total'];


                $r = array("mensaje" => "Ok", "listaClientes" => $listaClientes, "total" => $totalListaClientes); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "Error Desconocido", "valor" => "0"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    //*********************Asignar Alumnos a Servicio******************************
    public function executeAsignarAlumnosServicio(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');
                $fechaActual = new DateTime();

                $idAlumnos = $request->getParameter("idAlumnos", "");
                $idServicio = $request->getParameter("idServicio", 0);
                $noRepeticion = $request->getParameter("noRepeticion", 1);

                for ($a = 0; $a < $noRepeticion; $a++) {

                    if (!empty($idAlumnos)) {
                        $vecAlumnos = explode(",", $idAlumnos);
                        $max = (sizeof($vecAlumnos) - 1); //agarra uno de mas   

                        $serviciosHijos = consultasBd::getListaServiciosHijos((int) $idServicio);
                        $totHijos = sizeof($serviciosHijos); //agarra uno de mas 

                        for ($i = 0; $i < $max; $i++) {
                            $instServicioCliente = new ServicioCliente();
                            $instServicioCliente->setIdServicio((int) $idServicio);
                            $instServicioCliente->setIdAlumno((int) $vecAlumnos[$i]);
                            $instServicioCliente->setFechaRegistro($fechaActual->format('Y-m-d H:i:s'));
                            $instServicioCliente->setUsuarioRegistro($this->getUser()->getUserId());
                            $instServicioCliente->setTipoCliente(1); //1.- Alumno; 2.- Cliente Externo
                            $instServicioCliente->setEstatus(1); //1.- PAGANDO; 2.- PAGADO;3.-Cancelado; 4.-Condonado
                            $instServicioCliente->save();

                            if ($totHijos > 0) {
                                for ($j = 0; $j < $totHijos; $j++) {
                                    $instServicioClienteHijo = new ServicioCliente();
                                    $instServicioClienteHijo->setIdServicio((int) $serviciosHijos[$j]['id']);
                                    $instServicioClienteHijo->setIdAlumno((int) $vecAlumnos[$i]);
                                    $instServicioClienteHijo->setFechaRegistro($fechaActual->format('Y-m-d H:i:s'));
                                    $instServicioClienteHijo->setUsuarioRegistro($this->getUser()->getUserId());
                                    $instServicioClienteHijo->setTipoCliente(1); //1.- Alumno; 2.- Cliente Externo
                                    $instServicioClienteHijo->setEstatus(1); //1.- PAGANDO; 2.- PAGADO;3.-Cancelado; 4.-Condonado
                                    $instServicioClienteHijo->save();
                                }
                            }
                        }
                    }
                }

                $r = array("error" => false, "mensaje" => "Guardados Correctamente");
                return $this->sendJSON($r);
            } else {
                $r = array("error" => true, "mensaje" => "Error_01: no se pudo guardardaron los valores seleccionados"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            //throw new sfException($e);
            $r = array("error" => true, "mensaje" => "Error_02: no se pudo guardardaron los valores seleccionados");
            return $this->sendJSON($r);
        }
    }

    public function executeAsignarClientesServicio(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');
                $fechaActual = new DateTime();

                $idClientes = $request->getParameter("idClientes", "");
                $idServicio = $request->getParameter("idServicio", 0);
                $noRepeticion = $request->getParameter("noRepeticion", 1);

                for ($a = 0; $a < $noRepeticion; $a++) {


                    if (!empty($idClientes)) {
                        $vecClientes = explode(",", $idClientes);
                        $max = (sizeof($vecClientes) - 1); //agarra uno de mas   

                        $serviciosHijos = consultasBd::getListaServiciosHijos((int) $idServicio);
                        $totHijos = sizeof($serviciosHijos); //agarra uno de mas 

                        for ($i = 0; $i < $max; $i++) {
                            $instServicioCliente = new ServicioCliente();
                            $instServicioCliente->setIdServicio((int) $idServicio);
                            $instServicioCliente->setIdCliente((int) $vecClientes[$i]);
                            $instServicioCliente->setFechaRegistro($fechaActual->format('Y-m-d H:i:s'));
                            $instServicioCliente->setUsuarioRegistro($this->getUser()->getUserId());
                            $instServicioCliente->setTipoCliente(2); //1.- Alumno; 2.- Cliente Externo
                            $instServicioCliente->setEstatus(1); //1.- PAGANDO; 2.- PAGADO;3.-Cancelado; 4.-Condonado
                            $instServicioCliente->save();

                            if ($totHijos > 0) {
                                for ($j = 0; $j < $totHijos; $j++) {
                                    $instServicioClienteHijo = new ServicioCliente();
                                    $instServicioClienteHijo->setIdServicio((int) $serviciosHijos[$j]['id']);
                                    $instServicioClienteHijo->setIdCliente((int) $vecClientes[$i]);
                                    $instServicioClienteHijo->setFechaRegistro($fechaActual->format('Y-m-d H:i:s'));
                                    $instServicioClienteHijo->setUsuarioRegistro($this->getUser()->getUserId());
                                    $instServicioClienteHijo->setTipoCliente(2); //1.- Alumno; 2.- Cliente Externo
                                    $instServicioClienteHijo->setEstatus(1); //1.- PAGANDO; 2.- PAGADO;3.-Cancelado; 4.-Condonado
                                    $instServicioClienteHijo->save();
                                }
                            }
                        }
                    }
                }

                $r = array("error" => false, "mensaje" => "Guardados Correctamente");
                return $this->sendJSON($r);
            } else {
                $r = array("error" => true, "mensaje" => "Error_01: no se pudo guardardaron los valores seleccionados"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            //throw new sfException($e);
            $r = array("error" => true, "mensaje" => "Error_02: no se pudo guardardaron los valores seleccionados");
            return $this->sendJSON($r);
        }
    }

    //----------Asignados a un servicio en especifico

    public function executeAsignadosAServicio(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');


                $nombreCliente = $request->getParameter("nombreCliente", "");
                $idServicio = $request->getParameter("idServicio", 0);
                //$offset = $request->getParameter("offset", 0);
                //$limit = $request->getParameter("limit", 0);
                $offset = 0;
                $limit = 10000;


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



                $listaAsignados = consultasBd::getListaAsignadosServicio((int) $idServicio, $nombreCliente, (int) $limit, (int) $offset);
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

                $totalListaAsignados = consultasBd::getTotalListaAsignadosServicio((int) $idServicio, $nombreCliente);
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
            //throw new sfException($e);
            $r = array("error" => true, "mensaje" => "Error Desconocido_02");
            return $this->sendJSON($r);
        }
    }

    public function executeCambiarEstatusServicioCliente(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {
                $idServicioCliente = $request->getParameter("idServicioCliente", 0);
                $estatus = $request->getParameter("estatus", 0);


                $servicioClienteForm = Doctrine::getTable('ServicioCliente')->find((int) $idServicioCliente);
                if (!isset($servicioClienteForm) || empty($servicioClienteForm)) {
                    $r = array("mensaje" => "No se encuentra el servicio en la Base de Datos", 'error' => true);
                    return $this->sendJSON($r);
                }
                $servicioClienteForm->setEstatus((int) $estatus);
                $servicioClienteForm->save();

                $r = array("mensaje" => "Actualizado correctamente", 'error' => false); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    public function executeImprimirAsignadosAServicio(sfWebRequest $request) {
        try {


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
                // if ($tam > 0) {
                $flagFiltroNombre = true;
                //  }
            }



            $listaAsignados = consultasBd::getListaAsignadosServicio((int) $idServicio, $nombreCliente, (int) $limit, (int) $offset);
            for ($i = 0; $i < sizeof($listaAsignados); $i ++) {
                if ($listaAsignados[$i]['cliente'] == "na" && $listaAsignados[$i]['tipo_descripcion'] == "Alumno") {
                    $vecNombreAlumno = consultasInstituto::getAlumnoXId($listaAsignados[$i]['id_alumno']);
                    $listaAsignados[$i]['cliente'] = $vecNombreAlumno[0]['nombre'];
                    if ($flagFiltroNombre) {
                        for ($j = 0; $j < $tam; $j ++) {
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

            $totalListaAsignados = consultasBd::getTotalListaAsignadosServicio((int) $idServicio, $nombreCliente);
            $totalListaAsignados = $totalListaAsignados[0]['total'];


            if ($flagFiltroNombre) {
                $listaAsignados = $listaAsignadosFiltro;
                $totalListaAsignados = $count;
            }


            $pdf = new FPDF ();

            $pdf->AddPage();
            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 12);
            $pdf->SetTextColor(88, 89, 91);
            $pdf->Cell(0, 8, utf8_decode($listaAsignados[0]['categoria_servicio'] . " - " . $listaAsignados[0]['nombre_servicio']), 'B', 0, 'C');
            $pdf->Ln(15);

            $this->pdfListaAsignados($pdf, $listaAsignados);




            $response = new sfWebResponse($pdf->Output());
            $response->headers->set('Content-Type', 'application/pdf');
            return $response;
        } catch (Doctrine_Exception $e) {
            //throw new sfException($e);
            $r = array("error" => true, "mensaje" => "Error Desconocido_02");
            return $this->sendJSON($r);
        }
    }

    private function pdfListaAsignados($pdf, $listaAsignados) {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFillColor(136, 138, 140);
        $pdf->Cell(20, 8, utf8_decode("#"), 'B', 0, 'L', true);
        $pdf->Cell(30, 8, utf8_decode("Tipo Cliente"), 'B', 0, 'L', true);
        $pdf->Cell(110, 8, utf8_decode("Nombre"), 'B', 0, 'L', true);
        $pdf->Cell(30, 8, utf8_decode("Estatus   "), 'B', 0, 'L', true);
        $pdf->Ln(8);

        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor(88, 89, 91);
        $y = 1;
        for ($x = 0; $x < sizeof($listaAsignados); $x ++) {
            $pdf->Cell(20, 8, utf8_decode($y), 'B', 0, 'L');
            $pdf->Cell(30, 8, utf8_decode($listaAsignados[$x]['tipo_descripcion']), 'B', 0, 'L');
            $pdf->Cell(110, 8, utf8_decode($listaAsignados[$x]['cliente']), 'B', 0, 'L');
            $pdf->Cell(30, 8, utf8_decode($listaAsignados[$x]['estatus_descripcion']), 'B', 0, 'L');
            $y++;
            $pdf->Ln(8);
        }
    }

    public function executeServiciosAplicanAlumno(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');

                $idAlumno = $request->getParameter("idAlumno", 0);
                $idCiclo = $request->getParameter("idCiclo", 0);
                $idGrado = $request->getParameter("idGrado", 0);
                $idGrupo = $request->getParameter("idGrupo", 0);
                $nombreServicio = $request->getParameter("nombreServicio", "");

                $listaServicios = consultasBd::getListadoServiciosAplicanAlumno($idAlumno, $idCiclo, $idGrado, $idGrupo, $nombreServicio);
                $totalListaServicios = consultasBd::getTotalListadoServiciosAplicanAlumno($idAlumno, $idCiclo, $idGrado, $idGrupo, $nombreServicio);
                $totalListaServicios = $totalListaServicios[0]['total'];


                $r = array("mensaje" => "Ok", "listaServicios" => $listaServicios, "total" => $totalListaServicios); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "Error Desconocido", "valor" => "0"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    public function executeAsignarServicioSeleccionados(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');
                $fechaActual = new DateTime();

                $idAlumno = $request->getParameter("idAlumno", 0);
                $seleccionados = $request->getParameter("seleccionados", "");


                $vecServicios = explode(",", $seleccionados);
                $max = (sizeof($vecServicios) - 1); //agarra uno de mas  

                for ($i = 0; $i < $max; $i++) {
                    $servicioCliente = new ServicioCliente();
                    $servicioCliente->setIdServicio((int) $vecServicios[$i]);
                    $servicioCliente->setIdAlumno((int) $idAlumno);
                    $servicioCliente->setFechaRegistro($fechaActual->format('Y-m-d H:i:s'));
                    $servicioCliente->setUsuarioRegistro($this->getUser()->getUserId());
                    $servicioCliente->setTipoCliente(1); //1.- Alumno; 2.- Cliente Externo
                    $servicioCliente->setEstatus(1); //1.- PAGANDO; 2.- PAGADO;3.-Cancelado; 4.-Condonado
                    $servicioCliente->save();
                }


                $r = array("mensaje" => "Ok"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            } else {
                $r = array("mensaje" => "Error Desconocido", "valor" => "0"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    /* Clonar servicio padre y sus hijos; con la fecha actual */

    public function executeClonarActualEHijos(sfWebRequest $request) {
        try {
            if ($request->isMethod(sfWebRequest::POST)) {

                date_default_timezone_set('America/Mexico_City');
                $fechaActual = new DateTime();


                $idServicio = $request->getParameter("idServicio", 0);

                if ($idServicio > 0) {
                    $servicioFormOriginal = Doctrine::getTable('Servicio')->find((int) $idServicio);


                    $instServicioClon = new Servicio(); // servicio clon

                    $instServicioClon->setCategoriaId($servicioFormOriginal->getCategoriaId());
                    $instServicioClon->setNombre($servicioFormOriginal->getNombre()."_copia");
                    $instServicioClon->setPrecio($servicioFormOriginal->getPrecio());
                    $instServicioClon->setAplicaParcialidad($servicioFormOriginal->getAplicaParcialidad());
                    $instServicioClon->setFechaEvento($fechaActual->format('Y-m-d'));
                    $instServicioClon->setFechaInicio($fechaActual->format('Y-m-d'));
                    $instServicioClon->setFechaFin($fechaActual->format('Y-m-d'));
                    $instServicioClon->setUsuarioRegistro((int) $this->getUser()->getUserId());
                    $instServicioClon->setFechaRegistro($fechaActual->format('Y-m-d H:i:s'));
                    $instServicioClon->setActivo(1);
                    $instServicioClon->setTipoCliente($servicioFormOriginal->getTipoCliente());
                    $instServicioClon->setCapacidad($servicioFormOriginal->getCapacidad());
                    $instServicioClon->setIdServicio(null);
                    $instServicioClon->setTipoTransporte($servicioFormOriginal->getTipoTransporte());
                    $instServicioClon->setCicloId($servicioFormOriginal->getCicloId());
                    $instServicioClon->setGradoId($servicioFormOriginal->getGradoId());
                    $instServicioClon->setGrupoId($servicioFormOriginal->getGrupoId());

                    $instServicioClon->save();


                    $serviciosHijos = consultasBd::getListaServiciosHijosParaClonar((int) $idServicio);
                    $totHijos = sizeof($serviciosHijos); //agarra uno de mas 

                    for ($i = 0; $i < $totHijos; $i++) {
                        $servicioFormOriginalHijo = Doctrine::getTable('Servicio')->find((int) $serviciosHijos[$i]['id']);


                        $instServicioClonHijo = new Servicio(); // servicio clon

                        $instServicioClonHijo->setCategoriaId($servicioFormOriginalHijo->getCategoriaId());
                        $instServicioClonHijo->setNombre($servicioFormOriginalHijo->getNombre()."_copia");
                        $instServicioClonHijo->setPrecio($servicioFormOriginalHijo->getPrecio());
                        $instServicioClonHijo->setAplicaParcialidad($servicioFormOriginalHijo->getAplicaParcialidad());
                        $instServicioClonHijo->setFechaEvento($fechaActual->format('Y-m-d'));
                        $instServicioClonHijo->setFechaInicio($fechaActual->format('Y-m-d'));
                        $instServicioClonHijo->setFechaFin($fechaActual->format('Y-m-d'));
                        $instServicioClonHijo->setUsuarioRegistro((int) $this->getUser()->getUserId());
                        $instServicioClonHijo->setFechaRegistro($fechaActual->format('Y-m-d H:i:s'));
                        $instServicioClonHijo->setActivo(1);
                        $instServicioClonHijo->setTipoCliente($servicioFormOriginalHijo->getTipoCliente());
                        $instServicioClonHijo->setCapacidad($servicioFormOriginalHijo->getCapacidad());
                        $instServicioClonHijo->setIdServicio($instServicioClon->getId());
                        $instServicioClonHijo->setTipoTransporte($servicioFormOriginalHijo->getTipoTransporte());
                        $instServicioClonHijo->setCicloId($servicioFormOriginalHijo->getCicloId());
                        $instServicioClonHijo->setGradoId($servicioFormOriginalHijo->getGradoId());
                        $instServicioClonHijo->setGrupoId($servicioFormOriginalHijo->getGrupoId());

                        $instServicioClonHijo->save();
                    }
                } else {
                    $r = array("error" => true, "mensaje" => "NO Guardados Correctamente");
                    return $this->sendJSON($r);
                }

                $r = array("error" => false, "mensaje" => "Guardados Correctamente");
                return $this->sendJSON($r);
            } else {
                $r = array("error" => true, "mensaje" => "Error_01: no se pudo guardardaron los valores seleccionados"); //a partir de php 5.4 es con corchetes[]
                return $this->sendJSON($r);
            }
        } catch (Doctrine_Exception $e) {
            //throw new sfException($e);
            $r = array("error" => true, "mensaje" => "Error_02: no se pudo guardardaron los valores seleccionados");
            return $this->sendJSON($r);
        }
    }

}
