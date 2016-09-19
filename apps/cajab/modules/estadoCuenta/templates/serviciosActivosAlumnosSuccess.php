

<div ng-app="servActivosAlumno" ng-controller="servActivosAlumnoController">      


    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-inline">

                <div class="form-group">
                    <span ng-show="soloTransporte">
                        <button type="button" class="btn btn-info btn-xs" ng-click="filtrarAlumnos('t', false)">
                            Todos los alumnos con servicios
                        </button>
                    </span>
                    <span ng-show="!soloTransporte">
                        <button type="button" class="btn btn-warning btn-xs" ng-click="filtrarAlumnos('t', true)">
                            Solo alumnos con transporte
                        </button>
                    </span>
                    <span ng-show="mayoresDeDos">
                        <button type="button" class="btn btn-info btn-xs" ng-click="filtrarAlumnos('m', false)">
                            Todos
                        </button>
                    </span>
                    <span ng-show="!mayoresDeDos">
                        <button type="button" class="btn btn-warning btn-xs" ng-click="filtrarAlumnos('m', true)">                            
                            Mas de 1 servicios 
                        </button>
                    </span>
                </div>




            </form>
        </div>
    </div>

    <div>
        <table class="table table-striped table-bordered" style="font-size: 14px !important">
            <thead>

            <td colspan="4" class="info"><b>Listado De Alumnos con Servicios</b></td>

            <tr>

                <th class="col-md-2">Nombre</th>
                <th class="col-md-1">No.Serv </th>
                <th class="col-md-8">Servicios </th>    
                <th class="col-md-1"></th>                                
            </tr>


            </thead>
            <tbody>
                <tr ng-repeat="a in listaServiciosVigentes">
                    <td>{{a.cliente}}</td>
                    <td>{{a.no_servicios}}</td>
                    <td>{{a.servicios}}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-xs" ng-click="llamarPagos('Alumno', a.cliente)">
                            <i class="fa fa-share" aria-hidden="true"></i> Caja
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
                    <a ng-click="listadoServiciosVigentesAlumnos(x)" ng-if="x == paginaActual" ><span class="badge">{{x}}</span></a>
                    <a ng-click="listadoServiciosVigentesAlumnos(x)" ng-if="x != paginaActual" >{{x}}</a>
                </li>
                <li><a ng-click="siguiente()">Sig</a></li>
                <li><a ng-click="end()">FIN</a></li>
            </ul>
        </nav>


    </div>





</div><!-- div controller-->