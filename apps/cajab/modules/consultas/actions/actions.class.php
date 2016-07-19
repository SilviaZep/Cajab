<?php

/**
 * acceso actions.
 *
 * @package    puntoveta
 * @subpackage acceso
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class consultasActions extends baseCajabProjectActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeGetCiclosEscolares(sfWebRequest $request) {
        try {

            //trae los ciclos porgramados y activos
            $ciclosEscolares = consultasInstituto::getCiclosEscolares();
            $r = array("listaCiclos" => $ciclosEscolares); //a partir de php 5.4 es con corchetes[]                        
            return $this->sendJSON($r);
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    public function executeGetGradosByCiclo(sfWebRequest $request) {
        try {

            // hace un select distict de los grados por cada ciclo
            $idCiclo = $request->getParameter("idCiclo", 0);
            $listaGrados = consultasInstituto::getGradosByCiclo($idCiclo);
            $r = array("listaGrados" => $listaGrados); //a partir de php 5.4 es con corchetes[]                        
            return $this->sendJSON($r);
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    public function executeGetGruposByGrado(sfWebRequest $request) {
        try {
            //consigue los grupos por el nombre del grado y por el ciclo
            $grado = $request->getParameter("grado", 0);
            $idCiclo = $request->getParameter("idCiclo", 0);

            $listaGrupos = consultasInstituto::getGruposByGrado($grado, $idCiclo);
            $r = array("listaGrupos" => $listaGrupos); //a partir de php 5.4 es con corchetes[]                        
            return $this->sendJSON($r);
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

    public function executeFiltrosAlumnos(sfWebRequest $request) {
        try {

            $limit = $request->getParameter("limit", 0);
            $offset = $request->getParameter("offset", 0);
            $idCiclo = $request->getParameter("idCiclo", 0);
            $idGrado = $request->getParameter("idGrado", 0);
            $idgrupo = $request->getParameter("idGrupo", 0);
            $alumno = $request->getParameter("alumno", 0); //busca por alumno se deben bloquear las demas opciones


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


            $listaAlumnosQuery = consultasInstituto::getListaAlumnosFiltros($idCiclo, $idGrado, $idgrupo, $alumno,$limit,$offset);
            $totalListaAlumnosQuery = consultasInstituto::getTotalListaAlumnosFiltros($idCiclo, $idGrado, $idgrupo, $alumno);
            $totalListaAlumnosQuery = $totalListaAlumnosQuery[0]['total'];
            
            $r = array("mensaje" => "Ok", "listaAlumnos" => $listaAlumnosQuery, "total" => $totalListaAlumnosQuery); //a partir de php 5.4 es con corchetes[]
            return $this->sendJSON($r);
        } catch (Doctrine_Exception $e) {
            throw new sfException($e);
        }
    }

}
