var app = angular.module('pagarServicioCliente', []);

app.controller('pagarServicioClienteController', ['$http', '$scope', function ($http, $scope) {

        $scope.paginaActualClientes = 1;
        $scope.detalle = false;
        $scope.hoy = new Date();
        $scope.globalFormaPago = "EFECTIVO";
        $scope.numPagos = 0;

        $scope.flagEC = false;//flag estado de cuenta
        $scope.totalPagado = 0;
        $scope.totalAdeuda = 0;
        var date = new Date();
        var primerDia = new Date(date.getFullYear(), 0, 1);
        var ultimoDia = new Date(date.getFullYear(), date.getMonth(), date.getDate());

        $scope.fechaIniEC = primerDia;
        $scope.fechaFinEC = ultimoDia;


        $scope.sumTotal = function (listaFiltro) {
            $scope.totalPagado = 0;
            $scope.totalAdeuda = 0;
            if (listaFiltro != undefined) {
                for (var i = 0; i < listaFiltro.length; i++) {
                    $scope.totalPagado += parseFloat(listaFiltro[i].pago);
                    $scope.totalAdeuda += parseFloat(listaFiltro[i].adeuda);
                }
            }
        };


        $scope.contraerEC = function (idCliente, nombre) {
            $scope.nombreClienteEC = nombre;
            $scope.idClienteEC = idCliente;
            $scope.listaMovimientos(idCliente);
            $scope.flagEC = true;
        };
        $scope.expandirEC = function () {
            $scope.flagEC = false;
        };





        $scope.contraer = function (idAlumno) {
            $scope.listadoServicios(idAlumno);
            $scope.detalle = true;
            // contraerElemento('serviciosVigentesDiv');
            // expandirElemento('edicionServiciosDiv');

        };
        $scope.expandir = function () {
            $scope.detalle = false;
            //contraerElemento('edicionServiciosDiv');
            //expandirElemento('serviciosVigentesDiv');
        };


        $scope.totalPagaraCalculo = function () {
            $scope.totalPagara = 0;
            $scope.numPagos = 0;
            for (i = 0; i < $scope.listaServicios.length; i++) {
                if (parseFloat($scope.listaServicios[i].pagara) > 0) {//cuantos pagos hara
                    $scope.numPagos++;
                }
                $scope.totalPagara += parseFloat($scope.listaServicios[i].pagara);
            }
        };

        $scope.actualizarFormaPago = function () {
            for (i = 0; i < $scope.listaServicios.length; i++) {
                $scope.listaServicios[i].formaPago = $scope.globalFormaPago;
            }
        };

        $scope.guardarPago = function () {

            var idServicios = "";
            var idCliente = "";
            var montosPagara = "";
            var formaPagos = "";

            for (i = 0; i < $scope.listaServicios.length; i++) {
                if (parseFloat($scope.listaServicios[i].pagara) > 0) {

                    if ((parseFloat($scope.listaServicios[i].abonado) + parseFloat($scope.listaServicios[i].pagara)) > parseFloat($scope.listaServicios[i].precio)) {
                        alert("No puedes pagar mas del precio que especifica el servicio: " +
                                $scope.listaServicios[i].servicio);
                        return;
                    }
                    if ($scope.listaServicios[i].aplica_parcialidad == '0') {//no hay parcialidades
                        if (parseFloat($scope.listaServicios[i].pagara) < parseFloat($scope.listaServicios[i].precio)) {//tiene que pagar completo
                            alert("Tienes que pagar el monto completo ya que no aplica parcialidad el servicio: " +
                                    $scope.listaServicios[i].servicio);
                            return;
                        }
                    }

                    idServicios += $scope.listaServicios[i].id + ",";
                    idCliente = $scope.listaServicios[i].id_cliente;
                    montosPagara += $scope.listaServicios[i].pagara + ",";
                    formaPagos += $scope.listaServicios[i].formaPago + ",";


                }

            }

            if (idServicios.length == 0) {
                alert("no se selecciono ningun servicio para pagar");
                return;

            }


            inicioActualizarBoton('botonGuardarPago');
            var myWindow = window.open('', '_blank');

            $http({
                method: 'POST',
                url: 'pagos_pagos_servicios_cliente',
                params: {
                    idCliente: idCliente,
                    idServicios: idServicios,
                    montosPagara: montosPagara,
                    formaPagos: formaPagos
                }
            }).then(
                    function (r) {
                        alert(r.data.mensaje);
                        $scope.listadoServicios(parseInt(idCliente));
                        $scope.totalPagara = 0;
                        $scope.numPagos = 0;
                        finActualizarBoton('botonGuardarPago');
                        myWindow.location = 'pagos_imprimir_ticket?idPago=' + r.data.idPago;
                        //window.open('pagos_imprimir_ticket?idPago=' +
                        //      r.data.idPago, '_blank');
                        return;
                    }
            );




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







        //-----------------Listado de servicios--------------

        $scope.listadoServicios = function (idCliente) {
            $scope.totalPrecio = 0;
            $scope.totalAbonado = 0;
            $scope.totalAdeuda = 0;
            $scope.totalPagara = 0;

            $http({
                method: 'POST',
                url: 'pagos_servicios_pagando_cliente',
                params: {
                    idCliente: idCliente
                }
            }).then(
                    function (r) {
                        $scope.listaServicios = r.data.listaServicios;

                        for (i = 0; i < $scope.listaServicios.length; i++) {
                            $scope.totalPrecio += parseFloat($scope.listaServicios[i].precio);
                            $scope.totalAbonado += parseFloat($scope.listaServicios[i].abonado);
                            $scope.totalAdeuda += (parseFloat($scope.listaServicios[i].precio) - parseFloat($scope.listaServicios[i].abonado));
                            $scope.listaServicios[i].pagara = 0;
                            $scope.listaServicios[i].formaPago = "EFECTIVO";

                        }


                    }
            );

        };











        $scope.listadoClientes = function (pag) {
            if (!pag) {
                pag = 1;
            }


            $scope.paginaActualClientes = pag;
            var numRegistros = 10;//se cambio para que no salga el paginador
            var max = numRegistros;
            var offset = numRegistros * ($scope.paginaActualClientes - 1);

            var nombreCliente = $scope.nombreCliente;




            $http({
                method: 'POST',
                url: 'servicios_listado_clientes_externos',
                params: {
                    offset: offset,
                    limit: max,
                    nombreCliente: nombreCliente,
                    idServicio: 0,
                    idCategoria: 0,
                    tipoTransporte: 0

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




        $scope.listadoClientes();


        //-----------------Fin listado Alumnos---------------


        $scope.listaMovimientos = function (idCliente) {

            if (!idCliente) {
                idCliente = $scope.idClienteEC;
            }

            $scope.listadoMovimientos = [];
            var fechaIni = moment($scope.fechaIniEC).format('YYYY-MM-DD');
            var fechaFin = moment($scope.fechaFinEC).format('YYYY-MM-DD');

            $http({
                method: 'POST',
                url: 'pagos_estado_cuenta_cliente',
                params: {
                    idCliente: idCliente,
                    fechaIni: fechaIni,
                    fechaFin: fechaFin
                }
            }).then(
                    function (r) {
                        $scope.listadoMovimientos = r.data.listadoMovimientos;
                    }
            );

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

function inicioActualizarBoton(idBoton) {

    //  $("#" + idBoton).removeClass(clase);
    // $("#" + idBoton).addClass("fa-refresh fa-spin fa-3x fa-fw");
    $("#" + idBoton).prop("disabled", true);

}

function finActualizarBoton(idBoton) {
    //$('#botonActualizar').removeClass('disabled');
    //  $("#" + idBoton).removeClass("fa-refresh fa-spin fa-3x fa-fw");
    //  $("#" + idBoton).addClass(clase);
    $("#" + idBoton).prop("disabled", false);


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

