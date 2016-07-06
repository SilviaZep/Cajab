var app = angular.module('rutas', []);

app.controller('rutasController', ['$http', '$scope', function ($http, $scope) {

        $scope.paginaActual = 1;


        $scope.limpiarModalRutas = function () {
            $scope.mNombre = "";
            $scope.mDescripcion = "";
            $scope.mHorario = "";
            $scope.mCapacidad = null;
            $scope.mConductor = "";

            $scope.editando = false;
            $scope.mIdRuta = 0;
        };

        $scope.limpiarModalRutas();

        $scope.guardarRuta = function () {

            var mNombre = $scope.mNombre;
            var mDescripcion = $scope.mDescripcion;
            var mHorario = $scope.mHorario;
            var mCapacidad = $scope.mCapacidad;
            var mConductor = $scope.mConductor;
            var mIdRuta = $scope.mIdRuta;



            if (mNombre == undefined || mDescripcion == undefined || mHorario == undefined || mCapacidad == undefined
                    || mConductor == undefined) {
                alert("Todos los campos son obligatorios");
                return;
            }

            if (!$scope.editando) {
                mIdRuta = 0;
            }

            $http({
                method: 'POST',
                url: 'transporte_guardar_ruta',
                //url: '/web/skin_dev.php/guardar_pago',
                params: {
                    mIdRuta: mIdRuta,
                    mNombre: mNombre,
                    mDescripcion: mDescripcion,
                    mHorario: mHorario,
                    mCapacidad: mCapacidad,
                    mConductor: mConductor                    
                }
            }).then(
                    function (r) {
                        cerrarModal('crearRuta');
                        if (r.data.error) {
                            alert(r.data.mensaje);
                        } else {
                            $scope.limpiarModalRutas();
                            $scope.listadoRutas($scope.paginaActual);
                        }
                    }
            );




        };

        $scope.editarRuta = function (r) {

            $scope.limpiarModalRutas();
            $scope.mNombre=r.nombre;
            $scope.mDescripcion=r.descripcion;
            $scope.mHorario=r.horario;
            $scope.mCapacidad=parseInt(r.capacidad);
            $scope.mConductor=r.chofer;
            $scope.mIdRuta=r.id;
            $scope.editando = true;
        };

        $scope.eliminarRuta = function (id) {

            var idRuta = id;

            $http({
                method: 'POST',
                url: 'transporte_eliminar_ruta',
                params: {
                    idRuta: idRuta
                }
            }).then(
                    function (r) {
                        if (r.data.error) {
                            alert(r.data.mensaje);
                        } else {
                            $scope.listadoRutas($scope.paginaActual);
                        }
                    }
            );



        };





        //-----------------Listado de servicios--------------

        $scope.listadoRutas = function (pag) {
            if (!pag) {
                pag = 1;
            }

            $scope.paginaActual = pag;
            var numRegistros = 10;//se cambio para que no salga el paginador
            var max = numRegistros;
            var offset = numRegistros * ($scope.paginaActual - 1);


           
            var nombreRuta = $scope.nombreRuta;


            $http({
                method: 'POST',
                url: 'transporte_listado_rutas_activas',
                params: {
                    offset: offset,
                    limit: max,                    
                    nombreRuta:nombreRuta
                }
            }).then(
                    function (r) {
                        $scope.listaRutas = r.data.listaRutas;
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
            $scope.listadoRutas($scope.paginaActual);
        };
        $scope.siguiente = function () {
            $scope.paginaActual = $scope.paginaActual + 1;
            if ($scope.paginaActual > $scope.ultima) {
                $scope.paginaActual = $scope.primera;
            }
            $scope.listadoRutas($scope.paginaActual);


        };

        $scope.ini = function () {
            $scope.paginaActual = $scope.primera;
            $scope.listadoRutas($scope.paginaActual);
        };
        $scope.end = function () {
            $scope.paginaActual = $scope.ultima;
            $scope.listadoRutas($scope.paginaActual);
        };

        $scope.listadoRutas();


        //-----------------Fin listado servicios----------------







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