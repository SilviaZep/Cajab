var app = angular.module('movimientoCaja', []);

app.controller('movimientoCajaController', ['$http', '$scope', function ($http, $scope) {

        $scope.paginaActual = 1;

        var date = new Date();
        // var primerDia = new Date(date.getFullYear(), date.getMonth(), 1);
        //var ultimoDia = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        var primerDia = new Date();
        var ultimoDia = new Date();


        $scope.fechaIni = primerDia;
        $scope.fechaFin = ultimoDia;
        $scope.formaPago = "NA";

        $scope.totalMonto = 0;
        $scope.totalDescuento = 0;
        $scope.nombreServicio = "";






        //-----------------Listado de servicios--------------

        $scope.listadoMovimientosCaja = function () {

            var fechaIni = moment($scope.fechaIni).format('YYYY-MM-DD');
            var fechaFin = moment($scope.fechaFin).format('YYYY-MM-DD');
            var numRecibo = 0;
            var nombreServicio = '';
            var nombreSeccion = '';
            if ($scope.numRecibo != "" && $scope.numRecibo != undefined && $scope.numRecibo != null) {
                numRecibo = $scope.numRecibo;
            }
            if ($scope.nombreServicio != "" && $scope.nombreServicio != undefined && $scope.nombreServicio != null) {
                nombreServicio = $scope.nombreServicio;
            }
            if ($scope.nombreSeccion != "" && $scope.nombreSeccion != undefined && $scope.nombreSeccion != null) {
                nombreSeccion = $scope.nombreSeccion;
            }


            if ($scope.fechaIni > $scope.fechaFin) {
                alert("La fecha Desde no puede ser mayor a Fecha Fin");
                return;
            }
            inicioActualizar();
            $http({
                method: 'POST',
                url: 'pagos_listado_movimientos_caja',
                params: {
                    fechaIni: fechaIni,
                    fechaFin: fechaFin,
                    formaPago: $scope.formaPago,
                    numRecibo: numRecibo,
                    nombreServicio: nombreServicio,
                    nombreSeccion: nombreSeccion
                }
            }).then(
                    function (r) {
                        finActualizar();
                        $scope.listaMovimientos = r.data.listadoMovimientos;
                        $scope.totalMonto = 0;
                        $scope.totalDescuento = 0;
                        $scope.totalEgreso = 0;
                        $scope.totalPagado = 0;
                        for (var i = 0; i < $scope.listaMovimientos.length; i++) {
                        	if($scope.listaMovimientos[i].estatus_pago=="Pagado"){
                        		if($scope.listaMovimientos[i].tipo=="ingreso"){
	                              $scope.totalPagado += parseFloat($scope.listaMovimientos[i].monto);
                        		}else if($scope.listaMovimientos[i].tipo=='egreso'){
                        		   $scope.totalEgreso += parseFloat($scope.listaMovimientos[i].monto);	 
                        		}
	                            $scope.totalDescuento += parseFloat($scope.listaMovimientos[i].descuento);
                        	}
                        	
                        }
                        
                        $scope.totalMonto=$scope.totalPagado-$scope.totalEgreso-$scope.totalDescuento;
                    }
            );

        };


        $scope.listaMovimientosImprimir = function () {
            var fechaIni = moment($scope.fechaIni).format('YYYY-MM-DD');
            var fechaFin = moment($scope.fechaFin).format('YYYY-MM-DD');
            var numRecibo = 0;
            var nombreServicio = '';
            var nombreSeccion = '';
            if ($scope.numRecibo != "" && $scope.numRecibo != undefined && $scope.numRecibo != null) {
                numRecibo = $scope.numRecibo;
            }
            if ($scope.nombreServicio != "" && $scope.nombreServicio != undefined && $scope.nombreServicio != null) {
                nombreServicio = $scope.nombreServicio;
            }
            if ($scope.nombreSeccion != "" && $scope.nombreSeccion != undefined && $scope.nombreSeccion != null) {
                nombreSeccion = $scope.nombreSeccion;
            }


            if ($scope.fechaIni > $scope.fechaFin) {
                alert("La fecha Desde no puede ser mayor a Fecha Fin");
                return;
            }

            window.open('http://clubdelibros245.com/puntoventa/web/cajab_dev.php/pagos_listado_movimientos_caja_imprimir?fechaIni=' +
                    fechaIni + '&fechaFin=' + fechaFin + '&formaPago=' + $scope.formaPago +
                    '&numRecibo=' + numRecibo + '&nombreServicio=' + nombreServicio +
                    '&nombreSeccion=' + nombreSeccion, '_blank');
            return;
        };

        $scope.reImprimirTicket = function (idRecibo) {
            window.open('http://clubdelibros245.com/puntoventa/web/cajab_dev.php/pagos_imprimir_ticket?idPago=' +
                    idRecibo, '_blank');
            return;
        };

        $scope.eliminarPagos = function (idRecibo) {

            var r = confirm("Desea eliminar los pagos relacionados con este recibo?");
            if (r != true) {
                return;
            }

            $http({
                method: 'POST',
                url: 'pagos_eliminar_pagos',
                params: {
                    numRecibo: idRecibo
                }
            }).then(
                    function (r) {
                        alert('eliminado correctamente');
                        $scope.listadoMovimientosCaja();
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

function cerrarModal(idModal) {
    $("#" + idModal).modal("hide");
}

function inicioActualizarBoton(idBoton) {
    $("#" + idBoton).prop("disabled", true);
}

function finActualizarBoton(idBoton) {
    $("#" + idBoton).prop("disabled", false);
}