

<div ng-app="pagarServicioCliente" ng-controller="pagarServicioClienteController">      

    <div ng-show="detalle == false && flagEC == false">
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form-inline">

                    <div class="form-group">
                        <label for="exampleInputName2">Nombre: </label>
                        <input type="text" ng-model="nombreCliente" class="form-control" placeholder="nombre del cliente">
                    </div>

                    <button type="button" ng-click="listadoClientes(1)" class="btn btn-default">
                        <i class="fa fa-refresh" aria-hidden="true"></i>
                    </button>                

                </form>
            </div>
        </div>


        <div>
            <table  class="table table-striped table-bordered">
                <thead>

                <td colspan="3" class="info"><h4><span class="label label-primary">{{numeroRegistrosClientes}}</span> Clientes


                    </h4>

                </td>

                <tr>
                    <th class="col-md-2">Nombre</th>

                    <th class="col-md-1"></th>
                    <th class="col-md-1"></th>
                </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="a in listaClientes">


                        <td>{{a.nombre}}</td>

                        <td>
                            <button type="button" class="btn btn-primary btn-xs" ng-click="contraerEC(a.id, a.nombre)">
                                <i class="fa fa-balance-scale" aria-hidden="true"></i> Estado de Cuenta
                            </button>
                        </td>
                        <td>
                            <span >
                                <button type="button" class="btn btn-warning btn-xs" ng-click="contraer(a.id)">
                                    <i class="fa fa-angle-double-right" aria-hidden="true"></i> Servicios Adeuda
                                </button>
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


    <div ng-show="detalle == true">
        <table class="table table-striped table-bordered" style="font-size: 14px !important">
            <thead>

            <td colspan="11" class="info"><h3>Servicios del Cliente <small>(Pagando)</small><button type="button" class="btn btn-danger btn-xs pull-right" ng-click="expandir()"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button></h3></td>

            <tr>
                <th class="col-md-2">Categoria</th>
                <th class="col-md-2">Servicio</th>
                <th class="col-md-2">Cliente </th>
                <th >Parcialidad</th>
                <th >Precio</th>
                <th >Abonado</th>
                <th >No.Abonos</th>
                <th >Adeuda</th>               
                <th class="col-md-2">Pagara</th>
                <th class="col-md-2">Descuento</th>
                <th class="col-md-2">Forma Pago<br/>
                    <select class="form-control" ng-model="globalFormaPago" ng-change="actualizarFormaPago()">
                        <option value="EFECTIVO">EFECTIVO</option>
                        <option value="TARDEB">TARJETA DEBITO</option>
                        <option value="TARCRE">TARJETA CREDITO</option>
                        <option value="CHEQUE">CHEQUE</option>
                        <option value="PAYPAL">PAYPAL</option>
                    </select>
                </th>

            </tr>


            </thead>
            <tbody>
                <tr ng-repeat="s in listaServicios">
                    <td>{{s.categoria}}</td>
                    <td><b>{{s.servicio}}</b></td>
                    <td>{{s.cliente}}</td>
                    <td>
                        <span ng-show="s.aplica_parcialidad == 1" class="label label-success">Aplica</span>
                        <span ng-show="s.aplica_parcialidad == 0" class="label label-default">No aplica</span>
                    </td>

                    <td align="right">{{s.precio| currency}}</td>
                    <td align="right">
                        {{s.abonado| currency}}
                    </td>
                    <td >
                        <button ng-show="s.no_pagos > 0" type="button" class="btn btn-info btn-xs" ng-click="listaPagos(s.id)" data-toggle="modal" data-target="#mListaPagos">
                            Detalle <span class="badge">{{s.no_pagos}}</span>
                        </button>


                    </td>

                    <td align="right" class="warning">{{(s.precio - s.abonado)| currency}}</td>

                    <td>
                        <input type="number" step="any" min="0" class="form-control" ng-model="s.pagara" ng-change="totalPagaraCalculo()">
                    </td>
                    <td>
                        <input type="number" step="any" min="0" class="form-control" ng-model="s.descuento" ng-change="totalPagaraCalculo()">
                    </td>

                    <td >
                        <select class="form-control" ng-model="s.formaPago">
                            <option value="EFECTIVO">EFECTIVO</option>
                            <option value="TARDEB">TARJETA DEBITO</option>
                            <option value="TARCRE">TARJETA CREDITO</option>
                            <option value="CHEQUE">CHEQUE</option>
                            <option value="PAYPAL">PAYPAL</option>
                        </select>
                    </td>
                </tr>

                <tr >
                    <td colspan="3"></td>
                    <td class="success"><h4><b>Total:</b></h4></td>

                    <td align="right" class="success"><h4><b>{{totalPrecio| currency}}</b></h4></td>
                    <td align="right" class="success"><h4><b>{{totalAbonado| currency}}</b></h4></td>
                    <td class="success"></td>                    
                    <td align="right" class="danger"><h4><b>{{(totalPrecio - totalAbonado)| currency}}</b></h4></td>
                    <td align="right" class="danger"><h4><b>{{totalPagara| currency}}</b></h4></td> 
                    <td align="right" class="info"><h4><b>{{totalDescuento| currency}}</b></h4></td>
                </tr>

                <tr >
                    <td colspan="7"></td>
                    <td><h4><b>Total Pagado:</b></h4></td>  
                    <td align="right" class="success"><input type="number" step="any" min="0" class="form-control" ng-model="totalIngresado" ></td>                   
                </tr>
                <tr >
                    <td colspan="7"></td>
                    <td><h4><b>Cambio:</b></h4></td>  
                    <td align="right" class="warning"><h4><b>{{(totalIngresado - totalPagara)| currency}}</b></h4></td>
                    <td align="center" class="success">
                        <button type="button" id="botonGuardarPago" class="btn btn-success" ng-click="guardarPago()"><i class="fa fa-usd" ></i> Guardar Pago <span class="badge ng-binding" >{{numPagos}}</span> </button>
                    </td>
                </tr>


            </tbody>
        </table>      


    </div>


    <!-- Estado de Cuenta    -->

    <div ng-show="flagEC == true">
        <table class="table table-striped table-bordered" style="font-size: 14px !important" ng-init="invoice = listadoMovimientos">
            <thead>

            <td colspan="4" class="info"><h3>Estado de Cuenta: <small> <b>{{nombreClienteEC}}</b></small><button type="button" class="btn btn-danger btn-xs pull-right" ng-click="expandirEC()"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button></h3>
                <form class="form-inline">
                    <div class="form-group">
                        <label for="exampleInputEmail2"> Inicio de eventos de:</label>
                        <input type="date" ng-model="fechaIniEC" class="form-control" id="exampleInputEmail2" >
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail2"> a :</label>
                        <input type="date" ng-model="fechaFinEC" class="form-control" id="exampleInputEmail2" >
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName2">Nombre: </label>
                        <input type="text" ng-model="search.nombre" class="form-control" placeholder="nombre del servicio">
                    </div>
                    <div class="form-group">
                        <button type="button" ng-click="listaMovimientos()" class="btn btn-default">
                            <i class="fa fa-refresh" aria-hidden="true"></i>
                        </button>    
                    </div>
                </form>

            </td>

            <tr>
                <th class="col-md-1">Fecha</th>
                <th class="col-md-2">Servicio</th>
                <th class="col-md-1">Adeudo </th>
                <th class="col-md-1">Pago </th>
            </tr>


            </thead>
            <tbody>
                <tr ng-repeat="m in listadoMovimientos| filter:search" class="{{colorRow(m.pago)}}" ng-init="setTotals(m)">

                    <td>{{m.fecha_registro}}</td>
                    <td><b>{{m.nombre}}</b></td>
                    <td>
                        <span ng-if="m.adeuda != 0">{{m.adeuda|currency}}</span>
                        <span ng-if="m.adeuda == 0"></span>
                    </td>
                    <td>
                        <span ng-if="m.pago != 0">{{m.pago|currency}}</span>
                        <span ng-if="m.pago == 0"></span>
                    </td>                 





                </tr>

                <tr >

                    <td>{{sumTotal((listadoMovimientos | filter: search))}}</td>
                    <td><b>TOTAL:</b></td>
                    <td><h4>{{totalAdeuda|currency}}</h4></td>
                    <td><h4>{{totalPagado|currency}}</h4></td>                    
                </tr>


            </tbody>
        </table>      


    </div>



    <!--Fin estado de cuenta-->



    <!--
    
    new modal
    -->


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


















</div><!-- fin controler angular -->




</div>