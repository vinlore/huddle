angular.module( 'userRegCtrl', [] )
.controller( 'userRegController', function( $scope, Register ) {

    $scope.user = {
        "Username": null,
        "Password": null,
        "Confirm Password": null,
        "First Name": null,
        "Middle Name": null,
        "Last Name": null,
        "Birthdate": null,
        "Country": null,
        "City": null,
        "Email": null,
        "Home Phone": null,
        "Other Phone": null
    };

    $scope.requiredField = function( ind ) {
        return ind == 3 || ind == 5 || ind == 6;
    };

    $scope.register = function() {
        Register.save( $scope.user )
            .$promise.then( function( response ) {
                console.log( 'User registered successfully' );
                $location.path('/');
            }, function ( response ) {
                console.log( 'Failed to register user' );
            })
    };

})
