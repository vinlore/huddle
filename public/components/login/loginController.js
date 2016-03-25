angular.module( 'loginCtrl', [] )
.controller( 'loginController', function( $scope, $auth, $state, $timeout, $rootScope, $localStorage, popup ) {

    $scope.invalid = false;
    $scope.valid = false;

    $scope.user = {
        username: null,
        password: null
    };

    $scope.login = function() {
        $auth.login( $scope.user ).then( function( response ) {
            console.log("Logging in...");
            if ( response.data.status == "success" && response.data.token && response.data.user_id && response.data.permissions ) {
                $rootScope.auth = $auth.isAuthenticated();
                $scope.invalid = false;
                $scope.valid = true;
                $localStorage.user = {
                    id: response.data.user_id,
                    name: $scope.user.username,
                    permissions: response.data.permissions
                };
                $rootScope.user = $localStorage.user;
                $timeout( function () {
                    $state.go('home');
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
