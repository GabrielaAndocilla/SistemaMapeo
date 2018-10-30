(function(){
  "use strict";

    /*
    *------------------------------------------------------------------------------------------------------
    *  Silabo Controller JS
    *------------------------------------------------------------------------------------------------------
    */
    angular.module('materia.controller', ['udla.services']).controller('MateriaController', MateriaController);
    MateriaController.$inject = ['$window', 'udla'];

    function MateriaController($window, udla){
      var vm = this;
      vm.init = init;
      vm.getMaterias = getMaterias;
      vm.getAreas = getAreas;
      vm.filtrarDatos = filtrarDatos;
      vm.areaSelected = {};
      vm.areas = [];
      vm.materias = [];
      vm.idCarrera = 0;


      function init(){
        getMaterias();
        getAreas();
      }

      function getMaterias(){
        udla.getMaterias(vm.idCarrera).then(function(data){
          console.log(data.data);
          vm.materias = data.data;
        });
      }

      function getAreas(){
        udla.getAreas(vm.idCarrera).then(function(data){
          vm.areas = data.data;
        });
      }

      function filtrarDatos(){
        udla.getMateriasByArea(vm.idCarrera, vm.areaSelected).then(function(data){
          vm.materias = data.data;
        });
      }

    }

    /*
    *------------------------------------------------------------------------------------------------------
    *  Silabo Controller JS
    *------------------------------------------------------------------------------------------------------
    */
    angular.module('materiagenerales.controller', ['udla.services']).controller('MateriaGeneralesController', MateriaGeneralesController);
    MateriaGeneralesController.$inject = ['$window', 'udla'];

    function MateriaGeneralesController($window, udla){
      var vm = this;
      vm.init = init;
      vm.getGeneralesMaterias = getGeneralesMaterias;
      vm.getAreas = getAreas;
      vm.filtrarDatos = filtrarDatos;
      vm.areaSelected = {};
      vm.areas = [];
      vm.materias = [];
      vm.idCarrera = 0;

      init();

      function init(){
      //  getMaterias();
        getAreas();
      }

      function getGeneralesMaterias(){
        udla.getGeneralesMaterias(vm.idCarrera).then(function(data){
          console.log(data.data);
          vm.materias = data.data;
        });
      }

      function getAreas(){
        udla.getAreas(vm.idCarrera).then(function(data){
          vm.areas = data.data;
        });
      }

      function filtrarDatos(){
      //  udla.getMateriasByArea(vm.idCarrera, vm.areaSelected).then(function(data){
        //  vm.materias = data.data;
      //  });
      }

    }
    /*
    *------------------------------------------------------------------------------------------------------
    *  Reporte Rda Controller
    *------------------------------------------------------------------------------------------------------
    */
    angular.module('rdaReporte.controller', ['udla.services']).controller('ReporteRdaController', ReporteRdaController);
    ReporteRdaController.$inject = ['$window', 'udla'];

    function ReporteRdaController($window, udla){
      var vm = this;
      vm.init = init;
      vm.labels = [];
      vm.data = [];
      init();

      function init(){
          vm.labels = ["Primer Rda", "Segundo Rda", "Tercer Rda"];
          vm.data = [10, 20, 70];

      }

    }


  })();
