rune.controller('CreditsController',['$scope', '$http', '$rootScope', function($scope, $http, $rootScope){

	console.log("cred");

	$scope.team = function() {
            $http.get($rootScope.root + '/api/index.php/credits')
                .then(function(data){
                    $scope.datas=JSON.parse(data.data.credits);
                    console.log(data.data.credits);
                   
                })
        };
	$scope.team();

}]);