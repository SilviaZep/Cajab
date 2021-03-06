var app = angular.module('servicio', []);

app.controller('servicioController', ['$http', '$scope', function ($http, $scope) {

        $scope.paginaActual = 1;

        var date = new Date();
        // var primerDia = new Date(date.getFullYear(), date.getMonth(), 1);
        //var ultimoDia = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        var primerDia = new Date(date.getFullYear(), 0, 1);
        var ultimoDia = new Date(date.getFullYear(), date.getMonth(), date.getDate());


        $scope.fechaIni = primerDia;
        $scope.fechaFin = ultimoDia;
        $scope.categoria = "0";

        $scope.flagVentanaPrincipal = 1;//flag para mostrar o esconder ventana

        $scope.idSerImp = 0;
        $scope.totalEsperadoIE = 0;


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



        //-----------------Listado de servicios--------------

        $scope.listadoServicios = function (pag) {
            if (!pag) {
                pag = 1;
            }

            $scope.paginaActual = pag;
            var numRegistros = 10;//se cambio para que no salga el paginador
            var max = numRegistros;
            var offset = numRegistros * ($scope.paginaActual - 1);


            var fechaIni = moment($scope.fechaIni).format('YYYY-MM-DD');
            var fechaFin = moment($scope.fechaFin).format('YYYY-MM-DD');
            var nombreServicio = $scope.nombreServicio;
            var categoria = $scope.categoria;

            if ($scope.fechaIni > $scope.fechaFin) {
                alert("La fecha Desde no puede ser mayor a Fecha Fin");
                return;
            }

            $http({
                method: 'POST',
                url: 'servicios_listado_servicios',
                params: {
                    offset: offset,
                    limit: max,
                    fechaIni: fechaIni,
                    fechaFin: fechaFin,
                    nombreServicio: nombreServicio,
                    categoria: categoria
                }
            }).then(
                    function (r) {
                        $scope.listaServicios = r.data.listaServicios;
                        $scope.numeroRegistros = r.data.total;
                        $scope.paginador(max);
                        //finActualizar();
                    }
            );

        };

        $scope.paginador = function (max) {
            $scope.numPaginas = Math.ceil($scope.numeroRegistros / max);
            $scope.tamanioPaginador = 10;//estatico
            $scope.primera = 1;//numero de pagina de inicio
            $scope.ultima = $scope.numPaginas;//numero de pagina de fin 

            $scope.inicio = $scope.paginaActual - ($scope.tamanioPaginador / 2);
            if ($scope.inicio < $scope.primera) {
                $scope.inicio = $scope.primera;
            }
            //$scope.fin = $scope.paginaActual + ($scope.tamanioPaginador / 2);
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
            $scope.paginaActual = $scope.paginaActual - 1;
            if ($scope.paginaActual < $scope.primera) {
                $scope.paginaActual = $scope.primera;
            }
            $scope.listadoServicios($scope.paginaActual);
        };
        $scope.siguiente = function () {
            $scope.paginaActual = $scope.paginaActual + 1;
            if ($scope.paginaActual > $scope.ultima) {
                $scope.paginaActual = $scope.primera;
            }
            $scope.listadoServicios($scope.paginaActual);


        };

        $scope.ini = function () {
            $scope.paginaActual = $scope.primera;
            $scope.listadoServicios($scope.paginaActual);
        };
        $scope.end = function () {
            $scope.paginaActual = $scope.ultima;
            $scope.listadoServicios($scope.paginaActual);
        };

        //-----------------Fin listado servicios----------------


        $scope.listadoServicios();
        $scope.listadoCategoriasServicios();


//***********Asignados***********
        $scope.asignadosServicio = function (s) {

            $scope.idServicio = s.id;
            $scope.flagVentanaPrincipal = 2;
            $scope.tituloTabla = s.nombre;
            $scope.idSerImp = s.id;
            $scope.listadoAsignados();


        };

        $scope.asignadosServicioAgrupado = function (s) {

            $scope.idServicio = s.id;
            $scope.flagVentanaPrincipal = 4;
            $scope.tituloTabla = s.nombre;
            $scope.idSerImp = s.id;
            $scope.listadoAsignadosAgrupado();


        };

        $scope.listadoAsignadosAgrupado = function (pag) {
            if (!pag) {
                pag = 1;
            }
            $scope.countSeleccionadosAsignados = 0;
            $scope.todosAsignados = false;

            $scope.paginaActualAsignados = pag;
            var numRegistros = 10000;//se cambio para que no salga el paginador
            var max = numRegistros;
            var offset = numRegistros * ($scope.paginaActualAsignados - 1);

            var nombreCliente = $scope.nombreAsignado;

            $http({
                method: 'POST',
                url: 'estado_cuenta_asignados_a_servicio_agrupado',
                params: {
                    offset: offset,
                    limit: max,
                    nombreCliente: nombreCliente,
                    idServicio: $scope.idServicio
                }
            }).then(
                    function (r) {
                       // debugger
                        $scope.listaAsignadosAgrupado = r.data.listaAsignados;
                        //  $scope.numeroRegistrosAsignadosAgrupado = r.data.total;
                        //$scope.paginadorAsignados(max);
                    }
            );

        };


        $scope.expandir = function () {
            $scope.flagVentanaPrincipal = 1;
        };

        $scope.imprimirAsignadosAServicio = function () {

            var nombreCliente = "";
            if ($scope.nombreAsignado != undefined && $scope.nombreAsignado != null) {
                nombreCliente = $scope.nombreAsignado;
            }
            var idServicio = $scope.idServicio;

            window.open('servicios_imprimir_asignados_a_servicio?limit=1000&offset=0&idServicio=' +
                    idServicio + '&nombreCliente=' + nombreCliente, '_blank');
            return;

        };




        $scope.paginaActualAsignados = 1;
        $scope.listadoAsignados = function (pag) {
            if (!pag) {
                pag = 1;
            }
            $scope.countSeleccionadosAsignados = 0;
            $scope.todosAsignados = false;

            $scope.paginaActualAsignados = pag;
            var numRegistros = 10000;//se cambio para que no salga el paginador
            var max = numRegistros;
            var offset = numRegistros * ($scope.paginaActualAsignados - 1);

            var nombreCliente = $scope.nombreAsignado;

            $http({
                method: 'POST',
                url: 'estado_cuenta_asignados_a_servicio',
                params: {
                    offset: offset,
                    limit: max,
                    nombreCliente: nombreCliente,
                    idServicio: $scope.idServicio
                }
            }).then(
                    function (r) {
                        debugger
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



        $scope.listaPagos = function (idServicioCliente) {

            $scope.listaPagosServicioCliente = [];
            debugger

            $http({
                method: 'POST',
                url: 'pagos_detalles_pagos_servicio_cliente',
                params: {
                    idServicioCliente: idServicioCliente
                }
            }).then(
                    function (r) {
                        debugger
                        $scope.listaPagosServicioCliente = r.data.listaPagos;
                    }
            );
        };

        $scope.colorRow = function (a) {
        debugger
            if (a.estatus_descripcion == 'Cancelado') {
                return 'success';
            }
            if (a.saldo == 0) {
                return 'success';
            }
            if (a.saldo > 0) {
                return 'warning';
            }
            if (a.saldo < 0) {
                return 'danger';
            }




            return '';



        };

        $scope.colorRowAgrupado = function (a) {

            if (a.saldo_suma == 0) {
                return 'success';
            }
            if (a.saldo_suma < 0) {
                return 'danger';
            }
            if (a.saldo_suma > 0) {
                return 'warning';
            }

            return '';



        };


        $scope.colorRowIngEgr = function (tipo) {
            if (tipo == 'INGRESO') {
                return 'success';
            } else {
                return 'danger';
            }

            return '';



        };


        //movimientos por servicio (ingresos y egresos)
        $scope.ingresosEgresos = function (s) {
            $scope.flagVentanaPrincipal = 3;
            var idServicio = s.id;
            $scope.idSerImp = s.id;
            $scope.tituloTabla = s.nombre;
            $scope.listaIngresosEgresos = [];

            $scope.totalPagadoIE = 0;
            $scope.totalDescuentoIE = 0;
            $scope.totalEgresoIE = 0;
            $scope.totalTotalIE = 0;
            $scope.totalEsperadoIE = (s.inscritos * s.precio);

            $http({
                method: 'POST',
                url: 'estado_cuenta_ingresos_egresos',
                params: {
                    idServicio: idServicio
                }
            }).then(
                    function (r) {
                    	debugger
                        $scope.listaIngresosEgresos = r.data.listaIngresosEgresos;
	                    if($scope.listaIngresosEgresos!=null &&  $scope.listaIngresosEgresos!="" &&  $scope.listaIngresosEgresos!=undefined){
	                        for (var i = 0; i < $scope.listaIngresosEgresos.length; i++) {
	                            $scope.totalPagadoIE += parseFloat($scope.listaIngresosEgresos[i]['pago']);
	                            $scope.totalDescuentoIE += parseFloat($scope.listaIngresosEgresos[i]['descuento']);
	                            $scope.totalEgresoIE += parseFloat($scope.listaIngresosEgresos[i]['egreso']);
	                        }
	                        $scope.totalTotalIE = ($scope.totalPagadoIE - $scope.totalEgresoIE);
                        }
                    }
            );

        };


        $scope.ingresosEgresosImprimir = function () {
            var idServicio = $scope.idSerImp;// id de servicio que se va a imprimir
            var nombreServicio = $scope.tituloTabla;
            window.open('http://clubdelibros245.com/puntoventa/web/cajab_dev.php/estado_cuenta_ingresos_egresos_imprimir?idServicio=' + idServicio + '&nombreServicio=' + nombreServicio, '_blank');
            return;
        };


        $scope.asignadosServicioImprimir = function () {
            var idServicio = $scope.idSerImp;// id de servicio que se va a imprimir
            var nombreServicio = $scope.tituloTabla;
            window.open('http://clubdelibros245.com/puntoventa/web/cajab_dev.php/estado_cuenta_asignados_a_servicio_imprimir?idServicio=' + idServicio + '&nombreServicio=' + nombreServicio, '_blank');
            return;
        };

        $scope.asignadosServicioAgrupadoImprimir = function () {
            var idServicio = $scope.idSerImp;// id de servicio que se va a imprimir
            var nombreServicio = $scope.tituloTabla;
            window.open('http://clubdelibros245.com/puntoventa/web/cajab_dev.php/estado_cuenta_asignados_a_servicio_agrupado_imprimir?idServicio=' + idServicio + '&nombreServicio=' + nombreServicio, '_blank');
            return;
        };





//----------------Funcion llevar a pagos
        $scope.llamarPagos = function (tipo, nombre) {
            var myWindow = window.open('');//, '_blank');
            if (tipo == 'Alumno') {
                myWindow.location = 'pagos_pagar_servicio';
            } else {
                myWindow.location = 'pagos_pagar_servicio_cliente';
            }
            document.cookie = "nombre=" + nombre;
        };

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

function cerrarModal(idModal) {
    $("#" + idModal).modal("hide");
}