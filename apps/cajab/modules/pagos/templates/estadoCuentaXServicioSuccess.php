

<div ng-app="estadoCuentaXServicio" ng-controller="estadoCuentaXServicioController">      


    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-inline">
                <div class="form-group">
                    <label for="exampleInputEmail2"> Nombre :</label>
                    <input type="text" ng-model="nombreServicio" class="form-control" placeholder="Nombre Servicio" id="exampleInputEmail2" >
                </div>
                <!-- <div class="form-group">
                     <label for="exampleInputEmail2"> # Recibo :</label>
                     <input type="number" ng-model="numRecibo" class="form-control" id="exampleInputEmail2" >
                 </div>-->
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
                    <label for="exampleInputEmail2"> Fecha Pago:</label>
                    <input type="date" ng-model="fechaIni" class="form-control" id="exampleInputEmail2" >
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail2"> a :</label>
                    <input type="date" ng-model="fechaFin" class="form-control" id="exampleInputEmail2" >
                </div>


                <button type="submit" ng-click="listadoEstadoCuentaServicio()" class="btn btn-default">
                    <i class="fa fa-refresh" aria-hidden="true"></i>
                </button>


            </form>
        </div>
    </div>

    <div>
        <table class="table table-striped table-bordered" style="font-size: 14px !important">
            <thead>

            <td colspan="8" class="info">

                <h4>
                    Listado De Servicios
                    <!--   <button ng-show="listaMovimientos.length > 0"  type="button" class="btn btn-default pull-right" ng-click="listaMovimientosImprimir()">
                           <i class="fa fa-print" aria-hidden="true"> Imprimir</i>
                       </button>-->
                </h4>
            </td>

            <tr>

                <th class="col-md-3">Nombre Servicio</th>
                <th class="col-md-1">Precio</th>
                <th class="col-md-1">Inscritos</th>               
                <th class="col-md-1">Esperado</th>
                <th class="col-md-1">Pagado</th>
                <th class="col-md-1">Egresos </th>  
            </tr>


            </thead>
            <tbody>
                <tr ng-repeat="s in listaServiciosInfo">
                    <td>{{s.nombre}}</td>
                    <td align="right">{{s.precio|currency}}</td>
                    <td>{{s.inscritos}}</td>
                    <td align="right">{{s.esperado|currency}}</td>
                    <td align="right">{{s.pagado|currency}}</td>
                    <td align="right">{{s.egresos|currency}}</td>
                </tr>


            </tbody>
        </table>



    </div>







</div>