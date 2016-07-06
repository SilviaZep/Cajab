var app = angular.module('pagarServicio', []);

app.controller('pagarServicioController', ['$http', '$scope', function ($http, $scope) {

        $scope.paginaActualServiciosServicios = 1;
        $scope.paginaActualAlumnos = 1;
        $scope.paginaActualClientes = 1;
        $scope.paginaActualAsignados = 1;
        $scope.hoy = new Date();
        $scope.categoria = "0";

        $scope.mostrarDivServicio = false;


        $scope.contraer = function (s) {
            $scope.idServicio = s.id;
            $scope.tipoTransporte = s.tipo_transporte;
            $scope.aliasServicio = s.nombre;
            $scope.tipoClienteS = s.tipo_cliente;
            $scope.capacidadS = s.capacidad;
            if (s.categoria_id == undefined || s.categoria_id == null || s.categoria_id == "") {
                $scope.idCategoria = 0;
            } else {
                $scope.idCategoria = s.categoria_id;
            }
            $scope.listadoAlumnos();
            $scope.listadoClientes();
            $scope.listadoAsignados();

            contraerElemento('serviciosVigentesDiv');
            expandirElemento('edicionServiciosDiv');

        };
        $scope.expandir = function () {
            contraerElemento('edicionServiciosDiv');
            expandirElemento('serviciosVigentesDiv');
        };

        $scope.listadoCategoriasServicios = function () {
            $http({
                method: 'POST',
                url: 'servicios_listado_categorias_servicios',
                params: {
                }
            }).then(
                    function (r) {
                        if (r.data.error) {
                            alert(r.data.mensaje);
                        }
                        $scope.listaCategoriaServicios = r.data.listaCategoriaServicios;
                    }
            );
        };
        $scope.listadoCategoriasServicios();


        //-----------------Listado de servicios--------------

        $scope.listadoServicios = function (pag) {
            if (!pag) {
                pag = 1;
            }

            $scope.paginaActualServicios = pag;
            var numRegistros = 10;//se cambio para que no salga el paginador
            var max = numRegistros;
            var offset = numRegistros * ($scope.paginaActualServicios - 1);
            // var fechaIni = moment($scope.fechaIni).format('YYYY-MM-DD');           
            var nombreServicio = $scope.nombreServicio;
            var categoria = $scope.categoria;

            $http({
                method: 'POST',
                url: 'servicios_listado_servicios_vigentes',
                params: {
                    offset: offset,
                    limit: max,
                    nombreServicio: nombreServicio,
                    categoria: categoria
                }
            }).then(
                    function (r) {
                        $scope.listaServicios = r.data.listaServicios;
                        $scope.numeroRegistrosServicios = r.data.total;
                        $scope.paginador(max);
                        //finActualizar();
                    }
            );

        };

        $scope.paginador = function (max) {
            $scope.numPaginas = Math.ceil($scope.numeroRegistrosServicios / max);
            $scope.tamanioPaginador = 10;//estatico
            $scope.primera = 1;//numero de pagina de inicio
            $scope.ultima = $scope.numPaginas;//numero de pagina de fin 

            $scope.inicio = $scope.paginaActualServicios - ($scope.tamanioPaginador / 2);
            if ($scope.inicio < $scope.primera) {
                $scope.inicio = $scope.primera;
            }
            //$scope.fin = $scope.paginaActualServicios + ($scope.tamanioPaginador / 2);
            $scope.fin = $scope.inicio + $scope.tamanioPaginador;
            if ($scope.fin > $scope.ultima) {
                $scope.fin = $scope.ultima;
                $scope.inicio = $scope.ultima - $scope.tamanioPaginador;
                if ($scope.inicio < $scope.primera) {
                    $scope.inicio = $scope.primera;
                }

            }

            $scope.paginado = [];
            for (i = $scope.inicio; i <= $scope.fin; i++) {
                $scope.paginado.push(i);
            }
        };

        $scope.anterior = function () {
            $scope.paginaActualServicios = $scope.paginaActualServicios - 1;
            if ($scope.paginaActualServicios < $scope.primera) {
                $scope.paginaActualServicios = $scope.primera;
            }
            $scope.listadoServicios($scope.paginaActualServicios);
        };
        $scope.siguiente = function () {
            $scope.paginaActualServicios = $scope.paginaActualServicios + 1;
            if ($scope.paginaActualServicios > $scope.ultima) {
                $scope.paginaActualServicios = $scope.primera;
            }
            $scope.listadoServicios($scope.paginaActualServicios);


        };

        $scope.ini = function () {
            $scope.paginaActualServicios = $scope.primera;
            $scope.listadoServicios($scope.paginaActualServicios);
        };
        $scope.end = function () {
            $scope.paginaActualServicios = $scope.ultima;
            $scope.listadoServicios($scope.paginaActualServicios);
        };

        $scope.listadoServicios();


        //-----------------Fin listado servicios----------------




        //**************************Listado ALUMNOS*************************

        $scope.todosAlumnos = false;
        $scope.countSeleccionadosAlumnos = 0;

        $scope.seleccionarTodosAlumnos = function (flag) {
            $scope.countSeleccionadosAlumnos = 0;
            for (i = 0; i < $scope.listaAlumnos.length; i++) {
                $scope.listaAlumnos[i].seleccionado = flag;
                if (flag) {
                    $scope.countSeleccionadosAlumnos++;
                } else {
                    $scope.countSeleccionadosAlumnos--;
                }

            }
            if ($scope.countSeleccionadosAlumnos < 0) {
                $scope.countSeleccionadosAlumnos = 0;
            }
            $scope.todosAlumnos = flag;
        };


        $scope.seleccionarAlumno = function (a, flag) {
            a.seleccionado = flag;
            if (flag) {
                $scope.countSeleccionadosAlumnos++;
            } else {
                $scope.countSeleccionadosAlumnos--;
            }

        };



        $scope.guardarAlumnos = function () {
            var seleccionados = "";
            var i = 0;
            for (i = 0; i < $scope.listaAlumnos.length; i++) {
                if ($scope.listaAlumnos[i].seleccionado) {
                    seleccionados += $scope.listaAlumnos[i].id + ",";
                }
            }
            if (seleccionados.length == 0) {
                alert("no se han seleccionado alumnos para guardar");
                return;
            }

            $http({
                method: 'POST',
                url: 'servicios_asignar_alumnos_servicio',
                params: {
                    idAlumnos: seleccionados,
                    idServicio: $scope.idServicio
                }
            }).then(
                    function (r) {
                        alert(r.data.mensaje);
                        $scope.listadoAlumnos();
                        $scope.listadoAsignados();
                    }
            );
        };



        $scope.listadoAlumnos = function (pag) {
            if (!pag) {
                pag = 1;
            }
            $scope.countSeleccionadosAlumnos = 0;
            $scope.todosAlumnos = false;

            $scope.paginaActualAlumnos = pag;
            var numRegistros = 10;//se cambio para que no salga el paginador
            var max = numRegistros;
            var offset = numRegistros * ($scope.paginaActualAlumnos - 1);

            var nombreAlumno = $scope.nombreAlumno;

            var idServicio = $scope.idServicio;
            var idCategoria = $scope.idCategoria;
            var tipoTransporte = $scope.tipoTransporte;


            $http({
                method: 'POST',
                url: 'servicios_listado_alumnos',
                params: {
                    offset: offset,
                    limit: max,
                    nombreAlumno: nombreAlumno,
                    idServicio: idServicio,
                    idCategoria: idCategoria,
                    tipoTransporte:tipoTransporte

                }
            }).then(
                    function (r) {
                        $scope.listaAlumnos = r.data.listaAlumnos;
                        $scope.numeroRegistrosAlumnos = r.data.total;
                        $scope.paginadorAlumnos(max);
                    }
            );

        };

        $scope.paginadorAlumnos = function (max) {
            $scope.numPaginasAlumnos = Math.ceil($scope.numeroRegistrosAlumnos / max);
            $scope.tamanioPaginadorAlumnos = 10;//estatico
            $scope.primeraAlumnos = 1;//numero de pagina de inicioAlumnos
            $scope.ultimaAlumnos = $scope.numPaginasAlumnos;//numero de pagina de finAlumnos 

            $scope.inicioAlumnos = $scope.paginaActualAlumnos - ($scope.tamanioPaginadorAlumnos / 2);
            if ($scope.inicioAlumnos < $scope.primeraAlumnos) {
                $scope.inicioAlumnos = $scope.primeraAlumnos;
            }
            //$scope.finAlumnos = $scope.paginaActualAlumnos + ($scope.tamanioPaginadorAlumnos / 2);
            $scope.finAlumnos = $scope.inicioAlumnos + $scope.tamanioPaginadorAlumnos;
            if ($scope.finAlumnos > $scope.ultimaAlumnos) {
                $scope.finAlumnos = $scope.ultimaAlumnos;
                $scope.inicioAlumnos = $scope.ultimaAlumnos - $scope.tamanioPaginadorAlumnos;
                if ($scope.inicioAlumnos < $scope.primeraAlumnos) {
                    $scope.inicioAlumnos = $scope.primeraAlumnos;
                }

            }
            var i = 0;
            $scope.paginadoAlumnos = [];
            for (i = $scope.inicioAlumnos; i <= $scope.finAlumnos; i++) {
                $scope.paginadoAlumnos.push(i);
            }
        };

        $scope.anteriorAlumnos = function () {
            $scope.paginaActualAlumnos = $scope.paginaActualAlumnos - 1;
            if ($scope.paginaActualAlumnos < $scope.primeraAlumnos) {
                $scope.paginaActualAlumnos = $scope.primeraAlumnos;
            }
            $scope.listadoAlumnos($scope.paginaActualAlumnos);
        };
        $scope.siguienteAlumnos = function () {
            $scope.paginaActualAlumnos = $scope.paginaActualAlumnos + 1;
            if ($scope.paginaActualAlumnos > $scope.ultimaAlumnos) {
                $scope.paginaActualAlumnos = $scope.primeraAlumnos;
            }
            $scope.listadoAlumnos($scope.paginaActualAlumnos);


        };

        $scope.iniAlumnos = function () {
            $scope.paginaActualAlumnos = $scope.primeraAlumnos;
            $scope.listadoAlumnos($scope.paginaActualAlumnos);
        };
        $scope.endAlumnos = function () {
            $scope.paginaActualAlumnos = $scope.ultimaAlumnos;
            $scope.listadoAlumnos($scope.paginaActualAlumnos);
        };

        //    $scope.listadoAlumnos();





        //-----------------Fin listado Alumnos---------------


        //**************************Listado Clientes*************************
        $scope.todosClientes = false;
        $scope.countSeleccionadosClientes = 0;


        $scope.guardarClientes = function () {
            var seleccionados = "";
            var i = 0;
            for (i = 0; i < $scope.listaClientes.length; i++) {
                if ($scope.listaClientes[i].seleccionado) {
                    seleccionados += $scope.listaClientes[i].id + ",";
                }
            }
            if (seleccionados.length == 0) {
                alert("no se han seleccionado clientes para guardar");
                return;
            }
            $http({
                method: 'POST',
                url: 'servicios_asignar_clientes_servicio',
                params: {
                    idClientes: seleccionados,
                    idServicio: $scope.idServicio
                }
            }).then(
                    function (r) {
                        alert(r.data.mensaje);
                        $scope.listadoClientes();
                        $scope.listadoAsignados();
                    }
            );


        };


        $scope.seleccionarTodosClientes = function (flag) {
            $scope.countSeleccionadosClientes = 0;
            for (i = 0; i < $scope.listaClientes.length; i++) {
                $scope.listaClientes[i].seleccionado = flag;
                if (flag) {
                    $scope.countSeleccionadosClientes++;
                } else {
                    $scope.countSeleccionadosClientes--;
                }
            }
            if ($scope.countSeleccionadosClientes < 0) {
                $scope.countSeleccionadosClientes = 0;
            }
            $scope.todosClientes = flag;
        };

        $scope.seleccionarCliente = function (c, flag) {
            c.seleccionado = flag;
            if (flag) {
                $scope.countSeleccionadosClientes++;
            } else {
                $scope.countSeleccionadosClientes--;
            }

        };


        $scope.listadoClientes = function (pag) {
            if (!pag) {
                pag = 1;
            }
            $scope.countSeleccionadosClientes = 0;
            $scope.todosClientes = false;

            $scope.paginaActualClientes = pag;
            var numRegistros = 10;//se cambio para que no salga el paginador
            var max = numRegistros;
            var offset = numRegistros * ($scope.paginaActualClientes - 1);

            var nombreCliente = $scope.nombreCliente;
            var idServicio = $scope.idServicio;
            var idCategoria = $scope.idCategoria;
            var tipoTransporte=$scope.tipoTransporte;

            $http({
                method: 'POST',
                url: 'servicios_listado_clientes_externos',
                params: {
                    offset: offset,
                    limit: max,
                    nombreCliente: nombreCliente,
                    idServicio: idServicio,
                    idCategoria: idCategoria,
                    tipoTransporte:tipoTransporte
                }
            }).then(
                    function (r) {
                        $scope.listaClientes = r.data.listaClientes;
                        $scope.numeroRegistrosClientes = r.data.total;
                        $scope.paginadorClientes(max);
                    }
            );

        };

        $scope.paginadorClientes = function (max) {
            $scope.numPaginasClientes = Math.ceil($scope.numeroRegistrosClientes / max);
            $scope.tamanioPaginadorClientes = 10;//estatico
            $scope.primeraClientes = 1;//numero de pagina de inicioClientes
            $scope.ultimaClientes = $scope.numPaginasClientes;//numero de pagina de finClientes 

            $scope.inicioClientes = $scope.paginaActualClientes - ($scope.tamanioPaginadorClientes / 2);
            if ($scope.inicioClientes < $scope.primeraClientes) {
                $scope.inicioClientes = $scope.primeraClientes;
            }
            //$scope.finClientes = $scope.paginaActualClientes + ($scope.tamanioPaginadorClientes / 2);
            $scope.finClientes = $scope.inicioClientes + $scope.tamanioPaginadorClientes;
            if ($scope.finClientes > $scope.ultimaClientes) {
                $scope.finClientes = $scope.ultimaClientes;
                $scope.inicioClientes = $scope.ultimaClientes - $scope.tamanioPaginadorClientes;
                if ($scope.inicioClientes < $scope.primeraClientes) {
                    $scope.inicioClientes = $scope.primeraClientes;
                }

            }

            $scope.paginadoClientes = [];
            for (i = $scope.inicioClientes; i <= $scope.finClientes; i++) {
                $scope.paginadoClientes.push(i);
            }
        };

        $scope.anteriorClientes = function () {
            $scope.paginaActualClientes = $scope.paginaActualClientes - 1;
            if ($scope.paginaActualClientes < $scope.primeraClientes) {
                $scope.paginaActualClientes = $scope.primeraClientes;
            }
            $scope.listadoClientes($scope.paginaActualClientes);
        };
        $scope.siguienteClientes = function () {
            $scope.paginaActualClientes = $scope.paginaActualClientes + 1;
            if ($scope.paginaActualClientes > $scope.ultimaClientes) {
                $scope.paginaActualClientes = $scope.primeraClientes;
            }
            $scope.listadoClientes($scope.paginaActualClientes);


        };

        $scope.iniClientes = function () {
            $scope.paginaActualClientes = $scope.primeraClientes;
            $scope.listadoClientes($scope.paginaActualClientes);
        };
        $scope.endClientes = function () {
            $scope.paginaActualClientes = $scope.ultimaClientes;
            $scope.listadoClientes($scope.paginaActualClientes);
        };



//**************Fin listado clientes

        //**************************Listado Asignados*************************
        $scope.todosAsignados = false;
        $scope.countSeleccionadosAsignados = 0;


        $scope.guardarAsignados = function () {
            var seleccionados = "";
            var i = 0;
            for (i = 0; i < $scope.listaAsignados.length; i++) {
                if ($scope.listaAsignados[i].seleccionado) {
                    seleccionados += $scope.listaAsignados[i].id + ",";
                }
            }
            if (seleccionados.length == 0) {
                alert("no se han seleccionado Asignados para guardar");
                return;
            }
            $http({
                method: 'POST',
                url: 'servicios_asignar_Asignados_servicio',
                params: {
                    idAsignados: seleccionados,
                    idServicio: 1
                }
            }).then(
                    function (r) {
                        alert(r.data.mensaje);
                        $scope.listadoAsignados();
                    }
            );


        };


        $scope.seleccionarTodosAsignados = function (flag) {
            $scope.countSeleccionadosAsignados = 0;
            for (i = 0; i < $scope.listaAsignados.length; i++) {
                $scope.listaAsignados[i].seleccionado = flag;
                if (flag) {
                    $scope.countSeleccionadosAsignados++;
                } else {
                    $scope.countSeleccionadosAsignados--;
                }
            }
            if ($scope.countSeleccionadosAsignados < 0) {
                $scope.countSeleccionadosAsignados = 0;
            }
            $scope.todosAsignados = flag;
        };

        $scope.seleccionarAsignado = function (c, flag) {
            c.seleccionado = flag;
            if (flag) {
                $scope.countSeleccionadosAsignados++;
            } else {
                $scope.countSeleccionadosAsignados--;
            }

        };


        $scope.listadoAsignados = function (pag) {
            if (!pag) {
                pag = 1;
            }
            $scope.countSeleccionadosAsignados = 0;
            $scope.todosAsignados = false;

            $scope.paginaActualAsignados = pag;
            var numRegistros = 10;//se cambio para que no salga el paginador
            var max = numRegistros;
            var offset = numRegistros * ($scope.paginaActualAsignados - 1);

            var nombreCliente = $scope.nombreAsignado;

            $http({
                method: 'POST',
                url: 'servicios_asignados_a_servicio',
                params: {
                    offset: offset,
                    limit: max,
                    nombreCliente: nombreCliente,
                    idServicio: $scope.idServicio
                }
            }).then(
                    function (r) {
                        $scope.listaAsignados = r.data.listaAsignados;
                        $scope.numeroRegistrosAsignados = r.data.total;
                        $scope.paginadorAsignados(max);
                    }
            );

        };

        $scope.paginadorAsignados = function (max) {
            $scope.numPaginasAsignados = Math.ceil($scope.numeroRegistrosAsignados / max);
            $scope.tamanioPaginadorAsignados = 10;//estatico
            $scope.primeraAsignados = 1;//numero de pagina de inicioAsignados
            $scope.ultimaAsignados = $scope.numPaginasAsignados;//numero de pagina de finAsignados 

            $scope.inicioAsignados = $scope.paginaActualAsignados - ($scope.tamanioPaginadorAsignados / 2);
            if ($scope.inicioAsignados < $scope.primeraAsignados) {
                $scope.inicioAsignados = $scope.primeraAsignados;
            }
            //$scope.finAsignados = $scope.paginaActualAsignados + ($scope.tamanioPaginadorAsignados / 2);
            $scope.finAsignados = $scope.inicioAsignados + $scope.tamanioPaginadorAsignados;
            if ($scope.finAsignados > $scope.ultimaAsignados) {
                $scope.finAsignados = $scope.ultimaAsignados;
                $scope.inicioAsignados = $scope.ultimaAsignados - $scope.tamanioPaginadorAsignados;
                if ($scope.inicioAsignados < $scope.primeraAsignados) {
                    $scope.inicioAsignados = $scope.primeraAsignados;
                }

            }

            $scope.paginadoAsignados = [];
            for (i = $scope.inicioAsignados; i <= $scope.finAsignados; i++) {
                $scope.paginadoAsignados.push(i);
            }
        };

        $scope.anteriorAsignados = function () {
            $scope.paginaActualAsignados = $scope.paginaActualAsignados - 1;
            if ($scope.paginaActualAsignados < $scope.primeraAsignados) {
                $scope.paginaActualAsignados = $scope.primeraAsignados;
            }
            $scope.listadoAsignados($scope.paginaActualAsignados);
        };
        $scope.siguienteAsignados = function () {
            $scope.paginaActualAsignados = $scope.paginaActualAsignados + 1;
            if ($scope.paginaActualAsignados > $scope.ultimaAsignados) {
                $scope.paginaActualAsignados = $scope.primeraAsignados;
            }
            $scope.listadoAsignados($scope.paginaActualAsignados);


        };

        $scope.iniAsignados = function () {
            $scope.paginaActualAsignados = $scope.primeraAsignados;
            $scope.listadoAsignados($scope.paginaActualAsignados);
        };
        $scope.endAsignados = function () {
            $scope.paginaActualAsignados = $scope.ultimaAsignados;
            $scope.listadoAsignados($scope.paginaActualAsignados);
        };


        $scope.cambiarEstatusAsignado = function (a) {
            $scope.idSerClienteEstatus = a.id;
            $scope.estatusCambioA = a.estatus;
        };
        $scope.guardarCambioEstatus = function () {
            var idSerCli = $scope.idSerClienteEstatus;
            var estatus = $scope.estatusCambioA;

            $http({
                method: 'POST',
                url: 'servicios_cambiar_estatus_servicio_cliente',
                params: {
                    idServicioCliente: idSerCli,
                    estatus: estatus
                }
            }).then(
                    function (r) {
                        cerrarModal('modalCambiarEstatus');
                        alert(r.data.mensaje);
                        $scope.listadoAsignados($scope.paginaActualAsignados);
                    }
            );
        };



//**************Fin listado Asignados





    }]);


function inicioActualizar() {

    $("#botonActualizar").removeClass("fa-refresh");
    $("#botonActualizar").addClass("fa-spinner fa-spin");

}

function finActualizar() {
    //$('#botonActualizar').removeClass('disabled');
    $("#botonActualizar").removeClass("fa-spinner fa-spin");
    $("#botonActualizar").addClass("fa-refresh");


}


function expandirElemento(x) {
    $("#" + x).removeClass("collapse");
}

function contraerElemento(x) {
    $("#" + x).addClass("collapse");
}


function cerrarModal(idModal) {
    $("#" + idModal).modal("hide");
}