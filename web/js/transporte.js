var app = angular.module('transporte', []);

app.controller('transporteController', ['$http', '$scope', function ($http, $scope) {

        var rutaLunMat = {id:1,nombre: 'A', hora: '08:30:00', dia: 'lunes'};
        var rutaLunVes = {id:2,nombre: 'A', hora: '08:30:00', dia: 'lunes'};
        var rutaMarMat = {id:3,nombre: 'B', hora: '08:30:00', dia: 'martes'};
        var rutaMarVes = {id:4,nombre: 'B', hora: '08:30:00', dia: 'martes'};
        var rutaMieMat = {id:5,nombre: 'B', hora: '08:30:00', dia: 'miercoles'};
        var rutaMieVes = {id:6,nombre: 'B', hora: '08:30:00', dia: 'miercoles'};
        var rutaJueMat = {id:7,nombre: 'A', hora: '08:30:00', dia: 'jueves'};
        var rutaJueVes = {id:8,nombre: 'A', hora: '08:30:00', dia: 'jueves'};
        var rutaVieMat = {id:9,nombre: 'C', hora: '08:30:00', dia: 'viernes'};
        var rutaVieVes = {id:10,nombre: 'C', hora: '08:30:00', dia: 'viernes'};
        var rutas = [rutaLunMat, rutaLunVes, rutaMarMat, rutaMarVes, rutaMieMat, rutaMieVes,
            rutaJueMat, rutaJueVes, rutaVieMat, rutaVieVes];


        $scope.alumnos = [];
        $scope.rutas = rutas;
        var i = 0;
        for (i = 0; i < 10; i++) {

            var alumno = {id: i + 1, nombre: 'salvador coronel' + i.toString(), rutas: $scope.rutas};
            $scope.alumnos.push(alumno);

        }

        debugger

        $scope.cambiarRuta = function (a) {
            $scope.alumnoNombre = a.nombre;
            debugger

        };

       /*   $scope.buscarOrdenServicio = function () {
         var noOrdenId = $("#noOrdenServicio").val();
         
         $http({
         method: 'POST',
         url: '/skindepile/web/skin_dev.php/servicios_orden_servicio',
         params: {noOrden: noOrdenId}
         }).then(
         function (r) {
         $scope.gIdOrden = r.data.idOrden;
         $scope.gServicios = r.data.servicios;
         $scope.nombreCliente=r.data.cliente;
         debugger
         
         }
         );
         };*/





    }]);

