angular.module( 'loginCtrl', [] )
.controller( 'loginController', function( $scope, $auth, $location, $timeout, $rootScope ) {

    $scope.invalid = false;
    $scope.valid = false;

    $scope.user = {
        username: null,
        password: null
    };

    $scope.login = function() {
        $auth.login( $scope.user ).then( function( response ) {
            console.log("Logging in...");
            console.log( response );
            if ( response.data.token && response.data.user ) {
                $rootScope.auth = $auth.isAuthenticated;
                $scope.invalid = false;
                $scope.valid = true;
                $timeout( function () {
                    $location.path('/');
                }, 1500)
            } else {
                $scope.invalid = true;
            }
        }).catch( function( response ) {
            console.log( response );
            $scope.invalid = true;
        })
    }

})
