var app = angular.module('servicio', []);

app.controller('servicioController', ['$http', '$scope', function ($http, $scope) {
       
        $scope.paginaActual = 1;

        var date = new Date();
        // var primerDia = new Date(date.getFullYear(), date.getMonth(), 1);
        //var ultimoDia = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        var primerDia = new Date(date.getFullYear(), date.getMonth(), 1);
        var ultimoDia = new Date(date.getFullYear(), date.getMonth() + 1, date.getDate());


        $scope.fechaIni = primerDia;
        $scope.fechaFin = ultimoDia;
        $scope.categoria = "0";


        $scope.limpiarModalServicio = function () {
            $scope.mCategoria = "";
            $scope.mNombre = "";
            $scope.mPrecio = "";
            //   $scope.mPagoObligarotio = null;
            $scope.mAplicaParcialidad = null;
            $scope.mTipoClientes = null;
            $scope.mCapacidad = null;
            $scope.mFechaEvento = new Date();
            $scope.mFechaIni = new Date();
            $scope.mFechaFin = new Date();
            $scope.estatus = "NUEVO";
            $scope.mIdServicio = 0;
            $scope.mTipoServicio = 0;

        };

        $scope.limpiarModalServicio();

        $scope.guardarServicio = function () {

            var mNombre = $scope.mNombre;
            var mPrecio = $scope.mPrecio;
            // var mPagoObligarotio = $scope.mPagoObligarotio;
            var mAplicaParcialidad = $scope.mAplicaParcialidad;
            var mFechaEvento = moment($scope.mFechaEvento).format('YYYY-MM-DD');
            var mFechaIni = moment($scope.mFechaIni).format('YYYY-MM-DD');
            var mFechaFin = moment($scope.mFechaFin).format('YYYY-MM-DD');
            var mTipoClientes = $scope.mTipoClientes;
            var mIdServicio = $scope.mIdServicio;
            var mCapacidad = $scope.mCapacidad;
            var mCategoria = $scope.mCategoria;
            var mTipoServicio = $scope.mTipoServicio;

            var mIdServicioReferencia = 0;//id del servicio que estamos clonando
            var mIdServicioPadre = 0; //id del servicio padre



            if (mNombre == undefined || mPrecio == undefined || mAplicaParcialidad == undefined
                    || mFechaEvento == undefined || mFechaIni == undefined || mFechaFin == undefined || mTipoClientes == undefined
                    || mCapacidad == undefined || mCategoria == undefined) {
                alert("Todos los campos son obligatorios");
                return;
            }

            if (mFechaIni > mFechaFin) {
                alert("La fecha Inicial no puede ser mayor a la fecha Final");
                return;
            }

            if ($scope.estatus != "EDITAR") {
                mIdServicio = 0;
            }
            if ($scope.estatus == "CLONAR") {
                mIdServicioReferencia = $scope.mIdServicioReferencia;
            }
            if ($scope.estatus == "HIJO") {
                mIdServicioPadre = $scope.mIdServicioPadre;
            }
            inicioActualizarBoton('botonGuardar');

            $http({
                method: 'POST',
                url: 'servicios_guardar_nuevo_servicio',
                //url: '/web/skin_dev.php/guardar_pago',
                params: {
                    mCategoria: mCategoria,
                    mIdServicio: mIdServicio,
                    mNombre: mNombre,
                    mPrecio: mPrecio,
                    //mPagoObligarotio: mPagoObligarotio,
                    mAplicaParcialidad: mAplicaParcialidad,
                    mFechaEvento: mFechaEvento,
                    mFechaIni: mFechaIni,
                    mFechaFin: mFechaFin,
                    mTipoClientes: mTipoClientes,
                    mCapacidad: mCapacidad,
                    mIdServicioReferencia: mIdServicioReferencia, //para clonar
                    mIdServicioPadre: mIdServicioPadre, //para hacer su hijo
                    mTipoServicio: mTipoServicio
                }
            }).then(
                    function (r) {
                        finActualizarBoton('botonGuardar');
                        cerrarModal('crearServicio');
                        if (r.data.error) {
                            alert(r.data.mensaje);
                        } else {
                            $scope.limpiarModalServicio();
                            $scope.listadoServicios($scope.paginaActual);
                        }
                    }
            );




        };

        $scope.detalleServicio = function (s) {

            $scope.limpiarModalServicio();
            $scope.mCategoria = s.categoria_id;
            $scope.mIdServicio = s.id;
            $scope.mNombre = s.nombre;
            $scope.mPrecio = parseFloat(s.precio);
            //  $scope.mPagoObligarotio = s.pago_obligatorio;
            $scope.mAplicaParcialidad = s.aplica_parcialidad;
            $scope.mTipoClientes = s.tipo_cliente;
            $scope.mCapacidad = parseInt(s.capacidad);
            $scope.mFechaEvento = new Date(s.fecha_evento + ' 00:00:00');
            $scope.mFechaIni = new Date(s.fecha_inicio);
            $scope.mFechaFin = new Date(s.fecha_fin);
            $scope.mTipoServicio = s.tipo_transporte;
            $scope.estatus = "DETALLE";
        };

        $scope.editarServicio = function (s) {

            $scope.limpiarModalServicio();
            $scope.mCategoria = s.categoria_id;
            $scope.mIdServicio = s.id;
            $scope.mNombre = s.nombre;
            $scope.mPrecio = parseFloat(s.precio);
            //    $scope.mPagoObligarotio = s.pago_obligatorio;
            $scope.mAplicaParcialidad = s.aplica_parcialidad;
            $scope.mTipoClientes = s.tipo_cliente;
            $scope.mCapacidad = parseInt(s.capacidad);
            $scope.mFechaEvento = new Date(s.fecha_evento + ' 00:00:00');
            $scope.mFechaIni = new Date(s.fecha_inicio);
            $scope.mFechaFin = new Date(s.fecha_fin);
            $scope.mTipoServicio = s.tipo_transporte;
            $scope.estatus = "EDITAR";
        };

        $scope.clonarServicio = function (s) {
            $scope.limpiarModalServicio();
            $scope.mCategoria = s.categoria_id;
            $scope.mNombre = s.nombre;
            $scope.mPrecio = parseFloat(s.precio);
            //   $scope.mPagoObligarotio = s.pago_obligatorio;
            $scope.mAplicaParcialidad = s.aplica_parcialidad;
            $scope.mTipoClientes = s.tipo_cliente;
            $scope.mCapacidad = parseInt(s.capacidad);
            $scope.mFechaEvento = new Date(s.fecha_evento + ' 00:00:00');
            $scope.mFechaIni = new Date(s.fecha_inicio);
            $scope.mFechaFin = new Date(s.fecha_fin);
            $scope.estatus = "CLONAR";
            $scope.mIdServicioReferencia = s.id;//id del servicio que estamos clonando
            $scope.mTipoServicio = s.tipo_transporte;


        };
        $scope.servicioHijo = function (id) {
            $scope.limpiarModalServicio();
            $scope.estatus = "HIJO";
            $scope.mIdServicioPadre = id;//id del servicio padre
        };


        $scope.eliminarServicio = function (id) {

            var idServicio = id;

            var r = confirm("Confirma la Eliminacion del servicio");
            
            debugger;
            if (r == false) {                
                return ;
            }


            $http({
                method: 'POST',
                url: 'servicios_eliminar_servicio',
                params: {
                    idServicio: idServicio
                }
            }).then(
                    function (r) {
                        if (r.data.error) {
                            alert(r.data.mensaje);
                        } else {
                            $scope.listadoServicios($scope.paginaActual);
                        }
                    }
            );
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



        //-----------------Listado de servicios--------------

        $scope.listadoServicios = function (pag) {
            if (!pag) {
                pag = 1;
            }

            $scope.paginaActual = pag;
            var numRegistros = 10;//se cambio para que no salga el paginador
            var max = numRegistros;
            var offset = numRegistros * ($scope.paginaActual - 1);


            var fechaIni = moment($scope.fechaIni).format('YYYY-MM-DD');
            var fechaFin = moment($scope.fechaFin).format('YYYY-MM-DD');
            var nombreServicio = $scope.nombreServicio;
            var categoria = $scope.categoria;

            if ($scope.fechaIni > $scope.fechaFin) {
                alert("La fecha Desde no puede ser mayor a Fecha Fin");
                return;
            }

            $http({
                method: 'POST',
                url: 'servicios_listado_servicios',
                params: {
                    offset: offset,
                    limit: max,
                    fechaIni: fechaIni,
                    fechaFin: fechaFin,
                    nombreServicio: nombreServicio,
                    categoria: categoria
                }
            }).then(
                    function (r) {
                        $scope.listaServicios = r.data.listaServicios;
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
            $scope.listadoServicios($scope.paginaActual);
        };
        $scope.siguiente = function () {
            $scope.paginaActual = $scope.paginaActual + 1;
            if ($scope.paginaActual > $scope.ultima) {
                $scope.paginaActual = $scope.primera;
            }
            $scope.listadoServicios($scope.paginaActual);


        };

        $scope.ini = function () {
            $scope.paginaActual = $scope.primera;
            $scope.listadoServicios($scope.paginaActual);
        };
        $scope.end = function () {
            $scope.paginaActual = $scope.ultima;
            $scope.listadoServicios($scope.paginaActual);
        };

        //-----------------Fin listado servicios----------------


        $scope.listadoServicios();
        $scope.listadoCategoriasServicios();


//***********Asignados***********
        $scope.asignadosServicio = function (s) {

            $scope.idServicio = s.id;
            $scope.listadoAsignados();


        };

        $scope.imprimirAsignadosAServicio = function () {

            var nombreCliente = "";
            if ($scope.nombreAsignado != undefined && $scope.nombreAsignado != null) {
                nombreCliente = $scope.nombreAsignado;
            }
            var idServicio = $scope.idServicio;

            window.open('servicios_imprimir_asignados_a_servicio?limit=1000&offset=0&idServicio=' +
                    idServicio + '&nombreCliente=' + nombreCliente, '_blank');
            return;

        };


        $scope.paginaActualAsignados = 1;
        $scope.listadoAsignados = function (pag) {
            if (!pag) {
                pag = 1;
            }
            $scope.countSeleccionadosAsignados = 0;
            $scope.todosAsignados = false;

            $scope.paginaActualAsignados = pag;
            var numRegistros = 10;//se cambio para que no salga el paginador
            var max = numRegistros;
            var offset = numRegistros * ($scope.paginaActualAsignados - 1);

            var nombreCliente = $scope.nombreAsignado;

            $http({
                method: 'POST',
                url: 'servicios_asignados_a_servicio',
                params: {
                    offset: offset,
                    limit: max,
                    nombreCliente: nombreCliente,
                    idServicio: $scope.idServicio
                }
            }).then(
                    function (r) {
                        $scope.listaAsignados = r.data.listaAsignados;
                        $scope.numeroRegistrosAsignados = r.data.total;
                        $scope.paginadorAsignados(max);
                    }
            );

        };

        $scope.paginadorAsignados = function (max) {
            $scope.numPaginasAsignados = Math.ceil($scope.numeroRegistrosAsignados / max);
            $scope.tamanioPaginadorAsignados = 10;//estatico
            $scope.primeraAsignados = 1;//numero de pagina de inicioAsignados
            $scope.ultimaAsignados = $scope.numPaginasAsignados;//numero de pagina de finAsignados 

            $scope.inicioAsignados = $scope.paginaActualAsignados - ($scope.tamanioPaginadorAsignados / 2);
            if ($scope.inicioAsignados < $scope.primeraAsignados) {
                $scope.inicioAsignados = $scope.primeraAsignados;
            }
            //$scope.finAsignados = $scope.paginaActualAsignados + ($scope.tamanioPaginadorAsignados / 2);
            $scope.finAsignados = $scope.inicioAsignados + $scope.tamanioPaginadorAsignados;
            if ($scope.finAsignados > $scope.ultimaAsignados) {
                $scope.finAsignados = $scope.ultimaAsignados;
                $scope.inicioAsignados = $scope.ultimaAsignados - $scope.tamanioPaginadorAsignados;
                if ($scope.inicioAsignados < $scope.primeraAsignados) {
                    $scope.inicioAsignados = $scope.primeraAsignados;
                }

            }

            $scope.paginadoAsignados = [];
            for (i = $scope.inicioAsignados; i <= $scope.finAsignados; i++) {
                $scope.paginadoAsignados.push(i);
            }
        };

        $scope.anteriorAsignados = function () {
            $scope.paginaActualAsignados = $scope.paginaActualAsignados - 1;
            if ($scope.paginaActualAsignados < $scope.primeraAsignados) {
                $scope.paginaActualAsignados = $scope.primeraAsignados;
            }
            $scope.listadoAsignados($scope.paginaActualAsignados);
        };
        $scope.siguienteAsignados = function () {
            $scope.paginaActualAsignados = $scope.paginaActualAsignados + 1;
            if ($scope.paginaActualAsignados > $scope.ultimaAsignados) {
                $scope.paginaActualAsignados = $scope.primeraAsignados;
            }
            $scope.listadoAsignados($scope.paginaActualAsignados);


        };

        $scope.iniAsignados = function () {
            $scope.paginaActualAsignados = $scope.primeraAsignados;
            $scope.listadoAsignados($scope.paginaActualAsignados);
        };
        $scope.endAsignados = function () {
            $scope.paginaActualAsignados = $scope.ultimaAsignados;
            $scope.listadoAsignados($scope.paginaActualAsignados);
        };

//----------------------------------

//Funcion relocate

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

function inicioActualizarBoton(idBoton) {
    $("#" + idBoton).prop("disabled", true);
}

function finActualizarBoton(idBoton) {    
    $("#" + idBoton).prop("disabled", false);
}