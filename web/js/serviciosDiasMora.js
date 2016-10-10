var app = angular.module('servicioDiasMora', []);

app.controller('servicioDiasMoraController', ['$http', '$scope', function ($http, $scope) {

        $scope.paginaActual = 1;

        var date = new Date();
        // var primerDia = new Date(date.getFullYear(), date.getMonth(), 1);
        //var ultimoDia = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        var primerDia = new Date(date.getFullYear(), 0, 1);
        var ultimoDia = new Date(date.getFullYear(), date.getMonth(), date.getDate());


        $scope.fechaIni = primerDia;
        $scope.fechaFin = ultimoDia;
        $scope.categoria = "0";
        $scope.fechaHoy = date;

        $scope.flagVentanaPrincipal = true;//flag para mostrar o esconder ventana

        debugger



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


        $scope.listadoDiasMoraImprimir = function () {
            window.open('http://clubdelibros245.com/puntoventa/web/cajab_dev.php/estado_cuenta_listado_dias_mora_imprimir', '_blank');
            return;
        };


        //-----------------Listado de servicios--------------

        $scope.listadoDiasMora = function (pag) {
            if (!pag) {
                pag = 1;
            }

            $scope.paginaActual = pag;
            var numRegistros = 10;//se cambio para que no salga el paginador
            var max = numRegistros;
            var offset = numRegistros * ($scope.paginaActual - 1);


            $http({
                method: 'POST',
                url: 'estado_cuenta_listado_dias_mora',
                params: {
                    offset: offset,
                    limit: max
                }
            }).then(
                    function (r) {
                        $scope.listaDiasMora = r.data.listaDiasMora;
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
            $scope.listadoDiasMora($scope.paginaActual);
        };
        $scope.siguiente = function () {
            $scope.paginaActual = $scope.paginaActual + 1;
            if ($scope.paginaActual > $scope.ultima) {
                $scope.paginaActual = $scope.primera;
            }
            $scope.listadoDiasMora($scope.paginaActual);


        };

        $scope.ini = function () {
            $scope.paginaActual = $scope.primera;
            $scope.listadoDiasMora($scope.paginaActual);
        };
        $scope.end = function () {
            $scope.paginaActual = $scope.ultima;
            $scope.listadoDiasMora($scope.paginaActual);
        };

        //-----------------Fin listado servicios----------------


        $scope.listadoDiasMora();
        $scope.listadoCategoriasServicios();




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

        $scope.colorRow = function (diasMora) {
            if (diasMora == 0) {
                return 'warning';
            }
            if (diasMora > 0) {
                return 'danger';
            }
            if (diasMora < 0) {
                return 'success';
            }

            return '';



        };

//----------------------------------
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