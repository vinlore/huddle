angular.module( 'headerCtrl', [] )
.controller( 'headerController', function ( $scope, $rootScope, $uibModal, $auth, $location, $timeout, Logout, $rootScope, $localStorage, popup, checkPermissions, isAdmin ) {

    $scope.isCollapsed = true;
    $scope.isAdmin = isAdmin();

    $scope.check = function(permission, thing, type) {
        return checkPermissions(permission, thing, type);
    }

    $scope.showCollapsed = function () {
        $scope.isCollapsed = !$scope.isCollapsed;
    }

    var logout = function () {
        Logout.save( {token: $auth.getToken()} )
            .$promise.then( function ( response ) { // OK
                console.log( response );
                if ( response.status == 200 ) { // If logout on server was successful
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

})
