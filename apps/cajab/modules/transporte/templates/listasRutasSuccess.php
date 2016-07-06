

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


                <button ng-show="flagGuardar == true" type="button" class="btn btn-success pull-right" ng-click="guardarListasPorRuta()">
                    <i class="fa fa-floppy-o" aria-hidden="true"> Guardar Listas</i> 
                </button>

                <button ng-show="flagGuardar == false" type="button" class="btn btn-default pull-right" ng-click="">
                    <i class="fa fa-print" aria-hidden="true"> Imprimir Listas</i>
                </button>





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

            <td colspan="8" class="info"><b><i class="fa fa-bus" aria-hidden="true"></i> {{rutaNombre}} <br/> Listado Alumnos  </b>  &nbsp;&nbsp; {{fechaIni| date:'dd-MM-yyyy'}}
                <button type="button" class="btn btn-success btn-xs pull-right" data-toggle="modal"  data-target="#crearEventual"><i class="fa fa-plus-square" aria-hidden="true"></i>  Agregar Alumno</button>
            </td>

            <tr>
                <th class="col-xs-1"></th>              
                <th class="col-md-4">Nombre</th>
                <th class="col-md-4">Tipo Transporte</th>                
                <th class="col-md-3"></th>
                <th class="col-md-1"></th>
            </tr>


            </thead>
            <tbody>
                <tr ng-repeat="a in listaAlumnosPorDia">
                    <td>{{$index + 1}}</td>                    
                    <td>{{a.nombre}}</td>
                    <td>{{a.tipo_transporte}}</td>
                    <td> 
                        <button ng-show="a.tipo_transporte == 'Eventual'" type="button" class="btn btn-danger btn-xs" ng-click="eliminarEventual(a)"> 
                            <i class="fa fa-trash-o" aria-hidden="true">Eliminar</i>
                        </button>
                    </td>                  
                    <td>
                        <span ng-show="a.guardado==0" class="label label-warning">calculado</span>
                        <span ng-show="a.guardado==1" class="label label-success">guardado</span>                        
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




</div>