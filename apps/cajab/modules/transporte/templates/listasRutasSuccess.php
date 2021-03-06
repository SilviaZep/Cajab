

<div ng-app="listasRutas" ng-controller="listasRutasController">      


    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-inline">

                <div class="form-group">
                    <label for="exampleInputEmail2"> Fecha:</label>
                    <input type="date" ng-model="fechaIni" class="form-control" id="exampleInputEmail2" >
                </div>                
                <button type="button" class="btn btn-default" ng-click="listadoRutas()">
                    <i class="fa fa-refresh" aria-hidden="true"></i>
                </button>



                <div class="pull-right">
                    <div class="btn-group ">
                        <button ng-show="flagGuardar == false && fechaIni <= fechaHoy" type="button" class="btn btn-default" ng-click="imprimirListasRutasAlumnos(0)">
                            <i class="fa fa-print" aria-hidden="true"> Imprimir Lista</i>
                        </button>
                    </div>
                    <div class="btn-group ">
                        <button ng-show="flagGuardar == true" type="button" class="btn btn-success pull-right" ng-click="guardarListasPorRuta();">
                            <i class="fa fa-floppy-o" aria-hidden="true" id="botonGuardarListas"> </i> Guardar Listas
                        </button>
                        <button ng-show="flagGuardar == false && compararFechasHoy()==true" type="button" class="btn btn-danger pull-right" ng-click="eliminarListasHoy();">
                            <i class="fa fa-trash-o" aria-hidden="true" id="botonEliminarListas"> </i> Eliminar Listas
                        </button>
                    </div>
                </div>







            </form><br/>
            <form class="form-inline">
                <label>Rutas: <br/>                    
                    <span class="label label-danger pull-right">capacidad</span><br/>
                    <span class="label label-success pull-right">asignados</span>
                </label>
                <button  class="btn btn-default" ng-repeat="r in listaRutas" ng-click="listadoAlumnosPorDiaRuta(r)">
                    <i class="fa fa-bus" aria-hidden="true"><b> {{r.nombre}}</b></i><br/>
                    <span class="label label-danger">{{r.capacidad}}</span>
                    <span class="label label-success">{{r.tot_alum_ruta}}</span>
                </button>
            </form>


        </div>


    </div>




    <div ng-show="idRuta != 0">
        <table class="table table-striped table-bordered">
            <thead>

            <td colspan="13" class="info"><b><i class="fa fa-bus" aria-hidden="true"></i> {{rutaNombre}} <br/> Listado Alumnos  </b>  &nbsp;&nbsp; {{fechaIni| date:'dd-MM-yyyy'}}
                <div class="pull-right">
                    <div class="btn-group ">
                        <button type="button" class="btn btn-success btn-xs " data-toggle="modal"  data-target="#crearEventual"><i class="fa fa-plus-square" aria-hidden="true"></i>  Agregar Alumno</button>
                    </div>
                    <div class="btn-group ">
                        <button ng-show="flagGuardar == false && fechaIni <= fechaHoy" type="button" class="btn btn-default" ng-click="imprimirListasRutasAlumnos()">
                            <i class="fa fa-print" aria-hidden="true"> Imprimir Lista</i>
                        </button>
                    </div>
                </div>
            </td>

            <tr>
                <th class="col-xs-1"></th>              
                <th class="col-md-3">Nombre</th>
                <th class="col-md-3">Secciòn:Grado:Grupo</th>
                <th class="col-md-2">Tipo Transporte</th>                

                <th class="col-md-1">Bajar Solo</th>
                <th class="col-md-1">Lugar Bajada</th>
                <th class="col-md-1">Persona Recibe</th>
                <th class="col-md-1">Extraescolares</th>
                <th class="col-md-1">Observaciones</th>
                <th class="col-md-1">Estatus</th>
                <th class="col-md-1"></th>
            </tr>


            </thead>
            <tbody>
                <tr ng-repeat="a in listaAlumnosPorDia| orderBy:'nombre'">
                    <td>{{$index + 1}}</td>                    
                    <td>{{a.nombre}}</td>
                    <td>{{a.datos}}</td>
                    <td>{{a.tipo_transporte}}</td>
                    <td>{{a.baja_solo}}</td>
                    <td>{{a.direccion_baja}}</td>
                    <td>{{a.persona_recibe}}</td>
                    <td>{{a.extracurricular}}</td>
                    <td>{{a.observaciones}}</td>
                    <td> 
                        <button ng-show="a.tipo_transporte == 'Eventual' && a.guardado == 0" type="button" class="btn btn-danger btn-xs" ng-click="eliminarEventual(a)"> 
                            <i class="fa fa-trash-o" aria-hidden="true"> Eliminar</i>
                        </button>
                        <button ng-show="a.observacion == 'asistencia' && a.guardado == 1" type="button" class="btn btn-success btn-xs" ng-click="cambiarEstatusAsignado(a)" data-toggle="modal" data-target="#modalCambiarEstatus"> 
                            <i class="fa fa-check-square-o" aria-hidden="true"> ASISTENCIA</i>
                        </button>
                        <button ng-show="a.observacion == 'inasistencia' && a.guardado == 1" type="button" class="btn btn-default btn-xs" ng-click="cambiarEstatusAsignado(a)" data-toggle="modal" data-target="#modalCambiarEstatus"> 
                            <i class="fa fa-times" aria-hidden="true"> INASISTENCIA</i>
                        </button>
                    </td>  

                    <td>
                        <span ng-show="a.guardado == 0" class="label label-warning">calculado</span>
                        <span ng-show="a.guardado == 1" class="label label-success">guardado</span>                        
                    </td>


                </tr>



            </tbody>
        </table>


    </div>

    <!--Modal cambiar de ruta-->
    <div>

        <div class="modal fade" id="crearEventual" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Agregar Alumno Eventual</h4>
                    </div>
                    <div class="modal-body">

                        <form class="form-inline">
                            <div class="form-group">
                                <label for="exampleInputName2">Nombre: </label><br/>
                                <input type="text" ng-model="nombreAlumno" class="form-control" placeholder="Nombre del Alumno"><br/>
                            </div>
                            <button class="btn btn-default" ng-click="listadoAlumnos()" title="Actualizar">
                                <i class="fa fa-refresh" aria-hidden="true"></i>
                            </button>
                        </form><br/>

                        <table  class="table table-striped table-bordered">
                            <thead>
                            <td colspan="8" class="info">
                                <h4>
                                    <span class="label label-primary">{{numeroRegistrosAlumnos}}</span> Alumnos
                                </h4>
                            </td>

                            <tr>
                                <th class="col-md-2">Nombre</th>
                                <th class="col-md-1">Grado</th>                        
                                <th class="col-md-1">Grupo</th>                        

                                <th class="col-md-1">
                               <!-- <span ng-show="!todosAlumnos">
                                        <button type="button" class="btn btn-success btn-xs" ng-click="seleccionarTodosAlumnos(true)">
                                            <i class="fa fa-plus"></i> Todos
                                        </button></span>
                                    <span ng-show="todosAlumnos">
                                        <button class="btn btn-danger btn-xs" ng-click="seleccionarTodosAlumnos(false)"><i class="fa fa-times" aria-hidden="true"></i> Ninguno</button>
                                    </span>-->


                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="a in listaAlumnos">


                                    <td>{{a.nombre}}</td>
                                    <td>{{a.grado}}</td>  
                                    <td>{{a.grupo}}</td>      
                                    <td>
                                        <span ng-show="!a.seleccionado">
                                            <button type="button" class="btn btn-success btn-xs" ng-click="seleccionarAlumno(a, true)">
                                                <i class="fa fa-plus"></i> Agregar
                                            </button></span>
                                        <span ng-show="a.seleccionado">
                                            <button class="btn btn-danger btn-xs" ng-click="seleccionarAlumno(a, false)">
                                                <i class="fa fa-times" aria-hidden="true"></i> Quitar</button>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br />
                        <nav ng-show="numPaginasAlumnos > 1">
                            <ul class="pagination">                             
                                <li><a ng-click="iniAlumnos()">INI</a></li>
                                <li><a ng-click="anteriorAlumnos()">Ant</a ></li>
                                <li  ng-repeat="x in paginadoAlumnos">
                                    <a ng-click="listadoAlumnos(x)" ng-if="x == paginaActualAlumnos" ><span class="badge">{{x}}</span></a>
                                    <a ng-click="listadoAlumnos(x)" ng-if="x != paginaActualAlumnos" >{{x}}</a>
                                </li>
                                <li><a ng-click="siguienteAlumnos()">Sig</a></li>
                                <li><a ng-click="endAlumnos()">FIN</a></li>
                            </ul>
                        </nav>








                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success" ng-click="guardarAlumnosEventuales()">Agregar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <div class="modal fade" id="modalCambiarEstatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cambiar Estatus</h4>
                </div>
                <div class="modal-body">

                    <form >
                        <div class="form-group">
                            <label>Estatus:</label>
                            <select class="form-control" ng-model="estatusCambioA">
                                <option value="asistencia">ASISTENCIA</option>
                                <option value="inasistencia">INASISTENCIA</option>                                  
                            </select>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" ng-click="guardarCambioEstatus()">Guardar</button>
                </div>
            </div>
        </div>
    </div>




</div>