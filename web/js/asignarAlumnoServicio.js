var app = angular.module('asignarAlumnoServicio', []);


app.controller('asignarAlumnoServicioController', ['$http', '$scope', function ($http, $scope) {

        var x = getCookie('nombre');

        if (x.length > 0) {
            $scope.nombreAlumno = x;
            delete_cookie('nombre');
        }


        $scope.paginaActualAlumnos = 1;
        $scope.detalle = false;
        $scope.hoy = new Date();
        $scope.globalFormaPago = "EFECTIVO";
        $scope.numPagos = 0;

        $scope.flagEC = false;//flag estado de cuenta
        $scope.totalPagado = 0;
        $scope.totalAdeuda = 0;
        $scope.totalIngresado = 0;
        var date = new Date();
        var primerDia = new Date(date.getFullYear(), 0, 1);
        var ultimoDia = new Date(date.getFullYear(), date.getMonth(), date.getDate());

        $scope.fechaIniEC = primerDia;
        $scope.fechaFinEC = ultimoDia;

        $scope.alumnoSel;


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

        $scope.contraer = function (alumno) {
            // $scope.listadoServicios(idAlumno);
            $scope.alumnoSel = alumno;
            $scope.detalle = true;
            // contraerElemento('serviciosVigentesDiv');
            // expandirElemento('edicionServiciosDiv');

        };
        $scope.expandir = function () {
            $scope.detalle = false;
            //contraerElemento('edicionServiciosDiv');
            //expandirElemento('serviciosVigentesDiv');
        };
        $scope.contraerEC = function (idAlumno, nombre) {
            $scope.nombreAlumno = nombre;
            $scope.idAlumnoEC = idAlumno;
            $scope.listaMovimientos(idAlumno);
            $scope.flagEC = true;
        };
        $scope.expandirEC = function () {
            $scope.flagEC = false;
        };



        $scope.totalPagaraCalculo = function () {
            $scope.totalPagara = 0;
            $scope.totalDescuento = 0;
            $scope.numPagos = 0;
            for (i = 0; i < $scope.listaServicios.length; i++) {
                if (parseFloat($scope.listaServicios[i].pagara) > 0 || parseFloat($scope.listaServicios[i].descuento) > 0) {//cuantos pagos hara
                    $scope.numPagos++;
                }
                $scope.totalPagara += parseFloat($scope.listaServicios[i].pagara);
                $scope.totalDescuento += parseFloat($scope.listaServicios[i].descuento);
            }
        };

        $scope.actualizarFormaPago = function () {
            for (i = 0; i < $scope.listaServicios.length; i++) {
                $scope.listaServicios[i].formaPago = $scope.globalFormaPago;
            }
        };




        $scope.historialServicios = function () {

            $scope.listadoHistorial = [];

            $http({
                method: 'POST',
                url: 'pagos_historial_pagos',
                params: {
                    idAlumno: $scope.alumnoSel.id
                }
            }).then(
                    function (r) {
                        $scope.listadoHistorial = r.data.historialServicios;
                    }
            );

        };



        //-----------------Listado de servicios--------------

        $scope.listadoServicios = function (alumno) {
            
            if (!alumno) {
                alumno = $scope.alumnoSel;
            }
            debugger
            $http({
                method: 'POST',
                url: 'servicios_aplican_alumno',
                params: {
                    idAlumno: alumno.id,
                    idCiclo: alumno.idCiclo,
                    idGrado: alumno.idGrado,
                    idGrupo: alumno.idGrupo,
                    nombreServicio: $scope.mNombreServicio

                }
            }).then(
                    function (r) {
                        $scope.listaServicios = r.data.listaServicios;

                        if ($scope.listaServicios.length == 0) {
                            alert("no se encontraron registros de servicios para este alumno");
                        }
                    }
            );

        };

        $scope.asignarServiciosSeleccionados = function () {

            var seleccionados = "";
            for (var i = 0; i < $scope.listaServicios.length; i++) {
                if ($scope.listaServicios[i].seleccionado) {
                    seleccionados += $scope.listaServicios[i].id.toString() + ",";
                }
            }
            if (seleccionados == "") {
                alert("No se selecciono ningun servicio");
                return;
            }

            console.log($scope.alumnoSel + "," + seleccionados);

            $http({
                method: 'POST',
                url: 'servicios_asignar_servicio_seleccionados',
                params: {
                    idAlumno: $scope.alumnoSel.id,
                    seleccionados: seleccionados
                }
            }).then(
                    function (r) {
                        $scope.listaServicios = [];

                        if (r.data.mensaje == 'Ok') {
                            alert("Los servicios se asignaron correctamente ");
                        } else {
                            alert("Ocurrio un problema con los servicios asignados");
                        }
                        $scope.listadoServicios();

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

        $scope.colorRow = function (cantidad) {
            if (cantidad <= 0) {
                return 'danger';
            }
            if (cantidad > 0) {
                return 'success';
            }
            return '';
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

function delete_cookie(name) {
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

