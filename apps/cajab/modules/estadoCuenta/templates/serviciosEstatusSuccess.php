

<div ng-app="servicio" ng-controller="servicioController">      

    <div ng-show="flagVentanaPrincipal == true"> 
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

                <td colspan="9" class="info"><b>Listado De Servicios</b></td>

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


                        <td> <button type="button" ng-click="asignadosServicio(s)" class="btn btn-success " ><i class="fa fa-tasks" aria-hidden="true"></i></button></td>




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

    <div ng-show="flagVentanaPrincipal == false">

        <table class="table table-striped table-bordered">
            <thead>

            <td colspan="8" class="info"><h4><span class="label label-primary">{{numeroRegistrosAsignados}}</span> <b>{{tituloTabla}}</b>                          
                    <!--<button ng-show="listaAsignados.length > 0"  type="button" class="btn btn-default pull-right" ng-click="imprimirAsignadosAServicio()">
                        <i class="fa fa-print" aria-hidden="true"> Imprimir Lista</i>
                    </button>-->
                    <button type="button" class="btn btn-danger btn-xs pull-right" ng-click="expandir()"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
                </h4>
            </td>

            <tr>
                <th class="col-md-1"></th>
                <th class="col-md-1">Tipo Cliente</th>                      
                <th class="col-md-2">Nombre</th> 
                <th class="col-md-1">Precio</th>
                <th class="col-md-1">Abonado</th>
                <th class="col-md-1">No.Abonos</th>
                <th class="col-md-1">Adeuda</th>
                <th class="col-md-1">Estatus</th>  
            </tr>
            </thead>
            <tbody>
                <tr ng-repeat="a in listaAsignados" class="{{colorRow(a.saldo)}}">
                    <td>{{$index + 1}}</td>
                    <td>{{a.tipo_descripcion}}</td>
                    <td>{{a.cliente}}</td>


                    <td>{{a.precio| currency}}</td> 
                    <td>{{a.abonado| currency}}</td>
                    <td>
                        <button ng-show="a.no_abonos > 0" type="button" class="btn btn-info btn-xs" ng-click="listaPagos(a.id)" data-toggle="modal" data-target="#mListaPagos">
                            Detalle <span class="badge">{{a.no_abonos}}</span>
                        </button>
                        <p ng-show="a.no_abonos<=0"><span class="badge">0</span></p>
                    </td>
                    <td>{{a.saldo| currency}}</td>

                    <td> 
                        <span ng-if="a.estatus_descripcion == 'Cancelado'" class="label label-danger">{{a.estatus_descripcion}}</span>
                        <span ng-if="a.estatus_descripcion == 'Activo'" class="label label-success">{{a.estatus_descripcion}}</span>
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

                            <td colspan="3" class="info">Lista pagos</td>

                            <tr>
                                <th >Fecha Pago</th>
                                <th >Monto</th>
                                <th >Forma Pago</th>
                            </tr>


                            </thead>
                            <tbody>
                                <tr ng-repeat="lp in listaPagosServicioCliente">
                                    <td >{{lp.fecha_pago| date:'dd/MM/yyyy'}}</td>
                                    <td align="right" >{{lp.monto| currency}}</td>
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