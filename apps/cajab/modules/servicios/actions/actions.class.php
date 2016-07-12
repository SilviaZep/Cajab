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
                $servicioForm->setNombre($nombre);
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
                $servicioForm->setIdServicio(null);
                $servicioForm->setTipoTransporte((int) $tipoTransporte);
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

                if (!empty($idAlumnos)) {
                    $vecAlumnos = explode(",", $idAlumnos);
                    $max = (sizeof($vecAlumnos) - 1); //agarra uno de mas   

                    for ($i = 0; $i < $max; $i++) {
                        $instServicioCliente = new ServicioCliente();
                        $instServicioCliente->setIdServicio((int) $idServicio);
                        $instServicioCliente->setIdAlumno((int) $vecAlumnos[$i]);
                        $instServicioCliente->setFechaRegistro($fechaActual->format('Y-m-d H:i:s'));
                        $instServicioCliente->setUsuarioRegistro($this->getUser()->getUserId());
                        $instServicioCliente->setTipoCliente(1); //1.- Alumno; 2.- Cliente Externo
                        $instServicioCliente->setEstatus(1); //1.- PAGANDO; 2.- PAGADO;3.-Cancelado; 4.-Condonado
                        $instServicioCliente->save();
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

                if (!empty($idClientes)) {
                    $vecClientes = explode(",", $idClientes);
                    $max = (sizeof($vecClientes) - 1); //agarra uno de mas   

                    for ($i = 0; $i < $max; $i++) {
                        $instServicioCliente = new ServicioCliente();
                        $instServicioCliente->setIdServicio((int) $idServicio);
                        $instServicioCliente->setIdCliente((int) $vecClientes[$i]);
                        $instServicioCliente->setFechaRegistro($fechaActual->format('Y-m-d H:i:s'));
                        $instServicioCliente->setUsuarioRegistro($this->getUser()->getUserId());
                        $instServicioCliente->setTipoCliente(2); //1.- Alumno; 2.- Cliente Externo
                        $instServicioCliente->setEstatus(1); //1.- PAGANDO; 2.- PAGADO;3.-Cancelado; 4.-Condonado
                        $instServicioCliente->save();
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
                $offset = $request->getParameter("offset", 0);
                $limit = $request->getParameter("limit", 0);


                $listaAsignados = consultasBd::getListaAsignadosServicio((int) $idServicio, $nombreCliente, (int) $limit, (int) $offset);
                $totalListaAsignados = consultasBd::getTotalListaAsignadosServicio((int) $idServicio, $nombreCliente);
                $totalListaAsignados = $totalListaAsignados[0]['total'];


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
    
    public function executeFiltrosAlumnos(sfWebRequest $request) {
    	try {
    		if ($request->isMethod(sfWebRequest::POST)) {
    			$idSeccion = $request->getParameter("idSeccion", 0);
    			$idGrado = $request->getParameter("idGrado", 0);
    			$idgrupo = $request->getParameter("idGrupo", 0);
    			
    			$listaAlumnosQuery = consultasBd::getListaAlumnosFiltros($idSeccion, $idGrado, $idgrupo);
    			return $this->sendJSON($listaAlumnosQuery);
    		}
    	} catch (Doctrine_Exception $e) {
    		throw new sfException($e);
    	}
    }
    
}
