angular.module( 'userRegCtrl', [] )
.controller( 'userRegController', function( $scope, $filter, Countries, Register ) {

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
        "Phone": null
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
            birthdate: $filter('date')($scope.user.Birthdate, 'MMM d, yyyy'),
            country: $scope.user.Country,
            city: city,
            email: $scope.user.Email,
            phone: $scope.user.Phone
        };

        Register.save( user )
            .$promise.then( function( response ) {
                console.log( 'User registered successfully' );
                $location.path('/');
            }, function ( response ) {
                console.log( 'Failed to register user' );
            })
    };

})
