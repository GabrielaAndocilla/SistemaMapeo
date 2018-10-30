(function(){
  var app = angular.module('Udla',[
    'materia.controller',
    'materiagenerales.controller',
    'rdaReporte.controller',
    'chart.js',
    'angular-loading-bar'

  ], function($interpolateProvider) {
        	$interpolateProvider.startSymbol('<%');
      		$interpolateProvider.endSymbol('%>');
    	});
})();
