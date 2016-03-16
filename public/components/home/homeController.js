angular.module ( 'homeCtrl', [] )
.controller ( 'homeController', function ( $scope, Conference, popup ) {
	
	$scope.conferences = Conference.all();
    console.log($scope.conferences);
    /*$scope.pastConferences = [];
    $scope.upcomingConferences = [];*/

    $scope.pastConferences = [
        {
            id: 123,
            name: "India Conference",
            country: "India",
            startDate: "Feb 20, 2016",
            endDate: "Feb 27, 2016",
        },
        {
            id: 234,
            name: "Canada Conference",
            country: "Canada",
            startDate: "Jan 29, 2016",
            endDate: "Feb 3, 2016"
        },
        {
            id: 1,
            name: "France Conference",
            country: "France",
            startDate: "Jan 5, 2016",
            endDate: "Jan 12, 2016"
        }
    ];

    /*$scope.loadPastConferences = function () {
        Conference.past().query()
            .$promise.then( function ( response ) {
                if ( response.status == 'success' && response.conferences ) {
                    $scope.pastConferences = response.conferences;
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    };

    $scope.loadPastConferences();

    $scope.loadUpcomingConferences = function () {
        Conference.upcoming().query()
            .$promise.then( function ( response ) {
                if ( response.status == 'success' && response.conferences ) {
                    $scope.pastConferences = response.conferences;
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    };

    $scope.loadUpcomingConferences();*/

})