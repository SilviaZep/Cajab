var app = angular.module('servActivosAlumno', []);

app.controller('servActivosAlumnoController', ['$http', '$scope', function ($http, $scope) {

        $scope.paginaActual = 1;

        $scope.soloTransporte = false;
        $scope.mayoresDeDos =false;


        $scope.filtrarAlumnos = function (b,f) {
            if(b=="t"){
                $scope.soloTransporte=f;
            }else{
                $scope.mayoresDeDos=f;
            }             
            $scope.listadoServiciosVigentesAlumnos();
        };

        //-----------------Listado de servicios--------------

        $scope.listadoServiciosVigentesAlumnos = function (pag) {
            if (!pag) {
                pag = 1;
            }

            $scope.paginaActual = pag;
            var numRegistros = 10000;//se cambio para que no salga el paginador
            var max = numRegistros;
            var offset = numRegistros * ($scope.paginaActual - 1);


            $http({
                method: 'POST',
                url: 'estado_cuenta_servicios_activos_alumnos_lista',
                params: {
                    offset: offset,
                    limit: max,
                    transporte: $scope.soloTransporte,
                    mayores: $scope.mayoresDeDos
                }
            }).then(
                    function (r) {
                        $scope.listaServiciosVigentes = r.data.listaAlumnos;
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
            $scope.listadoServiciosVigentesAlumnos($scope.paginaActual);
        };
        $scope.siguiente = function () {
            $scope.paginaActual = $scope.paginaActual + 1;
            if ($scope.paginaActual > $scope.ultima) {
                $scope.paginaActual = $scope.primera;
            }
            $scope.listadoServiciosVigentesAlumnos($scope.paginaActual);


        };

        $scope.ini = function () {
            $scope.paginaActual = $scope.primera;
            $scope.listadoServiciosVigentesAlumnos($scope.paginaActual);
        };
        $scope.end = function () {
            $scope.paginaActual = $scope.ultima;
            $scope.listadoServiciosVigentesAlumnos($scope.paginaActual);
        };

        //-----------------Fin listado servicios----------------


        $scope.listadoServiciosVigentesAlumnos();





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