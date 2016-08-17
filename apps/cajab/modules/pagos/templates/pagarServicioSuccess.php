

<div ng-app="pagarServicio" ng-controller="pagarServicioController">      

    <div ng-show="detalle == false">
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form-inline">

                    <div class="form-group">
                        <label for="exampleInputName2">Nombre: </label>
                        <input type="text" ng-model="nombreAlumno" class="form-control" placeholder="nombre del alumno">
                    </div>

                    <button type="button" ng-click="listadoAlumnos(1)" class="btn btn-default">
                        <i class="fa fa-refresh" aria-hidden="true"></i>
                    </button>                

                </form>
            </div>
        </div>


        <div>
            <table  class="table table-striped table-bordered">
                <thead>

                <td colspan="4" class="info"><h4><span class="label label-primary">{{numeroRegistrosAlumnos}}</span> Alumnos


                    </h4>

                </td>

                <tr>
                    <th class="col-md-2">Nombre</th>
                    <th class="col-md-1">Grado</th>                        
                    <th class="col-md-1">Grupo</th>                        
                    <th class="col-md-1"></th>
                </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="a in listaAlumnos">


                        <td>{{a.nombre}}</td>
                        <td>{{a.grado}}</td>  
                        <td>{{a.grupo}}</td>      
                        <td>
                            <span >
                                <button type="button" class="btn btn-info btn-xs" ng-click="contraer(a.id)">
                                    <i class="fa fa-angle-double-right" aria-hidden="true"></i> Detalles
                                </button>
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


    <div ng-show="detalle == true">
        <table class="table table-striped table-bordered" style="font-size: 14px !important">
            <thead>

            <td colspan="10" class="info"><h3>Servicios del alumno <small>(Pagando)</small><button type="button" class="btn btn-danger btn-xs pull-right" ng-click="expandir()"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button></h3></td>

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
                        <button ng-show="s.no_pagos>0" type="button" class="btn btn-info btn-xs" ng-click="listaPagos(s.id)" data-toggle="modal" data-target="#mListaPagos">
                            Detalle <span class="badge">{{s.no_pagos}}</span>
                        </button>


                    </td>

                    <td align="right" class="warning">{{(s.precio - s.abonado)| currency}}</td>

                    <td>
                        <input type="number" step="any" min="0" class="form-control" ng-model="s.pagara" ng-change="totalPagaraCalculo()">
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
                    <td></td>
                    <td align="right" class="success"><h4><b>{{totalAdeuda| currency}}</b></h4></td>
                    <td align="right" class="success"><h4><b>{{totalPagara| currency}}</b></h4></td>
                    <td align="center" class="success">
                        <button type="button" class="btn btn-success" id="botonGuardarPago" ng-click="guardarPago()"><i class="fa fa-usd" aria-hidden="true"></i> Guardar Pago <span class="badge ng-binding" >{{numPagos}}</span> </button>
                    </td>





                </tr>


            </tbody>
        </table>      


    </div>




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


















</div><!-- fin controler angular -->




</div>