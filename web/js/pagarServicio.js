var app = angular.module('pagarServicio', []);

app.controller('pagarServicioController', ['$http', '$scope', function ($http, $scope) {

        $scope.paginaActualAlumnos = 1;
        $scope.detalle = false;
        $scope.hoy = new Date();
        $scope.globalFormaPago = "EFECTIVO";
        $scope.numPagos = 0;





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
            var idAlumno = "";
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
                    idAlumno = $scope.listaServicios[i].id_alumno;
                    montosPagara += $scope.listaServicios[i].pagara + ",";
                    formaPagos += $scope.listaServicios[i].formaPago + ",";




                }

            }

            if (idServicios.length == 0) {
                alert("no se selecciono ningun servicio para pagar");
                return;

            }


            inicioActualizarBoton('botonGuardarPago');

            $http({
                method: 'POST',
                url: 'pagos_pagos_servicios_alumno',
                params: {
                    idAlumno: idAlumno,
                    idServicios: idServicios,
                    montosPagara: montosPagara,
                    formaPagos: formaPagos
                }
            }).then(
                    function (r) {
                      
                        alert(r.data.mensaje);                      

                        $scope.listadoServicios(parseInt(idAlumno));
                        $scope.totalPagara = 0;
                        $scope.numPagos = 0;
                        finActualizarBoton('botonGuardarPago');


                        window.open('pagos_imprimir_ticket?idPago=' +
                                r.data.idPago , '_blank');
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

        $scope.listadoServicios = function (idAlumno) {
            $scope.totalPrecio = 0;
            $scope.totalAbonado = 0;
            $scope.totalAdeuda = 0;
            $scope.totalPagara = 0;

            $http({
                method: 'POST',
                url: 'pagos_servicios_pagando_alumno',
                params: {
                    idAlumno: idAlumno
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











        $scope.listadoAlumnos = function (pag) {
            if (!pag) {
                pag = 1;
            }

            $scope.paginaActualAlumnos = pag;
            var numRegistros = 10;//se cambio para que no salga el paginador
            var max = numRegistros;
            var offset = numRegistros * ($scope.paginaActualAlumnos - 1);

            var nombreAlumno = $scope.nombreAlumno;


            var idCiclo = '';
            var idGrado = '';
            var idGrupo = '';

            $http({
                method: 'POST',
                url: 'filtros-alumnos', //'servicios_listado_alumnos',
                params: {
                    offset: offset,
                    limit: max,
                    alumno: nombreAlumno, //nombreAlumno: nombreAlumno,
                    idCiclo: idCiclo,
                    idGrado: idGrado,
                    idGrupo: idGrupo,
                    //idServicio: 0,
                    //idCategoria: 0,
                    //tipoTransporte: 0

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




        $scope.listadoAlumnos();


        //-----------------Fin listado Alumnos---------------






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

