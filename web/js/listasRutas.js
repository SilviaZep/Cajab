var app = angular.module('listasRutas', []);

app.controller('listasRutasController', ['$http', '$scope', function ($http, $scope) {

        $scope.paginaActualAlumnos = 1;
        $scope.fechaIni = new Date();
        $scope.fechaHoy = new Date();


        $scope.flagGuardar = false;


        $scope.idRuta = 0;
        $scope.ruta;
        $scope.rutaNombre = "";


        $scope.cambiarRuta = function (a) {
            $scope.alumnoNombre = a.nombre;
            debugger

        };
        $scope.cambiarEstatusAsignado = function (a) {
            debugger
            $scope.idAlumnoListaCambio = a.id_lista;
            $scope.estatusCambioA = a.observacion;
        };

        $scope.compararFechas = function () {

            var fechaHoy = moment($scope.fechaHoy).format('YYYY-MM-DD');
            var fechaIni = moment($scope.fechaIni).format('YYYY-MM-DD');
            $http({
                method: 'POST',
                url: 'transporte_verificar_guardado',
                params: {
                    fecha: fechaIni
                }
            }).then(
                    function (r) {
                        var flag = r.data.guardado;//true.- guardado/false.- no guardado
                        if (fechaHoy == fechaIni && flag == false) {
                            $scope.flagGuardar = true;
                        } else {
                            $scope.flagGuardar = false;
                        }
                    }
            );

        };


        $scope.imprimirListasRutasAlumnos = function (r) {
            if (r) {
                $scope.idRuta = r;
            }
            var fechaIni = moment($scope.fechaIni).format('YYYY-MM-DD');
            window.open('http://clubdelibros245.com/puntoventa/web/cajab_dev.php/transporte_imprimir_rutas_alumnos?fecha=' + fechaIni + '&idRuta=' + $scope.idRuta, '_blank');
            return;
        };



        $scope.listadoRutas = function () {
            $scope.idRuta = 0;
            $scope.rutaNombre = '';
            $scope.ruta = null;
            $scope.compararFechas();


            var max = 50; //no creo que haya 50 rutas
            var offset = 0;
            var fecha = moment($scope.fechaIni).format('YYYY-MM-DD');
            $http({
                method: 'POST',
                url: 'transporte_listado_rutas',
                params: {
                    offset: offset,
                    limit: max,
                    nombreRuta: "",
                    fecha: fecha
                }
            }).then(
                    function (r) {
                        $scope.listaRutas = r.data.listaRutas;
                    }
            );
        };

        $scope.listadoRutas();



        $scope.eliminarEventual = function (a) {

            $http({
                method: 'POST',
                url: 'transporte_eliminar_alumno_eventual',
                params: {
                    idAlumnoEventual: a.id_lista,
                }
            }).then(
                    function (r) {
                        $scope.listadoAlumnosPorDiaRuta($scope.ruta);
                        alert(r.data.mensaje);
                    }
            );
        };


        $scope.guardarAlumnosEventuales = function () {
            var seleccionados = "";
            var i = 0;
            for (i = 0; i < $scope.listaAlumnos.length; i++) {
                if ($scope.listaAlumnos[i].seleccionado) {
                    seleccionados += $scope.listaAlumnos[i].id + ",";
                }
            }
            if (seleccionados.length == 0) {
                alert("no se han seleccionado alumnos para agregar");
                return;
            }
            if ($scope.idRuta == 0) {
                alert("selecciona una ruta");
                return
            }
            var fecha = moment($scope.fechaIni).format('YYYY-MM-DD');

            $http({
                method: 'POST',
                url: 'transporte_guardar_alumnos_eventuales',
                params: {
                    idAlumnos: seleccionados,
                    idRuta: $scope.idRuta,
                    fecha: fecha
                }
            }).then(
                    function (r) {
                        cerrarModal('crearEventual');
                        alert(r.data.mensaje);
                        $scope.listadoRutas();
                        $scope.listadoAlumnosPorDiaRuta($scope.ruta);
                        for (i = 0; i < $scope.listaAlumnos.length; i++) {
                            $scope.listaAlumnos[i].seleccionado = false;
                        }

                    }
            );


        };



        $scope.listadoAlumnosPorDiaRuta = function (r) {

            var fecha = moment($scope.fechaIni).format('YYYY-MM-DD');
            $scope.idRuta = r.id;
            $scope.rutaNombre = r.nombre;
            $scope.ruta = r;


            $http({
                method: 'POST',
                url: 'transporte_alumnos_por_ruta_dia',
                params: {
                    idRuta: r.id,
                    fecha: fecha
                }
            }).then(
                    function (r) {
                        $scope.listaAlumnosPorDia = r.data.listaAlumnos;
                    }
            );
        };

        //-------------------GuardarListasRuta

        $scope.guardarListasPorRuta = function () {

            var fecha = moment($scope.fechaIni).format('YYYY-MM-DD');
            $http({
                method: 'POST',
                url: 'transporte_guardar_listas_por_ruta',
                params: {
                    fecha: fecha
                }
            }).then(
                    function (r) {
                        alert(r.data.mensaje);
                        $scope.listadoRutas();
                    }
            );
        };


        //-------------------------------------------------




        //**************************Listado ALUMNOS*************************

        $scope.todosAlumnos = false;
        $scope.countSeleccionadosAlumnos = 0;

        $scope.seleccionarTodosAlumnos = function (flag) {
            $scope.countSeleccionadosAlumnos = 0;
            for (i = 0; i < $scope.listaAlumnos.length; i++) {
                $scope.listaAlumnos[i].seleccionado = flag;
                if (flag) {
                    $scope.countSeleccionadosAlumnos++;
                } else {
                    $scope.countSeleccionadosAlumnos--;
                }

            }
            if ($scope.countSeleccionadosAlumnos < 0) {
                $scope.countSeleccionadosAlumnos = 0;
            }
            $scope.todosAlumnos = flag;
        };


        $scope.seleccionarAlumno = function (a, flag) {
            a.seleccionado = flag;
            if (flag) {
                $scope.countSeleccionadosAlumnos++;
            } else {
                $scope.countSeleccionadosAlumnos--;
            }

        };


        $scope.listadoAlumnos = function (pag) {
            if (!pag) {
                pag = 1;
            }
            $scope.countSeleccionadosAlumnos = 0;
            $scope.todosAlumnos = false;

            $scope.paginaActualAlumnos = pag;
            var numRegistros = 5;//se cambio para que no salga el paginador
            var max = numRegistros;
            var offset = numRegistros * ($scope.paginaActualAlumnos - 1);

            var nombreAlumno = $scope.nombreAlumno;

            var idServicio = $scope.idServicio;
            var idCategoria = $scope.idCategoria;


            var idCiclo = '';
            var idGrado = '';
            var idGrupo = '';




            $http({
                method: 'POST',
                url: 'filtros-alumnos',
                params: {
                    offset: offset,
                    limit: max,
                    alumno: nombreAlumno, //nombreAlumno: nombreAlumno,
                    idCiclo: idCiclo,
                    idGrado: idGrado,
                    idGrupo: idGrupo,
                    idServicio: idServicio,
                    idCategoria: idCategoria

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

        $scope.guardarCambioEstatus = function () {
            var idAlumnoListaCambio = $scope.idAlumnoListaCambio;
            var estatus = $scope.estatusCambioA;


            $http({
                method: 'POST',
                url: 'transporte_cambiar_estatus_alumno_lista_ruta',
                params: {
                    idAlumnoCambio: idAlumnoListaCambio,
                    estatus: estatus
                }
            }).then(
                    function (r) {
                        cerrarModal('modalCambiarEstatus');
                        alert(r.data.mensaje);
                        $scope.listadoAlumnosPorDiaRuta($scope.ruta);
                        for (i = 0; i < $scope.listaAlumnos.length; i++) {
                            $scope.listaAlumnos[i].seleccionado = false;
                        }
                    }
            );
        };




    }]);

function cerrarModal(idModal) {
    $("#" + idModal).modal("hide");
}

