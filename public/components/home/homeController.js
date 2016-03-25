angular.module ( 'homeCtrl', [] )
.controller ( 'homeController', function ( $scope, Conferences, popup ) {

	$scope.conferences = [];
    console.log($scope.conferences);

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

    $scope.loadConferences = function () {
        Conferences.fetch().query()
            .$promise.then( function ( response ) {
                if ( response ) {
                    $scope.conferences = response;
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    };

    $scope.loadConferences();

})
