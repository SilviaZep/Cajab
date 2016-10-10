

<div ng-app="rutas" ng-controller="rutasController">      


    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-inline">

                <div class="form-group">
                    <label for="exampleInputName2">Nombre: </label>
                    <input type="text" ng-model="nombreRuta" class="form-control" placeholder="nombre de la ruta">
                </div>
                <button type="button" ng-click="listadoRutas(1)" class="btn btn-default">
                    <i class="fa fa-refresh" aria-hidden="true"></i>
                </button>

                <button type="button" ng-click="limpiarModalRutas()" class="btn btn-success pull-right" data-toggle="modal"  data-target="#crearRuta"><i class="fa fa-plus-square" aria-hidden="true"></i>  Nueva Ruta</button>

            </form>
        </div>
    </div>

    <div>
        <table class="table table-striped table-bordered">
            <thead>

            <td colspan="9" class="info"><b>Lista de Rutas</b></td>

            <tr>
                <th class="col-md-2">Nombre</th>
                <th class="col-md-2">Descripcion</th>
                <th class="col-md-1">Horario</th>
                <th class="col-md-1">Capacidad</th>
                <th class="col-md-1">Conductor</th>
                <th class="col-md-1"></th>
                <th class="col-md-1"></th>




            </tr>


            </thead>
            <tbody>
                <tr ng-repeat="r in listaRutas | orderBy:'nombre'">

                 
                    <td>{{r.nombre}}</td>
                    <td>{{r.descripcion}}</td>
                    <td>{{r.horario}}</td>
                    <td>{{r.capacidad}}</td>
                    <td>{{r.chofer}}</td>
                   


                    <td> <button type="button" ng-click="editarRuta(r)" data-toggle="modal"  data-target="#crearRuta" class="btn btn-warning btn-xs"> <i class="fa fa-pencil" aria-hidden="true"></i> Editar</button></td>
                    <td> <button type="button" ng-click="eliminarRuta(r.id)" class="btn btn-danger btn-xs"> <i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</button></td>



                </tr>


            </tbody>
        </table>

        <br />
        <nav ng-show="numPaginas > 1">
            <ul class="pagination">                             
                <li><a ng-click="ini()">INI</a></li>
                <li><a ng-click="anterior()">Ant</a ></li>
                <li  ng-repeat="x in paginado">
                    <a ng-click="listadoRutas(x)" ng-if="x == paginaActual" ><span class="badge">{{x}}</span></a>
                    <a ng-click="listadoRutas(x)" ng-if="x != paginaActual" >{{x}}</a>
                </li>
                <li><a ng-click="siguiente()">Sig</a></li>
                <li><a ng-click="end()">FIN</a></li>
            </ul>
        </nav>


    </div>

    <!--Modal cambiar de ruta-->
    <div>

        <div class="modal fade" id="crearRuta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 ng-show="editando == false" class="modal-title" id="myModalLabel">Nuevo Servicio</h4>
                        <h4 ng-show="editando == true" class="modal-title" id="myModalLabel">Editar Servicio</h4>
                    </div>
                    <div class="modal-body">

                        <form class="form-horizontal">
                            <div class="form-group">
                                <label  class="col-sm-2 control-label "  style="text-align: left !important">Nombre: </label>
                                <div class="col-sm-10">
                                    <input type="text" ng-model="mNombre" class="form-control" placeholder="Nombre Ruta">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label "  style="text-align: left !important">Descripci&oacute;n </label>
                                <div class="col-sm-10">
                                    <textarea rows="4" cols="50" ng-model="mDescripcion" placeholder="Lugares donde pasa la ruta"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label "  style="text-align: left !important">Horario: </label>
                                <div class="col-sm-3">
                                    <input type="text" ng-model="mHorario" class="form-control" placeholder="Horario asignado a la ruta">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label "  style="text-align: left !important">Capacidad:</label>
                                <div class="col-sm-3">
                                    <input type="number" ng-model="mCapacidad" class="form-control" placeholder="Numero de pasajeros que puede llevar">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label "  style="text-align: left !important">Conductor: </label>
                                <div class="col-sm-10">
                                    <input type="text" ng-model="mConductor" class="form-control" placeholder="Nombre del conductor">
                                </div>
                            </div>




                        </form>




                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button ng-show="editando == false" type="button" class="btn btn-success" ng-click="guardarRuta()">Guardar</button>
                        <button ng-show="editando == true" type="button" class="btn btn-success" ng-click="guardarRuta()">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>

    </div>




</div>