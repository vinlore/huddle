angular.module( 'userRegCtrl', [] )
.controller( 'userRegController', function( $scope, $rootScope, $auth, $filter, $location, Countries, Register ) {

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
        "Phone": null,
        "Gender": null
    };

    $scope.countries = Countries;

    $scope.calendar = {
        isOpen: false
    };

    $scope.citiesOnly = {
        types: ['(cities)']
    };

    $scope.register = function() {
        var city = null;
        if ( $scope.user.City ) city = $scope.user.City.formatted_address;
        var user = {
            username: $scope.user.Username,
            password: $scope.user.Password,
            firstName: $scope.user['First Name'],
            middleName: $scope.user['Middle Name'],
            lastName: $scope.user['Last Name'],
            birthdate: $filter('date')($scope.user.Birthdate, 'yyyy-MM-dd'),
            country: $scope.user.Country,
            city: city,
            email: $scope.user.Email,
            phone: $scope.user.Phone,
            gender: $scope.user.Gender
        };

        Register.save( user )
            .$promise.then( function( response ) {
                if ( response.status == 'success' ) {
                    console.log( 'User registered successfully' );
                    $auth.setToken( response.token );
                    $rootScope.auth = $auth.isAuthenticated();
                    $location.path('/');
                }
            }, function ( response ) {
                console.log( 'Failed to register user' );
            })
    };

})
