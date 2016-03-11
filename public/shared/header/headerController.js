angular.module( 'headerCtrl', [] )
.controller( 'headerController', function ( $scope, $rootScope, $uibModal, $auth, $location, $timeout, Logout, $rootScope, $localStorage ) {

    $scope.isCollapsed = true;

    $scope.showCollapsed = function () {
        $scope.isCollapsed = !$scope.isCollapsed;
    }

    var logout = function () {
        Logout.save( {token: $auth.getToken()} )
            .$promise.then( function ( response ) { // OK
                console.log( response );
                if ( response.status == 'success' ) { // If logout on server was successful
                    console.log( "Logging out..." );
                    $auth.logout().then( function ( result ) { // If logout on front-end was successful
                        $rootScope.auth = $auth.isAuthenticated();
                        delete $localStorage.user;
                        $rootScope.user = null;
                        $location.path('/');
                    });
                }
            }, function ( response ) { // API call failed
                console.log( "An error occurred while logging in." );
            })
    };

    $scope.logout = function () {
        var modalInstance = $uibModal.open({
            templateUrl: 'shared/popupPrompt/popupPrompt.html',
            controller: 'popupPromptController',
            size: 'sm',
            windowClass: 'center-modal',
            resolve: {
                content: function () {
                    return {
                        title: 'Logout',
                        body: 'Are you sure you want to logout?'
                    }
                }
            }
        });

        modalInstance.result.then( function ( result ) {
            if ( result ) {
                logout();
            }
        } )
    }

})
