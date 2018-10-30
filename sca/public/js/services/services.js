(function(){
	angular.module('udla.services',[]).factory('udla', udlaServices);
	udlaServices.$inject = ['$http'];

  function udlaServices($http){
    var url = location.origin;
    var services = {
      getMaterias: getMaterias,
			getAreas: getAreas,
			getMateriasByArea: getMateriasByArea,
			getGeneralesMaterias: getGeneralesMaterias
    };
    return services;

    function getMaterias(id){
			return $http.get(url+"/api/rest/materia/especializacion/" + id).then(getMateriasSuccess).catch(getMateriasFail);
			function getMateriasSuccess(data){
				return data;
			}
			function getMateriasFail(){
				console.log("no funciono");
			}
		}

		function getGeneralesMaterias(id){
			return $http.get(url+"/api/rest/materia/generales/" + id).then(getMateriasSuccess).catch(getMateriasFail);
			function getMateriasSuccess(data){
				return data;
			}
			function getMateriasFail(){
				console.log("no funciono");
			}
		}

		function getAreas(id){
			return $http.get(url+"/api/rest/area/" + id).then(getAreasSuccess).catch(getAreasFail);
			function getAreasSuccess(data){
				return data;
			}
			function getAreasFail(){
				console.log("no funciono");
			}
		}

		function getMateriasByArea(carrera, area){
			return $http.get(url+"/api/rest/materia/especializacion/" + carrera + "/a/" + area).then(getMateriasByAreaSuccess).catch(getMateriasByAreaFail);
			function getMateriasByAreaSuccess(data){
				return data;
			}
			function getMateriasByAreaFail(){
				console.log("no funciono");
			}
		}

  }


})();
