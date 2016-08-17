
<div ng-app="horarios" ng-controller="horariosController">   

    <div class="panel panel-default col-md-12">
        <div class="panel-body">
            <label>Rutas:</label>
            <form class="form-inline">

                <button  class="btn btn-default" ng-repeat="r in listaRutas">
                    <b>
                        <span class="label label-info">
                            <i class="fa fa-bus" aria-hidden="true"></i> {{r.nombre}}
                        </span>
                        <span class="label label-default">
                            Desc: {{r.descripcion}}
                        </span>
                        <span class="label label-primary">
                            Hor: {{r.horario}}
                        </span>                       
                        <span class="label label-warning">
                            Cap: {{r.capacidad}}
                        </span>
                        <span class="label label-success">
                            Reg:50
                        </span>
                    </b>
                </button>

            </form>
        </div>

    </div>




    <div class="panel panel-default col-md-12" >
        <div class="panel-body">
            <form class="form-inline">
                <div class="form-group">
                    <label for="exampleInputName2">Nombre: </label>
                    <input type="text" ng-model="nombreAlumno" class="form-control" placeholder="nombre del alumno">
                </div>
                <button type="button" ng-click="listadoHorarios(1)" class="btn btn-default">
                    <i class="fa fa-refresh" aria-hidden="true"></i>
                </button>
                <!--<button type="button" ng-click="limpiarModalServicio()" class="btn btn-success pull-right" data-toggle="modal"  data-target="#crearServicio"><i class="fa fa-plus-square" aria-hidden="true"></i>  Nuevo Servicio</button>-->

            </form>
        </div>
    </div>


    <div>
        <table class="table table-striped table-bordered" style="font-size: 14px !important;">
            <thead>

            <td colspan="12" class="info"><b>Listado Alumnos</b></td>
            <tr>
                <th rowspan="2">Alumno</th>
                <th rowspan="2">Tipo Transporte</th>

                <th colspan="2">Lunes</th>
                <th colspan="2">Martes</th>
                <th colspan="2">Miercoles</th>
                <th colspan="2">Jueves</th>
                <th colspan="2">Viernes</th>
                <th rowspan="2">Editar</th>

            </tr>
            <tr>
                <th><h4> Entrada</h4></th>
            <th><h4> Salida</h4></th>
            <th><h4> Entrada</h4></th>
            <th><h4> Salida</h4></th>
            <th><h4> Entrada</h4></th>
            <th><h4> Salida</h4></th>
            <th><h4> Entrada</h4></th>
            <th><h4> Salida</h4></th>
            <th><h4> Entrada</h4></th>
            <th><h4> Salida</h4></th>





            </tr>


            </thead>
            <tbody>
                <tr ng-repeat="lh in listaHorarios">
                    <td >{{lh.nombre}}</td>
                    <td >{{lh.tipo_transporte}}</td>

                    <td ng-if="lh.r_lun_e_nombre != 'No Asig.'" class="success" ><span class="label label-pill label-success" ><i class="fa fa-bus" aria-hidden="true"></i> {{lh.r_lun_e_nombre}}</td>
                    <td ng-if="lh.r_lun_e_nombre == 'No Asig.'" class="success" ><span class="label label-pill label-danger" > {{lh.r_lun_e_nombre}} </td>
                    <td ng-if="lh.r_lun_s_nombre != 'No Asig.'" class="warning" ><span class="label label-pill label-warning" ><i class="fa fa-bus" aria-hidden="true"></i> {{lh.r_lun_s_nombre}} </td>
                    <td ng-if="lh.r_lun_s_nombre == 'No Asig.'" class="warning" ><span class="label label-pill label-danger" >  {{lh.r_lun_s_nombre}} </td>

                    <td ng-if="lh.r_mar_e_nombre != 'No Asig.'" class="success" ><span class="label label-pill label-success" > <i class="fa fa-bus" aria-hidden="true"></i> {{lh.r_mar_e_nombre}} </td>
                    <td ng-if="lh.r_mar_e_nombre == 'No Asig.'" class="success" ><span class="label label-pill label-danger" >  {{lh.r_mar_e_nombre}} </td>
                    <td ng-if="lh.r_mar_s_nombre != 'No Asig.'" class="warning" ><span class="label label-pill label-warning" > <i class="fa fa-bus" aria-hidden="true"></i> {{lh.r_mar_s_nombre}} </td>
                    <td ng-if="lh.r_mar_s_nombre == 'No Asig.'" class="warning" ><span class="label label-pill label-danger" >  {{lh.r_mar_s_nombre}} </td>

                    <td ng-if="lh.r_mie_e_nombre != 'No Asig.'" class="success" ><span class="label label-pill label-success" > <i class="fa fa-bus" aria-hidden="true"></i> {{lh.r_mie_e_nombre}} </td>
                    <td ng-if="lh.r_mie_e_nombre == 'No Asig.'" class="success" ><span class="label label-pill label-danger" > {{lh.r_mie_e_nombre}} </td>
                    <td ng-if="lh.r_mie_s_nombre != 'No Asig.'" class="warning" ><span class="label label-pill label-warning" > <i class="fa fa-bus" aria-hidden="true"></i> {{lh.r_mie_s_nombre}} </td>
                    <td ng-if="lh.r_mie_s_nombre == 'No Asig.'" class="warning" ><span class="label label-pill label-danger" >  {{lh.r_mie_s_nombre}} </td>

                    <td ng-if="lh.r_jue_e_nombre != 'No Asig.'" class="success" ><span class="label label-pill label-success" > <i class="fa fa-bus" aria-hidden="true"></i> {{lh.r_jue_e_nombre}} </td>
                    <td ng-if="lh.r_jue_e_nombre == 'No Asig.'" class="success" ><span class="label label-pill label-danger" >  {{lh.r_jue_e_nombre}} </td>
                    <td ng-if="lh.r_jue_s_nombre != 'No Asig.'" class="warning" ><span class="label label-pill label-warning" > <i class="fa fa-bus" aria-hidden="true"></i> {{lh.r_jue_s_nombre}} </td>
                    <td ng-if="lh.r_jue_s_nombre == 'No Asig.'" class="warning" ><span class="label label-pill label-danger" >  {{lh.r_jue_s_nombre}} </td>

                    <td ng-if="lh.r_vie_e_nombre != 'No Asig.'" class="success" ><span class="label label-pill label-success" > <i class="fa fa-bus" aria-hidden="true"></i> {{lh.r_vie_e_nombre}} </td>
                    <td ng-if="lh.r_vie_e_nombre == 'No Asig.'" class="success" ><span class="label label-pill label-danger" >{{lh.r_vie_e_nombre}} </td>
                    <td ng-if="lh.r_vie_s_nombre != 'No Asig.'" class="warning" ><span class="label label-pill label-warning" > <i class="fa fa-bus" aria-hidden="true"></i> {{lh.r_vie_s_nombre}} </td>
                    <td ng-if="lh.r_vie_s_nombre == 'No Asig.'" class="warning" ><span class="label label-pill label-danger" >  {{lh.r_vie_s_nombre}} </td>




                    <td > <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal" ng-click="cambiarRuta(lh)">editar</button></td>


                </tr>
            </tbody>
        </table>
        <br />
        <nav ng-show="numPaginas > 1">
            <ul class="pagination">                             
                <li><a ng-click="ini()">INI</a></li>
                <li><a ng-click="anterior()">Ant</a ></li>
                <li  ng-repeat="x in paginado">
                    <a ng-click="listadoHorarios(x)" ng-if="x == paginaActual" ><span class="badge">{{x}}</span></a>
                    <a ng-click="listadoHorarios(x)" ng-if="x != paginaActual" >{{x}}</a>
                </li>
                <li><a ng-click="siguiente()">Sig</a></li>
                <li><a ng-click="end()">FIN</a></li>
            </ul>
        </nav>


    </div>

    <!--Modal cambiar de ruta-->
    <div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Cambiar de Ruta</h4>
                    </div>
                    <div class="modal-body">


                        <h4>Alumno: {{alumno}}</h4>
                        <h5>Tipo Transporte: {{tipoTransporte}}</h4>
                            <br/>
                            <div class="row">
                                <div class="col-xs-2">
                                    <label></label>
                                </div>
                                <div class="col-xs-4">
                                    <label><b>Entrada</b></label>
                                </div>
                                <div class="col-xs-4">
                                    <label><b>Salida</b></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-2">
                                    <label>Lunes: </label>
                                </div>
                                <div class="col-xs-4">
                                    <select  class="form-control" ng-model="ruta_lun_e">
                                        <option value="0">No Asig.</option>
                                        <option ng-repeat="r in listaRutas" value="{{r.id}}">{{r.nombre}}</option>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <select  class="form-control" ng-model="ruta_lun_s">
                                        <option value="0">No Asig.</option>
                                        <option ng-repeat="r in listaRutas" value="{{r.id}}">{{r.nombre}}</option>
                                    </select>
                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="col-xs-2">
                                    <label>Martes: </label>
                                </div>
                                <div class="col-xs-4">
                                    <select  class="form-control" ng-model="ruta_mar_e">
                                        <option value="0">No Asig.</option>
                                        <option ng-repeat="r in listaRutas" value="{{r.id}}">{{r.nombre}}</option>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <select  class="form-control" ng-model="ruta_mar_s">
                                        <option value="0">No Asig.</option>
                                        <option ng-repeat="r in listaRutas" value="{{r.id}}">{{r.nombre}}</option>
                                    </select>
                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="col-xs-2">
                                    <label>Miercoles: </label>
                                </div>
                                <div class="col-xs-4">
                                    <select  class="form-control" ng-model="ruta_mie_e">
                                        <option value="0">No Asig.</option>
                                        <option ng-repeat="r in listaRutas" value="{{r.id}}">{{r.nombre}}</option>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <select  class="form-control" ng-model="ruta_mie_s">
                                        <option value="0">No Asig.</option>
                                        <option ng-repeat="r in listaRutas" value="{{r.id}}">{{r.nombre}}</option>
                                    </select>
                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="col-xs-2">
                                    <label>Jueves: </label>
                                </div>
                                <div class="col-xs-4">
                                    <select  class="form-control" ng-model="ruta_jue_e">
                                        <option value="0">No Asig.</option>
                                        <option ng-repeat="r in listaRutas" value="{{r.id}}">{{r.nombre}}</option>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <select  class="form-control" ng-model="ruta_jue_s">
                                        <option value="0">No Asig.</option>
                                        <option ng-repeat="r in listaRutas" value="{{r.id}}">{{r.nombre}}</option>
                                    </select>
                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="col-xs-2">
                                    <label>Viernes: </label>
                                </div>
                                <div class="col-xs-4">
                                    <select  class="form-control" ng-model="ruta_vie_e">
                                        <option value="0">No Asig.</option>
                                        <option ng-repeat="r in listaRutas" value="{{r.id}}">{{r.nombre}}</option>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <select  class="form-control" ng-model="ruta_vie_s">
                                        <option value="0">No Asig.</option>
                                        <option ng-repeat="r in listaRutas" value="{{r.id}}">{{r.nombre}}</option>
                                    </select>
                                </div>
                            </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" ng-click="guardarCambios()">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>

    </div>




</div>