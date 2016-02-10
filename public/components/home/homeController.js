angular.module('homeCtrl', [])
.controller('homeController', function($scope) {

    $scope.isCollapsed = true;
	
	$scope.conferences = [
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
    ]

})