angular.module ( 'homeCtrl', [] )
.controller ( 'homeController', function ( $scope, Conferences, popup, $filter ) {

	$scope.conferences = {};

    $scope.loadConferences = function () {
        Conferences.status().query({status:'approved'})
            .$promise.then( function ( response ) {
                if ( response ) {
                    $scope.conferences = $filter('upcoming')(response);
                } else {
                    $scope.conferences = {};
                }
            })
    };

    $scope.loadConferences();

})
