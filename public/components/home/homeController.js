angular.module ( 'homeCtrl', [] )
.controller ( 'homeController', function ( $scope, Conference ) {
	
	$scope.conferences = Conference.all();
    console.log($scope.conferences);

    $scope.pastConferences = [
        {
            id: 123,
            name: "India Conference",
            country: "India",
            startDate: "Mar 20, 2016",
            endDate: "Mar 27, 2016",
        },
        {
            id: 234,
            name: "Canada Conference",
            country: "Canada",
            startDate: "Mar 29, 2016",
            endDate: "Apr 3, 2016"
        },
        {
            id: 1,
            name: "France Conference",
            country: "France",
            startDate: "Apr 5, 2016",
            endDate: "Apr 12, 2016"
        }
    ];

})