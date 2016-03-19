angular.module( 'loginCtrl', [] )
.controller( 'loginController', function( $scope, $auth, $location, $timeout, $rootScope, $localStorage, popup ) {

    $scope.invalid = false;
    $scope.valid = false;

    $scope.user = {
        username: null,
        password: null
    };

    $scope.login = function() {
        $auth.login( $scope.user ).then( function( response ) {
            console.log("Logging in...");
            if ( response.data.status == "success" && response.data.token && response.data.user_id ) {
                $rootScope.auth = $auth.isAuthenticated();
                $scope.invalid = false;
                $scope.valid = true;
                $localStorage.user = {
                    id: response.data.user_id,
                    name: $scope.user.username
                };
                $rootScope.user = $localStorage.user;
                $timeout( function () {
                    $location.path('/');
                    popup.alert('success', 'Welcome back, ' + $scope.user.username + "!");
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
