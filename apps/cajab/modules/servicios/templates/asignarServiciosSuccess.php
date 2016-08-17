
<style>
    #agregarCliente 
    {
        width: 90%; 
        margin-top: 15px !important;
        margin-left:  15px !important; 
    } 

</style>
<div ng-app="asignarServicios" ng-controller="asignarServiciosController">   

    <div id="serviciosVigentesDiv">
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form-inline">

                    <div class="form-group">
                        <label for="exampleInputName2">Nombre: </label>
                        <input type="text" ng-model="nombreServicio" class="form-control" placeholder="nombre del servicio">
                    </div>
                    <div class="form-group">  
                        <label for="exampleInputName2"> Categoria: </label>
                        <select  ng-model="categoria" class="form-control">      
                            <option value="0" >Todas</option>
                            <option ng-repeat="c in listaCategoriaServicios" ng-value="c.id" >{{c.categoria}}</option>
                        </select>
                    </div>
                    <button type="button" ng-click="listadoServicios(1)" class="btn btn-default">
                        <i class="fa fa-refresh" aria-hidden="true"></i>
                    </button>

                </form>
            </div>
        </div>


        <table class="table table-striped table-bordered">
            <thead>

            <td colspan="9" class="info"><b>Listado De Servicios Vigentes  &nbsp; {{hoy|  date:'dd-MM-yyyy'}}</b></td>

            <tr>
                <th class="col-md-2">Vigencia</th>
                <th class="col-md-2">Categoria </th>
                <th class="col-md-2">Servicio Padre </th>
                <th class="col-md-2">Fecha Inicia</th>
                <th class="col-md-2">Nombre Servicio </th>
                <th class="col-md-1">Precio</th>               
                <th class="col-md-1">Tipo Clientes</th>
                <th class="col-md-1">Capacidad</th>
                <th class="col-md-1"></th>
            </tr>
            </thead>
            <tbody>
                <tr ng-repeat="s in listaServicios">
                    
                    <td><font color="#04B431">{{s.fec_ini|  date:'dd/MM/yyyy' }}</font>  <font color="#FE642E">{{s.fec_fin|  date:'dd/MM/yyyy' }}</font></td>
                    <td>{{s.categoria}}</td>
                    <td>{{s.servicio_padre}}</td>
                    <td><font color="#0B6121"><b>{{s.fecha_evento| date:"dd/MM/yyyy"}}</b></font></td>
                    <td>{{s.nombre}}</td>
                    <td>{{s.precio| currency}}</td>

                    <td>{{s.tip_cli}}</td>
                    <td>{{s.capacidad}}</td>
                    
                    
                    <td>  <button type="button" class="btn btn-success btn-xs pull-right" ng-click="contraer(s)"><i class="fa fa-list" aria-hidden="true"></i> Modificar</button></td>
                </tr>
            </tbody>
        </table>

        <br />
        <nav ng-show="numPaginas > 1">
            <ul class="pagination">                             
                <li><a ng-click="ini()">INI</a></li>
                <li><a ng-click="anterior()">Ant</a ></li>
                <li  ng-repeat="x in paginado">
                    <a ng-click="listadoServicios(x)" ng-if="x == paginaActualServicios" ><span class="badge">{{x}}</span></a>
                    <a ng-click="listadoServicios(x)" ng-if="x != paginaActualServicios" >{{x}}</a>
                </li>
                <li><a ng-click="siguiente()">Sig</a></li>
                <li><a ng-click="end()">FIN</a></li>
            </ul>
        </nav>
    </div>


    <br/>

    <div id="edicionServiciosDiv" class="panel panel-default collapse">
        <div class="panel-body">
            <h3>{{aliasServicio}} <button type="button" class="btn btn-danger btn-xs pull-right" ng-click="expandir()"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button></h3><br/>


            <div  class="col-md-12">
                <div ng-show="tipoClienteS == 1 || tipoClienteS == 3" class="col-md-12">
                    <form class="form-inline">
                        <div class="form-group">
                            <label for="exampleInputName2">Ciclo:</label>
                            <select class="form-control" ng-model="selCiclo" ng-change="cicloCambio()">
                                <option value="0">TODOS</option>
                                <option ng-repeat="lce in listaCiclos" value="{{lce.idcicloescolar}}">{{lce.nombre}}</option>
                            </select>
                        </div>
                        <div ng-show="selCiclo > 0" class="form-group">
                            <label for="exampleInputName2">Grado:</label>
                            <select  class="form-control" ng-model="selGrado" ng-change="gradoCambio()">
                                <option value="0">TODOS</option>
                                <option ng-repeat="lcg in listaGrados" value="{{lcg.idgrado}}">{{lcg.grado}}</option>
                            </select >

                        </div>
                        <div ng-show="selCiclo > 0 && selGrado > 0" class="form-group">
                            <label for="exampleInputName2">Grupo:</label>
                            <select  class="form-control" ng-model="selGrupo">
                                <option value="0">TODOS</option>
                                <option ng-repeat="lcgs in listaGrupos" value="{{lcgs.idgrupo}}">{{lcgs.nombre}}</option>
                            </select>
                        </div>

                        <div  class="form-group">
                            <button class="btn btn-default" ng-click="listadoAlumnos(1, 1)" title="Actualizar">
                                <i class="fa fa-refresh" aria-hidden="true"></i>
                            </button> 
                        </div>

                    </form><br/>
                </div>
            </div>

            <div  class="col-md-12">
                <div class="col-md-4">
                    <form ng-show="tipoClienteS == 1 || tipoClienteS == 3" class="form-inline">
                        <div class="form-group">
                            <label for="exampleInputName2">Nombre: </label>
                            <input type="text" ng-model="nombreAlumno" class="form-control" placeholder="Nombre del Alumno"><br/>
                        </div>
                        <button class="btn btn-default" ng-click="listadoAlumnos(1, 2)" title="Actualizar">
                            <i class="fa fa-refresh" aria-hidden="true"></i>
                        </button> 
                    </form>
                </div>

                <div  class="col-md-4">

                    <form ng-show="tipoClienteS == 2 || tipoClienteS == 3" class="form-inline">
                        <div class="form-group">
                            <label for="exampleInputName2">Nombre: </label>
                            <input type="text" ng-model="nombreCliente" class="form-control" placeholder="Nombre del Cliente"><br/>
                        </div>
                        <button class="btn btn-default" ng-click="listadoClientes()" title="Actualizar">
                            <i class="fa fa-refresh" aria-hidden="true"></i>
                        </button>
                    </form>

                </div>

                <div  class="col-md-4">

                    <form class="form-inline">
                        <div class="form-group">
                            <label for="exampleInputName2">Nombre: </label>
                            <input type="text" ng-model="nombreAsignado" class="form-control" placeholder="Nombre"><br/>
                        </div>
                        <button class="btn btn-default" ng-click="listadoAsignados()" title="Actualizar">
                            <i class="fa fa-refresh" aria-hidden="true"></i>
                        </button>
                    </form><br/>

                </div>
            </div>

            <div class="col-md-4">
                <div  ng-show="tipoClienteS == 1 || tipoClienteS == 3">
                    <table  class="table table-striped table-bordered">
                        <thead>

                        <td colspan="8" class="info"><h4><span class="label label-primary">{{numeroRegistrosAlumnos}}</span> Alumnos
                                <button class="btn btn-info pull-right" ng-click="guardarAlumnos()"
                                        title="Asignar servicio a los Alumnos seleccionados">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar <span class="badge">{{countSeleccionadosAlumnos}}</span>
                                </button>

                            </h4>

                        </td>

                        <tr>
                            <th class="col-md-2">Nombre</th>
                            <th class="col-md-1">Nivel</th> 
                            <th class="col-md-1">Grado</th>                        
                            <th class="col-md-1">Grupo</th>                        
                            <th class="col-md-1">
                                <span ng-show="!todosAlumnos">
                                    <button type="button" class="btn btn-success btn-xs" ng-click="seleccionarTodosAlumnos(true)">
                                        <i class="fa fa-plus"></i> Todos
                                    </button></span>
                                <span ng-show="todosAlumnos">
                                    <button class="btn btn-danger btn-xs" ng-click="seleccionarTodosAlumnos(false)"><i class="fa fa-times" aria-hidden="true"></i> Ninguno</button>
                                </span>


                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="a in listaAlumnos">


                                <td>{{a.nombre}}</td>
                                <td>{{a.nivel}}</td>  
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


            </div>
            <div  class="col-md-4">
                <div ng-show="tipoClienteS == 2 || tipoClienteS == 3">


                    <table class="table table-striped table-bordered">
                        <thead>

                        <td colspan="8" class="info"><h4><span class="label label-primary">{{numeroRegistrosClientes}}</span> Clientes
                                <button class="btn btn-info pull-right" ng-click="guardarClientes()"
                                        title="Asignar servicio a los clientes seleccionados">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar <span class="badge">{{countSeleccionadosClientes}}</span>
                                </button>
                            </h4>
                        </td>

                        <tr>
                            <th class="col-md-2">Nombre</th>                      
                            <th class="col-md-1">
                                <span ng-show="!todosClientes">
                                    <button type="button" class="btn btn-success btn-xs" ng-click="seleccionarTodosClientes(true)">
                                        <i class="fa fa-plus"></i> Todos
                                    </button></span>
                                <span ng-show="todosClientes">
                                    <button class="btn btn-danger btn-xs" ng-click="seleccionarTodosClientes(false)"><i class="fa fa-times" aria-hidden="true"></i> Ninguno</button>
                                </span>


                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="c in listaClientes">
                                <td>{{c.nombre}}</td>
                                <td>
                                    <span ng-show="!c.seleccionado">
                                        <button type="button" class="btn btn-success btn-xs" ng-click="seleccionarCliente(c, true)">
                                            <i class="fa fa-plus"></i> Agregar
                                        </button></span>
                                    <span ng-show="c.seleccionado">
                                        <button class="btn btn-danger btn-xs" ng-click="seleccionarCliente(c, false)"><i class="fa fa-times" aria-hidden="true"></i> Quitar</button>
                                    </span>
                                </td>


                            </tr>
                        </tbody>
                    </table>
                    <br />
                    <nav ng-show="numPaginasClientes > 1">
                        <ul class="pagination">                             
                            <li><a ng-click="iniClientes()">INI</a></li>
                            <li><a ng-click="anteriorClientes()">Ant</a ></li>
                            <li  ng-repeat="x in paginadoClientes">
                                <a ng-click="listadoClientes(x)" ng-if="x == paginaActualClientes" ><span class="badge">{{x}}</span></a>
                                <a ng-click="listadoClientes(x)" ng-if="x != paginaActualClientes" >{{x}}</a>
                            </li>
                            <li><a ng-click="siguienteClientes()">Sig</a></li>
                            <li><a ng-click="endClientes()">FIN</a></li>
                        </ul>
                    </nav>
                </div>
            </div>


            <div  class="col-md-4">
                <table class="table table-striped table-bordered">
                    <thead>

                    <td colspan="8" class="info"><h4> Asignados al Servicio <span class="label label-warning">Cap: {{capacidadS}} </span> <span class="label label-primary">Asig: {{numeroRegistrosAsignados}} </span>                         
                        </h4>
                    </td>

                    <tr>
                        <th class="col-md-1">Tipo Cliente</th>                      
                        <th class="col-md-2">Nombre</th>                      
                        <th class="col-md-1">Estatus</th>  
                    </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="a in listaAsignados">
                            <td>{{a.tipo_descripcion}}</td>
                            <td>{{a.cliente}}</td>

                            <td>                        
                                <button ng-if="a.estatus_descripcion == 'Activo'" type="button" class="btn btn-success btn-xs" ng-click="cambiarEstatusAsignado(a)" data-toggle="modal" data-target="#modalCambiarEstatus">
                                    {{a.estatus_descripcion}}
                                </button>
                                <button ng-if="a.estatus_descripcion == 'Cancelado'" type="button" class="btn btn-danger btn-xs" ng-click="cambiarEstatusAsignado(a)" data-toggle="modal" data-target="#modalCambiarEstatus">
                                    {{a.estatus_descripcion}}
                                </button>
                                <span ng-if="a.estatus_descripcion == 'Pagado'" class="label label-primary">{{a.estatus_descripcion}}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <nav ng-show="numPaginasAsignados > 1">
                    <ul class="pagination">                             
                        <li><a ng-click="iniAsignados()">INI</a></li>
                        <li><a ng-click="anteriorAsignados()">Ant</a ></li>
                        <li  ng-repeat="x in paginadoAsignados">
                            <a ng-click="listadoAsignados(x)" ng-if="x == paginaActualAsignados" ><span class="badge">{{x}}</span></a>
                            <a ng-click="listadoAsignados(x)" ng-if="x != paginaActualAsignados" >{{x}}</a>
                        </li>
                        <li><a ng-click="siguienteAsignados()">Sig</a></li>
                        <li><a ng-click="endAsignados()">FIN</a></li>
                    </ul>
                </nav>
            </div>



        </div>
    </div>

    <br/>


    <div>

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
                                    <option value="1">Activo</option>
                                    <option value="3">Cancelado</option>                                  
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




</div>