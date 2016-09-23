

<div ng-app="servicioDiasMora" ng-controller="servicioDiasMoraController">      

    <div > 
        <div class="panel panel-default" ng-show="false">
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
                    <button type="button" ng-click="listadoDiasMora(1)" class="btn btn-default">
                        <i class="fa fa-refresh" aria-hidden="true"></i>
                    </button>



                </form>
            </div>
        </div>

        <div>
            <table class="table table-striped table-bordered" style="font-size: 14px !important">
                <thead>

                <td colspan="11" class="info"><b>Listado Dias de mora al dia de : {{fechaHoy| date:"dd/MM/yyyy"}}</b></td>

                <tr>                    
                    <th class="col-md-1">Tipo Cliente </th>
                    <th class="col-md-3">Cliente </th>
                    <th class="col-md-2">Servicio</th>
                    <th class="col-md-1">Precio</th>
                    <th class="col-md-1">Abonado </th>
                    <th class="col-md-1">Descuento </th>
                    <th class="col-md-1">No.Abonos</th> 
                    <th class="col-md-1">Saldo</th> 
                    <th class="col-md-1">Ultimo dia (Pagar)</th>

                    <th class="col-md-1">Dias de mora </th>
                    <th class="col-md-1"></th>
                </tr>


                </thead>
                <tbody>
                    <tr ng-repeat="s in listaDiasMora" class="{{colorRow(s.dias_mora)}}" ><!--style="border: gray 3px solid !important"-->



                        <td>{{s.tipo_descripcion}}</td>
                        <td><b>{{s.cliente}}</b></td>
                        <td>{{s.servicio}}</td>
                        <td>{{s.precio| currency}}</td>
                        <td>{{s.abonado| currency}}</td>
                        <td>{{s.descuento| currency}}</td>
                        <td>
                            <button ng-show="s.no_abonos > 0" type="button" class="btn btn-info btn-xs" ng-click="listaPagos(s.id)" data-toggle="modal" data-target="#mListaPagos">
                                Detalle <span class="badge">{{s.no_abonos}}</span>
                            </button>
                            <p ng-show="s.no_abonos <= 0"><span class="badge">0</span></p>
                        </td>
                        <td><b>{{s.saldo| currency}}</b></td>
                        <td>{{s.fecha_fin| date:"dd/MM/yyyy"}}</td>

                        <td>{{s.dias_mora}}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-xs" ng-click="llamarPagos(s.tipo_descripcion, s.cliente)">
                                <i class="fa fa-share" aria-hidden="true"></i> Caja
                            </button>
                        </td>



<!--<td><font color="#0B6121"><b>{{s.fecha_evento| date:"dd/MM/yyyy"}}</b></font></td>
<td>{{s.nombre}}</td>
<td>{{s.precio| currency}}</td>

<td>{{s.tip_cli}}</td>
<td>{{s.capacidad}}</td>-->


                    </tr>


                </tbody>
            </table>

            <br />
            <nav ng-show="numPaginas > 1">
                <ul class="pagination">                             
                    <li><a ng-click="ini()">INI</a></li>
                    <li><a ng-click="anterior()">Ant</a ></li>
                    <li  ng-repeat="x in paginado">
                        <a ng-click="listadoDiasMora(x)" ng-if="x == paginaActual" ><span class="badge">{{x}}</span></a>
                        <a ng-click="listadoDiasMora(x)" ng-if="x != paginaActual" >{{x}}</a>
                    </li>
                    <li><a ng-click="siguiente()">Sig</a></li>
                    <li><a ng-click="end()">FIN</a></li>
                </ul>
            </nav>


        </div>
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