var app = angular.module('horarios', []);
app.controller('horariosController', ['$http', '$scope', function ($http, $scope) {


        $scope.cambiarRuta = function (h) {
            $scope.idHorario = h.id;
            $scope.alumno = h.nombre;
            $scope.tipoTransporte = h.tipo_transporte;
            $scope.ruta_lun_e = h.r_lun_e;
            $scope.ruta_lun_s = h.r_lun_s;
            $scope.ruta_mar_e = h.r_mar_e;
            $scope.ruta_mar_s = h.r_mar_s;
            $scope.ruta_mie_e = h.r_mie_e;
            $scope.ruta_mie_s = h.r_mie_s;
            $scope.ruta_jue_e = h.r_jue_e;
            $scope.ruta_jue_s = h.r_jue_s;
            $scope.ruta_vie_e = h.r_vie_e;
            $scope.ruta_vie_s = h.r_vie_s;
        };
        $scope.contarAsignadas = function () {
            var count = 0;
            if ($scope.ruta_lun_e == 0) {
                count++;
            }
            if ($scope.ruta_lun_s == 0) {
                count++;
            }
            if ($scope.ruta_mar_e == 0) {
                count++;
            }
            if ($scope.ruta_mar_s == 0) {
                count++;
            }
            if ($scope.ruta_mie_e == 0) {
                count++;
            }
            if ($scope.ruta_mie_s == 0) {
                count++;
            }
            if ($scope.ruta_jue_e == 0) {
                count++;
            }
            if ($scope.ruta_jue_s == 0) {
                count++;
            }
            if ($scope.ruta_vie_e == 0) {
                count++;
            }
            if ($scope.ruta_vie_s == 0) {
                count++;
            }
            return count;
        };


        $scope.guardarCambios = function () {

            if ($scope.tipoTransporte == "Medio") {
                if ($scope.contarAsignadas() < 5) {
                    alert("El Tipo de transporte es medio; debe asignar solo 5 o menos rutas.");
                    return;
                }


            }

            $http({
                method: 'POST',
                url: 'transporte_cambiar_horario_alumno',
                params: {
                    idHorario: $scope.idHorario,
                    rutaLunE: $scope.ruta_lun_e,
                    rutaLunS: $scope.ruta_lun_s,
                    rutaMarE: $scope.ruta_mar_e,
                    rutaMarS: $scope.ruta_mar_s,
                    rutaMieE: $scope.ruta_mie_e,
                    rutaMieS: $scope.ruta_mie_s,
                    rutaJueE: $scope.ruta_jue_e,
                    rutaJueS: $scope.ruta_jue_s,
                    rutaVieE: $scope.ruta_vie_e,
                    rutaVieS: $scope.ruta_vie_s
                }
            }).then(
                    function (r) {

                        $scope.listadoHorarios($scope.paginaActual);
                        cerrarModal('myModal');
                        alert(r.data.mensaje);
                    }
            );
        };
        //-----------Listado horarios
        $scope.nombreAlumno = "";
        $scope.listadoHorarios = function (pag) {
            if (!pag) {
                pag = 1;
            }

            $scope.paginaActual = pag;
            var numRegistros = 10; //se cambio para que no salga el paginador
            var max = numRegistros;
            var offset = numRegistros * ($scope.paginaActual - 1);
            var nombreAlumno = $scope.nombreAlumno;
            debugger

            $http({
                method: 'POST',
                url: 'transporte_horarios_alumnos',
                params: {
                    offset: offset,
                    limit: max,
                    nombre: nombreAlumno
                }
            }).then(
                    function (r) {
                        $scope.listaHorarios = r.data.listaHorarios;
                        $scope.numeroRegistros = r.data.total;
                        $scope.paginador(max);
                    }
            );
        };
        $scope.paginador = function (max) {
            $scope.numPaginas = Math.ceil($scope.numeroRegistros / max);
            $scope.tamanioPaginador = 10; //estatico
            $scope.primera = 1; //numero de pagina de inicio
            $scope.ultima = $scope.numPaginas; //numero de pagina de fin 

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
            $scope.listadoHorarios($scope.paginaActual);
        };
        $scope.siguiente = function () {
            $scope.paginaActual = $scope.paginaActual + 1;
            if ($scope.paginaActual > $scope.ultima) {
                $scope.paginaActual = $scope.primera;
            }
            $scope.listadoHorarios($scope.paginaActual);
        };
        $scope.ini = function () {
            $scope.paginaActual = $scope.primera;
            $scope.listadoHorarios($scope.paginaActual);
        };
        $scope.end = function () {
            $scope.paginaActual = $scope.ultima;
            $scope.listadoHorarios($scope.paginaActual);
        };
        $scope.listadoHorarios();
//-------------Listado Rutas--------

        $scope.listadoRutas = function () {
            var max = 50; //no creo que haya 50 rutas
            var offset = 0;
            $http({
                method: 'POST',
                url: 'transporte_listado_rutas_activas',
                params: {
                    offset: offset,
                    limit: max,
                    nombreRuta: ""
                }
            }).then(
                    function (r) {
                        $scope.listaRutas = r.data.listaRutas;
                    }
            );
        };
        $scope.listadoRutas();
    }]);

function cerrarModal(idModal) {
    $("#" + idModal).modal("hide");
}
