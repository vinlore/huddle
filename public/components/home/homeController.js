angular.module ( 'homeCtrl', [] )
.controller ( 'homeController', function ( $scope, Conference, Gmap ) {
	
	$scope.conferences = Conference.all();
    console.log($scope.conferences);

    // Creates Google Static Maps API URL using conference object using mapService:Gmap
    $scope.getMap = function(conference) {
        var location = conference.city + ", " + conference.country;
        return Gmap(location, "400x250", 10, []);
    }

    $scope.pastConferences = [
        {
            name: "India Conference",
            location: "India",
            date: "Feb 10, 2016",
            image: "assets/img/india-flag.gif"
        },
        {
            name: "Canada Conference",
            location: "Canada",
            date: "Feb 16, 2016",
            image: "assets/img/canada-flag.gif"
        },
        {
            name: "France Conference",
            location: "France",
            date: "Feb 22, 2016",
            image: "assets/img/world-flag.gif"
        }
    ];

})