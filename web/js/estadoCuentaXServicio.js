var app = angular.module('estadoCuentaXServicio', []);

app.controller('estadoCuentaXServicioController', ['$http', '$scope', function ($http, $scope) {


        var date = new Date();
        // var primerDia = new Date(date.getFullYear(), date.getMonth(), 1);
        //var ultimoDia = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        var primerDia = new Date();
        var ultimoDia = new Date();
 $scope.listaCategoriaServicios=[];

        $scope.fechaIni = primerDia;
        $scope.fechaFin = ultimoDia;
        $scope.formaPago = "NA";

        $scope.nombreServicio = "";
                $scope.categoria = "0";
        
        $scope.totalesColumnas={precio:0,inscritos:0,esperado:0,descuento:0,pagadoSD:0,egresos:0,total:0,saldo:0};






        //-----------------Listado de servicios--------------

        $scope.listadoEstadoCuentaServicio = function () {

            var fechaIni = moment($scope.fechaIni).format('YYYY-MM-DD');
            var fechaFin = moment($scope.fechaFin).format('YYYY-MM-DD');

            var nombreServicio = '';

            /*     if ($scope.numRecibo != "" && $scope.numRecibo != undefined && $scope.numRecibo != null) {
             numRecibo = $scope.numRecibo;
             }*/
            if ($scope.nombreServicio != "" && $scope.nombreServicio != undefined && $scope.nombreServicio != null) {
                nombreServicio = $scope.nombreServicio;
            }


            if ($scope.fechaIni > $scope.fechaFin) {
                alert("La fecha Desde no puede ser mayor a Fecha Fin");
                return;
            }
            
            $scope.listaServiciosInfo=[];
            $scope.totalesColumnas={precio:0,inscritos:0,esperado:0,descuento:0,pagadoSD:0,egresos:0,total:0,saldo:0};
            inicioActualizar();
            $http({
                method: 'POST',
                url: 'pagos_listado_informacion_servicio',
                params: {
                    fechaIni: fechaIni,
                    fechaFin: fechaFin,
                    formaPago: $scope.formaPago,
                    nombreServicio: nombreServicio,
                       categoria: $scope.categoria
                }
            }).then(
                    function (r) {
                        
                        $scope.listaServiciosInfo = r.data.listaServiciosInfo;
                        
                        for(var i=0;i<$scope.listaServiciosInfo.length;i++){
                            $scope.totalesColumnas.precio+=parseFloat($scope.listaServiciosInfo[i].precio);
                            $scope.totalesColumnas.inscritos+=parseInt($scope.listaServiciosInfo[i].inscritos);
                            $scope.totalesColumnas.esperado+=parseFloat($scope.listaServiciosInfo[i].esperado);
                            $scope.totalesColumnas.descuento+=parseFloat($scope.listaServiciosInfo[i].descuento);
                            $scope.totalesColumnas.pagadoSD+=parseFloat($scope.listaServiciosInfo[i].pagado_sin_descuento);
                            $scope.totalesColumnas.egresos+=parseFloat($scope.listaServiciosInfo[i].egresos);
                            $scope.totalesColumnas.total+=parseFloat($scope.listaServiciosInfo[i].total);
                            $scope.totalesColumnas.saldo+=parseFloat($scope.listaServiciosInfo[i].saldo);
                        }
                        
                        finActualizar();
                    }
            );

        };

        /*
         
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
         '&numRecibo=' + numRecibo+'&nombreServicio=' + nombreServicio+
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
         
         };*/
        
          $scope.listaServiciosImprimir = function () {
            var fechaIni = moment($scope.fechaIni).format('YYYY-MM-DD');
            var fechaFin = moment($scope.fechaFin).format('YYYY-MM-DD');
            
            var nombreServicio = '';
            
            if ($scope.nombreServicio != "" && $scope.nombreServicio != undefined && $scope.nombreServicio != null) {
                nombreServicio = $scope.nombreServicio;
            }

            if ($scope.fechaIni > $scope.fechaFin) {
                alert("La fecha Desde no puede ser mayor a Fecha Fin");
                return;
            }

            window.open('http://clubdelibros245.com/puntoventa/web/cajab_dev.php/pagos_listado_informacion_servicio_imprimir?fechaIni=' +
                    fechaIni + '&fechaFin=' + fechaFin + '&formaPago=' + $scope.formaPago +
                    '&nombreServicio=' + nombreServicio+ '&categoria=' + $scope.categoria , '_blank');
            return;
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