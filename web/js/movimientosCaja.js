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






        //-----------------Listado de servicios--------------

        $scope.listadoMovimientosCaja = function () {

            var fechaIni = moment($scope.fechaIni).format('YYYY-MM-DD');
            var fechaFin = moment($scope.fechaFin).format('YYYY-MM-DD');
            var numRecibo = 0;
            if ($scope.numRecibo != "" && $scope.numRecibo != undefined && $scope.numRecibo != null) {
                numRecibo = $scope.numRecibo;
            }

            if ($scope.fechaIni > $scope.fechaFin) {
                alert("La fecha Desde no puede ser mayor a Fecha Fin");
                return;
            }

            $http({
                method: 'POST',
                url: 'pagos_listado_movimientos_caja',
                params: {
                    fechaIni: fechaIni,
                    fechaFin: fechaFin,
                    formaPago: $scope.formaPago,
                    numRecibo: numRecibo
                }
            }).then(
                    function (r) {
                        $scope.listaMovimientos = r.data.listadoMovimientos;
                        $scope.totalMonto = 0;
                        $scope.totalDescuento = 0;
                        for (var i = 0; i < $scope.listaMovimientos.length; i++) {
                            $scope.totalMonto += parseFloat($scope.listaMovimientos[i].monto);
                            $scope.totalDescuento += parseFloat($scope.listaMovimientos[i].descuento);
                        }
                    }
            );

        };


        $scope.listaMovimientosImprimir = function () {
            var fechaIni = moment($scope.fechaIni).format('YYYY-MM-DD');
            var fechaFin = moment($scope.fechaFin).format('YYYY-MM-DD');
            var numRecibo = 0;
            if ($scope.numRecibo != "" && $scope.numRecibo != undefined && $scope.numRecibo != null) {
                numRecibo = $scope.numRecibo;
            }

            if ($scope.fechaIni > $scope.fechaFin) {
                alert("La fecha Desde no puede ser mayor a Fecha Fin");
                return;
            }

            window.open('http://clubdelibros245.com/puntoventa/web/cajab_dev.php/pagos_listado_movimientos_caja_imprimir?fechaIni='+
                    fechaIni+'&fechaFin='+fechaFin+'&formaPago='+$scope.formaPago+
                    '&numRecibo='+numRecibo, '_blank');
            return;
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