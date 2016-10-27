

<div ng-app="servicio" ng-controller="servicioController">      

    <div ng-show="flagVentanaPrincipal == 1"> 
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



                </form>
            </div>
        </div>

        <div>
            <table class="table table-striped table-bordered" style="font-size: 14px !important">
                <thead>

                <td colspan="12" class="info"><b>Listado De Servicios</b></td>

                <tr>

                    <th class="col-md-2">Vigencia</th>
                    <th class="col-md-2">Categoria </th>
                    <th class="col-md-2">Servicio Padre </th>
                    <th class="col-md-2">Fecha Inicia</th>
                    <th class="col-md-2">Nombre Servicio *</th>
                    <th class="col-md-1">Precio</th>               
                    <th class="col-md-1">Tipo Clientes</th>
                    <th class="col-md-1">Capacidad</th>
                    <th class="col-md-1">Inscritos</th>
                    <th class="col-md-1">Esperado($)</th>


                    <th class="col-md-1">Detalles por Alumno</th>
                    <th class="col-md-1">Detalles por Movimientos</th>







                </tr>


                </thead>
                <tbody>
                    <tr ng-repeat="s in listaServicios| orderBy :'nombre' ">


                        <td><font color="#04B431">{{s.fec_ini|  date:'dd/MM/yyyy' }}</font>  <font color="#FE642E">{{s.fec_fin|  date:'dd/MM/yyyy' }}</font></td>
                        <td>{{s.categoria}}</td>
                        <td>{{s.servicio_padre}}</td>
                        <td><font color="#0B6121"><b>{{s.fecha_evento| date:"dd/MM/yyyy"}}</b></font></td>
                        <td>{{s.nombre}}</td>
                        <td>{{s.precio| currency}}</td>

                        <td>{{s.tip_cli}}</td>
                        <td>{{s.capacidad}}</td>
                        <td>{{s.inscritos}}</td>
                        <td>{{(s.inscritos*s.precio)| currency}}</td>


                        <td> 
                            <button type="button" ng-click="asignadosServicio(s)" class="btn btn-info " >
                                <i class="fa fa-users" aria-hidden="true"></i></button>
                        </td>
                        <td> <button type="button" ng-click="ingresosEgresos(s)" class="btn btn-success " >
                                <i class="fa fa-tasks" aria-hidden="true"></i>
                            </button>
                        </td>




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
    </div>

    <div ng-show="flagVentanaPrincipal == 2">
        <h4>Detalles de pagos de los clientes asignados al servicio</h4>
        <table class="table table-striped table-bordered">
            <thead>

            <td colspan="10" class="info"><h4><span class="label label-primary">{{numeroRegistrosAsignados}}</span> <b>{{tituloTabla}}</b>                          
                    <!--<button ng-show="listaAsignados.length > 0"  type="button" class="btn btn-default pull-right" ng-click="imprimirAsignadosAServicio()">
                        <i class="fa fa-print" aria-hidden="true"> Imprimir Lista</i>
                    </button>-->
                     <div class="group pull-right">
                        <button type="button" class="btn btn-default btn-xs" ng-click="asignadosServicioImprimir()"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
                        <button type="button" class="btn btn-danger btn-xs" ng-click="expandir()"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
                    </div>
                    
                </h4>
            </td>

            <tr>
                <th class="col-md-1"></th>
                <th class="col-md-1">Tipo Cliente</th>                      
                <th class="col-md-2">Nombre</th> 
                <th class="col-md-1">Precio</th>
                <th class="col-md-1">Abonado</th>
                <th class="col-md-1">Descuento</th>
                <th class="col-md-1">No.Abonos</th>
                <th class="col-md-1">Saldo</th>
                <th class="col-md-1">Estatus</th>  
                <th class="col-md-1"></th>  
            </tr>
            </thead>
            <tbody>
                <tr ng-repeat="a in listaAsignados| orderBy:'saldo' " class="{{colorRow(a)}}">
                    <td>{{$index + 1}}</td>
                    <td>{{a.tipo_descripcion}}</td>
                    <td>{{a.cliente}}</td>


                    <td>{{a.precio| currency}}</td> 
                    <td>{{a.abonado| currency}}</td>
                    <td>{{a.descuento| currency}}</td>
                    <td>
                        <button ng-show="a.no_abonos > 0" type="button" class="btn btn-info btn-xs" ng-click="listaPagos(a.id)" data-toggle="modal" data-target="#mListaPagos">
                            Detalle <span class="badge">{{a.no_abonos}}</span>
                        </button>
                        <p ng-show="a.no_abonos <= 0"><span class="badge">0</span></p>
                    </td>
                    <td><span ng-if="a.estatus_descripcion != 'Cancelado'">{{a.saldo| currency}}</span>
                        <span ng-if="a.estatus_descripcion == 'Cancelado'">{{0| currency}}</span>
                    </td>

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

    <div ng-show="flagVentanaPrincipal == 3">
        <h4>Detalles de movimientos del servicio</h4>
        <table class="table table-striped table-bordered">
            <thead>

            <td colspan="10" class="info"><h4>
                    <b>{{tituloTabla}}</b> 
                    <span class="label label-default">Esperado:<b>{{totalEsperadoIE| currency}}</b></span>
                    <span class="label label-primary">Pagado:<b>{{totalPagadoIE| currency}}</b></span>
                    <span class="label label-info">Descuento:<b>{{totalDescuentoIE| currency}}</b></span>
                    <span class="label label-warning">Egreso:<b>{{totalEgresoIE| currency}}</b></span>
                    <span class="label label-success">Total:<b>{{totalTotalIE| currency}}</b></span>
                     
                    <div class="group pull-right">
                        <button type="button" class="btn btn-default btn-xs" ng-click="ingresosEgresosImprimir()"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
                        <button type="button" class="btn btn-danger btn-xs" ng-click=" flagVentanaPrincipal = 1"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
                    </div>
                </h4>
            </td>

            <tr>
                <th class="col-md-1"></th>
                <th class="col-md-1">Tipo Cliente</th>                      
                <th class="col-md-2">Nombre</th> 
                <th class="col-md-1">Tipo Movimiento</th>
                <th class="col-md-1">Fecha Registro</th>
                <th class="col-md-1">Pagado</th>
                <th class="col-md-1">Descuento</th>
                <th class="col-md-1">Egreso</th>
                <th class="col-md-1"></th>


            </tr>
            </thead>
            <tbody>
                <tr ng-repeat="lie in listaIngresosEgresos| orderBy:'cliente'" class="{{colorRow(a)}}">
                    <td>{{$index + 1}}</td>
                    <td>{{lie.tipo_descripcion}}</td>
                    <td>{{lie.cliente}}</td>
                    <td class="{{colorRowIngEgr(lie.modo_pago)}}">{{lie.modo_pago}}</td>
                    <td>{{lie.fecha_pago| date:'dd/MM/yyyy'}}</td>

                    <td >{{lie.pago| currency}}</td> 
                    <td >{{lie.descuento| currency}}</td>
                    <td >{{lie.egreso| currency}}</td>



                    <td>
                        <span ng-show="lie.modo_pago == 'INGRESO'">
                            <button type="button" class="btn btn-primary btn-xs" ng-click="llamarPagos(lie.tipo_descripcion, lie.cliente)">
                                <i class="fa fa-share" aria-hidden="true"></i> Caja
                            </button>
                        </span>
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



    <div class="modal fade" id="mListaPagos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Pagos</h4>
                </div>
                <div class="modal-body">

                    <div >
                        <table class="table table-striped table-bordered" style="font-size: 14px !important">
                            <thead>

                            <td colspan="4" class="info">Lista pagos</td>

                            <tr>
                                <th >Fecha Pago</th>
                                <th >Monto</th>
                                <th >Descuento</th>
                                <th >Forma Pago</th>
                            </tr>


                            </thead>
                            <tbody>
                                <tr ng-repeat="lp in listaPagosServicioCliente">
                                    <td >{{lp.fecha_pago| date:'dd/MM/yyyy'}}</td>
                                    <td align="right" >{{lp.monto| currency}}</td>
                                    <td align="right" >{{lp.descuento| currency}}</td>
                                    <td >{{lp.forma_pago}}</td>
                                </tr>


                            </tbody>
                        </table>      


                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>




</div><!-- div controller-->