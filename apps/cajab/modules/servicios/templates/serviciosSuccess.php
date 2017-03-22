

<div ng-app="servicio" ng-controller="servicioController">      


    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-inline">

                <div class="form-group">
                    <label for="exampleInputEmail2"> Inicio de eventos de:</label>
                    <input type="date" ng-model="fechaIni" class="form-control" id="exampleInputEmail2" >
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail2"> a :</label>
                    <input type="date" ng-model="fechaFin" class="form-control" id="exampleInputEmail2" >
                </div>
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

                <button type="button" ng-click="limpiarModalServicio()" class="btn btn-success pull-right" data-toggle="modal"  data-target="#crearServicio"><i class="fa fa-plus-square" aria-hidden="true"></i>  Nuevo Servicio</button>

            </form>
        </div>
    </div>

    <div>
        <table class="table table-striped table-bordered" style="font-size: 14px !important">
            <thead>

            <td colspan="14" class="info"><b>Listado De Servicios</b></td>

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
                <th class="col-md-1"></th>
                <th class="col-md-1"></th>
                <th class="col-md-1"></th>
                <th class="col-md-1"></th>
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

                    <td> <button type="button" ng-click="detalleServicio(s)" data-toggle="modal"  data-target="#crearServicio" class="btn btn-info" title="Detalles del Servicio"> <i class="fa fa-eye" aria-hidden="true"></i></button></td>
                    <td> <button type="button" ng-click="editarServicio(s)" data-toggle="modal"  data-target="#crearServicio" class="btn btn-warning" title="Editar Servicio"> <i class="fa fa-pencil" aria-hidden="true"></i></button></td>
                    <td> <button type="button" ng-click="eliminarServicio(s.id)" class="btn btn-danger " title="Eliminar Servicio"> <i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
                    <td> <button type="button" ng-click="asignadosServicio(s)" class="btn btn-info " data-toggle="modal"  data-target="#modalListadoClientesAsignados" title="Asignados al Servicio"> <i class="fa fa-list" aria-hidden="true" ></i></button></td>
                    <td> <button type="button" ng-click="clonarServicio(s)" class="btn btn-primary " data-toggle="modal"  data-target="#crearServicio" title="Clonar Servicio"> <i class="fa fa-files-o" aria-hidden="true"></i></button></td>
                    <td> <button type="button" ng-click="servicioHijo(s.id)" class="btn btn-success " data-toggle="modal"  data-target="#crearServicio" title="Servicio Hijo"><i class="fa fa-link" aria-hidden="true"></i></button></td>




                </tr>


            </tbody>
        </table>

        <br />
        <nav ng-show="numPaginas > 1">
            <ul class="pagination">                             
                <li><a ng-click="ini()">INI</a></li>
                <li><a ng-click="anterior()">Ant</a ></li>
                <li  ng-repeat="x in paginado">
                    <a ng-click="listadoServicios(x)" ng-if="x == paginaActual" ><span class="badge">{{x}}</span></a>
                    <a ng-click="listadoServicios(x)" ng-if="x != paginaActual" >{{x}}</a>
                </li>
                <li><a ng-click="siguiente()">Sig</a></li>
                <li><a ng-click="end()">FIN</a></li>
            </ul>
        </nav>


    </div>

    <!--Modal cambiar de ruta-->
    <div>

        <div class="modal fade" id="crearServicio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 ng-show="estatus == 'NUEVO'" class="modal-title" id="myModalLabel">Nuevo Servicio</h4>
                        <h4 ng-show="estatus == 'EDITAR'" class="modal-title" id="myModalLabel">Editar Servicio</h4>
                        <h4 ng-show="estatus == 'CLONAR'" class="modal-title" id="myModalLabel">Clonar Servicio</h4>
                        <h4 ng-show="estatus == 'HIJO'" class="modal-title" id="myModalLabel">Nuevo Servicio Hijo</h4>
                        <h4 ng-show="estatus == 'DETALLE'" class="modal-title" id="myModalLabel">Detalles del Servicio</h4>
                    </div>
                    <div class="modal-body">

                        <form class="form-horizontal">

                            <div class="form-group">
                                <label  class="col-sm-2 control-label "  style="text-align: left !important">Categoria: </label>
                                <div class="col-sm-10">                                   
                                    <select  ng-model="mCategoria" class="form-control">
                                        <option ng-repeat="c in listaCategoriaServicios" value="{{c.id}}" >{{c.categoria}}</option>
                                    </select>
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label  class="col-sm-2 control-label "  style="text-align: left !important">Nombre: </label>
                                <div class="col-sm-10">
                                    <input type="text" ng-model="mNombre" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label "  style="text-align: left !important">Precio:</label>
                                <div class="col-sm-5">
                                    <input type="number"  ng-model="mPrecio" class="form-control" >
                                </div>
                            </div>
                            <!--   <div class="form-group">                                
                                   <label class="col-sm-4 control-label "  style="text-align: left !important">Pago Obligatorio:</label>
                                   <div class="col-sm-4">
                                       <label class="radio-inline">
                                           <input type="radio"  ng-model="mPagoObligarotio" value="1" > SI
                                       </label>
                                       <label class="radio-inline">
                                           <input type="radio"  ng-model="mPagoObligarotio" value="0" > NO
                                       </label>
                                   </div>
                               </div>-->
                            <div class="form-group">                                
                                <label class="col-sm-4 control-label "  style="text-align: left !important">Aplica Parcialidades:</label>
                                <div class="col-sm-4">
                                    <label class="radio-inline">
                                        <input type="radio"  ng-model="mAplicaParcialidad" value="1" > SI
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio"  ng-model="mAplicaParcialidad" value="0" > NO
                                    </label>
                                </div>
                            </div>
                            <div ng-show="mCategoria == 1" class="form-group">
                                <label  class="col-sm-3 control-label "  style="text-align: left !important">Tipo Servicio</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline">
                                        <input type="radio" ng-model="mTipoServicio" value="1"> Completo
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" ng-model="mTipoServicio" value="2" > Medio
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" ng-model="mTipoServicio" value="3" > Eventual
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-3 control-label "  style="text-align: left !important">Tipo Clientes</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline">
                                        <input type="radio" ng-model="mTipoClientes" value="1"> Alumnos
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" ng-model="mTipoClientes" value="2" > Externos
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" ng-model="mTipoClientes" value="3" > Mixto
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label "  style="text-align: left !important">Capacidad:</label>
                                <div class="col-sm-5">
                                    <input type="number"  ng-model="mCapacidad" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-inline">
                                    <span >
                                        <label for="exampleInputName2">&nbsp;&nbsp;&nbsp;  Ciclo:</label>
                                        <select class="form-control" ng-model="selCiclo" ng-change="cicloCambio()">
                                            <option value="0">TODOS</option>
                                            <option ng-repeat="lce in listaCiclos" value="{{lce.idcicloescolar}}">{{lce.nombre}}</option>
                                        </select>
                                    </span>
                                    <span ng-show="selCiclo > 0" >
                                        <label for="exampleInputName2"> Grado:</label>
                                        <select  class="form-control" ng-model="selGrado" ng-change="gradoCambio()">
                                            <option value="0">TODOS</option>
                                            <option ng-repeat="lcg in listaGrados" value="{{lcg.idgrado}}">{{lcg.grado}}</option>
                                        </select >

                                    </span>
                                    <span ng-show="selCiclo > 0 && selGrado > 0" >
                                        <label for="exampleInputName2"> Grupo:</label>
                                        <select  class="form-control" ng-model="selGrupo">
                                            <option value="0">TODOS</option>
                                            <option ng-repeat="lcgs in listaGrupos" value="{{lcgs.idgrupo}}">{{lcgs.nombre}}</option>
                                        </select>
                                    </span>

                                </div>

                            </div>


                            <div class="form-group">
                                <label  class="col-sm-3 control-label "  style="text-align: left !important">Fecha Evento:</label>
                                <div class="col-sm-5">
                                    <input type="date"  ng-model="mFechaEvento" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-3 control-label "  style="text-align: left !important">Vigencia de :</label>
                                <div class="col-sm-4">
                                    <input type="date" ng-model="mFechaIni" class="form-control" >
                                </div>
                                <label  class="col-sm-1 control-label "  style="text-align: left !important"> a </label>
                                <div class="col-sm-4">
                                    <input type="date" ng-model="mFechaFin" class="form-control" >
                                </div>
                            </div>




                        </form>




                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button ng-show="estatus == 'NUEVO'" id="botonGuardar" type="button" class="btn btn-success" ng-click="guardarServicio()">Guardar</button>
                        <button ng-show="estatus == 'EDITAR'" id="botonGuardar" type="button" class="btn btn-success" ng-click="guardarServicio()">Guardar Cambios</button>
                        <button ng-show="estatus == 'CLONAR'" id="botonGuardar" type="button" class="btn btn-success" ng-click="guardarServicio()">Guarda Servicio Clonado</button>
                        <button ng-show="estatus == 'HIJO'" id="botonGuardar" type="button" class="btn btn-success" ng-click="guardarServicio()">Guardar Servicio Hijo</button>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <div>

        <div class="modal fade" id="modalListadoClientesAsignados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Clientes Asignados</h4>
                    </div>
                    <div class="modal-body">



                        <form class="form-inline">
                            <div class="form-group">
                                <label for="exampleInputName2">Nombre: </label><br/>
                                <input type="text" ng-model="nombreAsignado" class="form-control" placeholder="Nombre"><br/>
                            </div>
                            <button class="btn btn-default" ng-click="listadoAsignados()" title="Actualizar">
                                <i class="fa fa-refresh" aria-hidden="true"></i>
                            </button>
                        </form><br/>




                        <table class="table table-striped table-bordered">
                            <thead>

                            <td colspan="5" class="info"><h4><span class="label label-primary">{{numeroRegistrosAsignados}}</span> Asignados al Servicio                           
                                    <button ng-show="listaAsignados.length > 0"  type="button" class="btn btn-default pull-right" ng-click="imprimirAsignadosAServicio()">
                                        <i class="fa fa-print" aria-hidden="true"> Imprimir Lista</i>
                                    </button>
                                </h4>
                            </td>

                            <tr>
                                <th class="col-md-1">Tipo Cliente</th>                      
                                <th class="col-md-2">Nombre</th>                      
                                <th class="col-md-1">Estatus</th>  
                                <th class="col-md-1"></th>  
                                <th class="col-md-1">Fecha de registro</th>  
                            </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="a in listaAsignados">
                                    <td>{{a.tipo_descripcion}}</td>
                                    <td>{{a.cliente}}</td>

                                    <td> 
                                        <span ng-if="a.estatus_descripcion == 'Cancelado'" class="label label-danger">{{a.estatus_descripcion}}</span>
                                        <span ng-if="a.estatus_descripcion == 'Activo'" class="label label-success">{{a.estatus_descripcion}}</span>
                                        <span ng-if="a.estatus_descripcion == 'Pagado'" class="label label-primary">{{a.estatus_descripcion}}</span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-xs" ng-click="llamarPagos(a.tipo_descripcion, a.cliente)">
                                            <i class="fa fa-share" aria-hidden="true"></i> Caja
                                        </button>

                                    </td>
                                    <td>{{a.fecha_registro| date:"dd/MM/yyyy"}}</td>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <!-- <button type="button" class="btn btn-success" ng-click="guardarCambioEstatus()">Guardar</button>-->
                    </div>
                </div>
            </div>
        </div>

    </div>




</div>