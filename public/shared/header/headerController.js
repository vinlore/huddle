angular.module( 'headerCtrl', [] )
.controller( 'headerController', function ( $scope, $rootScope, $uibModal, $auth, $location, $timeout, Logout, $rootScope, $localStorage, popup ) {

    $scope.isCollapsed = true;

    $scope.showCollapsed = function () {
        $scope.isCollapsed = !$scope.isCollapsed;
    }

    var logout = function () {
        Logout.save( {token: $auth.getToken()} )
            .$promise.then( function ( response ) { // OK
                console.log( response );
                if ( response.status == 'success' ) { // If logout on server was successful
                    $auth.logout().then( function ( result ) { // If logout on front-end was successful
                        $rootScope.auth = $auth.isAuthenticated();
                        delete $localStorage.user;
                        $rootScope.user = null;
                        popup.alert("success", "Successfully logged out!");
                        $location.path('/');
                    });
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () { // API call failed
                popup.connection();
            })
    };

    $scope.logout = function () {
        var modalInstance = popup.prompt( 'Logout', 'Are you sure you want to logout?' );

        modalInstance.result.then( function ( result ) {
            if ( result ) {
                logout();
            }
        } )
    }

    $scope.logs = [
      {Time: "01:00:00",
       Date: "Monday March 7, 2016",
       Log: "James created a conference name India"},

      {Time: "02:00:00",
        Date: "Tuesday March 8, 2016",
        Log: "Gabby is requesting to attend Canada conference"},

      {Time: "03:00:00",
         Date: "Wednesday March 9, 2016",
         Log: "Viggy editted France conference"},

      ];

    $scope.checkPermissions = function (type) {
        var p = $rootScope.user.permissions;
        switch (type) {
            case 'admin':
                return p['accommodations.store'] || p['accommodations.update'] || p['accommodations.destroy'] || p['accommodations.show'] || p['conference_vehicles.store'] || p['conference_vehicles.update'] || p['conference_vehicles.destroy'] || p['conference_vehicles.show'] || p['conference_attendees.store'] || p['conference_attendees.update'] || p['conference_attendees.destroy'] || p['conference_attendees.show'] || p['item.store'] || p['item.update'] || p['item.destroy'] || p['item.show'] || p['event_vehicles.store'] || p['event_vehicles.update'] || p['event_vehicles.destroy'] || p['event_vehicles.show'] || p['event_attendees.store'] || p['event_attendees.update'] || p['event_attendees.destroy'] || p['event_attendees.show'];
        }
    }

})
