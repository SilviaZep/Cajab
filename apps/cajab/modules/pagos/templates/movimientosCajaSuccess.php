

<div ng-app="movimientoCaja" ng-controller="movimientoCajaController">      


    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-inline">
                <div class="form-group">
                    <label for="exampleInputEmail2"> Nombre :</label>
                    <input type="text" ng-model="nombreServicio" class="form-control" placeholder="Nombre Servicio" id="exampleInputEmail2" >
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail2"> Seccion :</label>
                    <input type="text" ng-model="nombreSeccion" class="form-control" placeholder="seccion grado grupo" id="exampleInputEmail2" >
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail2"> # Recibo :</label>
                    <input type="number" ng-model="numRecibo" class="form-control" id="exampleInputEmail2" >
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail2"> Forma de Pago :</label>
                    <select class="form-control" ng-model="formaPago">
                        <option value="NA">TODAS</option>
                        <option value="EFECTIVO">EFECTIVO</option>
                        <option value="TARDEB">TARJETA DEBITO</option>
                        <option value="TARCRE">TARJETA CREDITO</option>
                        <option value="CHEQUE">CHEQUE</option>
                        <option value="PAYPAL">PAYPAL</option>
                    </select>
                </div>
                <div class="form-group">  
                    <label for="exampleInputName2"> Categoria: </label>
                    <select  ng-model="categoria" class="form-control">      
                        <option value="0" >Todas</option>
                        <option ng-repeat="c in listaCategoriaServicios" ng-value="c.id" >{{c.categoria}}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail2"> Fecha Pago:</label>
                    <input type="date" ng-model="fechaIni" class="form-control" id="exampleInputEmail2" >
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail2"> a :</label>
                    <input type="date" ng-model="fechaFin" class="form-control" id="exampleInputEmail2" >
                </div>


                <button type="submit" ng-click="listadoMovimientosCaja()" class="btn btn-default">
                    <i class="fa fa-refresh" aria-hidden="true" id="botonActualizar"></i>
                </button>


            </form>
        </div>
    </div>

    <div>
        <table class="table table-striped table-bordered" style="font-size: 14px !important">
            <thead>

            <td colspan="10" class="info">

                <h4>
                    Listado De Movimientos
                    <span class="label label-success">Total Ingresos: <b>{{totalPagado|currency}}</b></span>
                    <span class="label label-warning">Total Descuentos: <b>{{totalDescuento|currency}}</b></span>
                    <span class="label label-danger">Total Egresos: <b>{{totalEgreso|currency}}</b></span>
                    <span class="label label-primary">Total Ingresos-Desc-Egresos: <b>{{totalMonto|currency}}</b></span>
                    <button type="button" class="btn btn-default btn-sm" >
                        <span ng-show="tipoArchivo == 'PDF'" ng-click="tipoArchivo = 'TICKET'"><i class="fa fa-file-pdf-o" aria-hidden="true" style="color:red"></i> PDF</span>
                        <span ng-show="tipoArchivo == 'TICKET'"  ng-click="tipoArchivo = 'PDF'"><i class="fa fa-file-text-o" aria-hidden="true"></i> TICKET</span>
                    </button>
                    <button ng-show="listaMovimientos.length > 0"  type="button" class="btn btn-default pull-right" ng-click="listaMovimientosImprimir()">
                        <i class="fa fa-print" aria-hidden="true"> Imprimir</i>
                    </button>
                </h4>
            </td>

            <tr>
                <th class="col-md-1">Tipo</th>
                <th class="col-md-1">Categoria</th>
                <th class="col-md-1">Nombre Servicio</th>
                <th class="col-md-1">Tipo Cliente</th>
                <th class="col-md-3">Cliente</th>

                <th class="col-md-1">Monto</th>               
                <th class="col-md-1">Descuento</th>

                <th class="col-md-1">Fecha Pago</th>
                <th class="col-md-1">Forma Pago </th>               
                <th class="col-md-1"># Recibo</th>







            </tr>


            </thead>
            <tbody>
                <tr ng-repeat="m in listaMovimientos">


                    <td>
                        <span ng-if="m.tipo == 'ingreso'" class="label label-success">INGRESO</span>
                        <span ng-if="m.tipo == 'egreso'" class="label label-danger">EGRESO</span>    
                    </td>
                    <td>{{m.nombre_categoria}}</td>
                    <td>{{m.nombre_servicio}}</td>
                    <td>{{m.tipo_descripcion}}</td>
                    <td>{{m.cliente}}</td>

                    <td align="right">{{m.monto| currency}}</td>
                    <td align="right">{{m.descuento| currency}}</td>
                    <td>{{m.fecha_pago| date:"dd/MM/yyyy"}}</td>

                    <td>{{m.forma_pago}}</td>
                    <td>
                        <span ng-show="m.tipo == 'ingreso'">
                            <div style="padding: 10px"><b># {{m.id_pago}} </b>
                                <span ng-if="m.estatus_pago == 'Cancelado'" class="label label-warning">{{m.estatus_pago}}</span>
                                <span ng-if="m.estatus_pago == 'Pagado'" class="label label-info">{{m.estatus_pago}}</span>                 
                            </div>
                            <div class="form-group">

                                <button type="button" class="btn btn-default" ng-click="reImprimirTicket(m.id_pago)">
                                    <i class="fa fa-print" aria-hidden="true"> </i>
                                </button>
                                <button type="button" class="btn btn-danger " ng-click="eliminarPagos(m.id_pago)">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
                            </div>
                        </span>
                    </td>




                </tr>


            </tbody>
        </table>



    </div>







</div>