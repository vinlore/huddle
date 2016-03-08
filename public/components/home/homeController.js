angular.module ( 'homeCtrl', [] )
.controller ( 'homeController', function ( $scope, Conference ) {
	
	$scope.conferences = Conference.all();
    console.log($scope.conferences);

    $scope.pastConferences = [
        {
            name: "India Conference",
            country: "India",
            date: "Feb 10, 2016",
            image: "assets/img/india-flag.gif"
        },
        {
            name: "Canada Conference",
            country: "Canada",
            date: "Feb 16, 2016",
            image: "assets/img/canada-flag.gif"
        },
        {
            name: "France Conference",
            country: "France",
            date: "Feb 22, 2016",
            image: "assets/img/world-flag.gif"
        }
    ];

})