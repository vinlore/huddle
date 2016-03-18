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
                        popup.success("success", "Successfully logged out!");
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

})
