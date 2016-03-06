angular.module( 'headerCtrl', [] )
.controller( 'headerController', function ( $scope, $rootScope, $uibModal, $auth, $location, Logout ) {

    var logout = function () {
        Logout.save( $auth.getToken() )
            .$promise.then( function ( response ) { // OK
                console.log( response );
                if ( response.success ) { // If logout on server was successful
                    console.log( "Logging out..." );
                    $auth.logout().then( function ( result ) { // If logout on front-end was successful
                        $rootScope.auth = $auth.isAuthenticated();
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
