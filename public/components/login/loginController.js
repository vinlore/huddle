angular.module( 'loginCtrl', [] )
.controller( 'loginController', function( $scope, $auth, $location, $rootScope ) {

    $scope.invalid = false;

    $scope.user = {
        username: null,
        password: null
    };

    $scope.login = function() {
        $auth.login( $scope.user ).then( function( response ) {
            console.log( response );
            $rootScope.auth = $auth.isAuthenticated;
            $scope.invalid = false;
            $location.path('/');
        }).catch( function( response ) {
            console.log( response );
            $scope.invalid = true;
        })
    }

})
