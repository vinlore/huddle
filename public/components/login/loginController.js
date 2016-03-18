angular.module( 'loginCtrl', [] )
.controller( 'loginController', function( $scope, $auth, $location, $timeout, $rootScope, $localStorage ) {

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
            if ( response.data.status == "success" && response.data.token && response.data.user_id ) {
                $rootScope.auth = $auth.isAuthenticated();
                $scope.invalid = false;
                $scope.valid = true;
                $localStorage.user = response.data.user_id;
                $localStorage.name = $scope.user.username;
                $rootScope.name = $localStorage.name;
                $timeout( function () {
                    $location.path('/');
                }, 300)
            } else {
                $scope.invalid = true;
            }
        }).catch( function( response ) {
            console.log( response );
            $scope.invalid = true;
        })
    }

})
