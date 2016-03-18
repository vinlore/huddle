angular.module( 'userRegCtrl', [] )
.controller( 'userRegController', function( $scope, $rootScope, $auth, $filter, $location, Countries, Register, $localStorage, $rootScope, popup ) {

    $scope.user = {
        username: null,
        password: null,
        confirm: null,
        firstName: null,
        middleName: null,
        lastName: null,
        birthdate: null,
        country: null,
        city: null,
        email: null,
        phone: null,
        gender: null
    };

    $scope.countries = Countries;

    $scope.citiesOnly = {
        types: ['(cities)']
    };

    $scope.changeCountry = function (country) {
        $scope.citiesOnly.componentRestrictions = {country: country.code};
        console.log($scope.citiesOnly)
    }

    $scope.calendar = {
        isOpen: false
    };

    $scope.usernamePopover = [
        'AT LEAST 4 characters',
        'NO symbols or whitespaces'
    ];

    $scope.passwordPopover = [
        'AT LEAST 8 characters',
        'AT LEAST 1 number',
        'NO consecutive whitespaces',
        'NO start or end with whitespace'
    ];

    $scope.register = function() {
        var city, country = null;
        if ( $scope.user.city ) {
            city = $scope.user.city;
            if ( $scope.user.city.formatted_address ) {
                city = $scope.user.city.formatted_address;
            }
        }

        if ( $scope.user.country ) {
            country = $scope.user.country;
            if ( $scope.user.country.name ) {
                country = $scope.user.country.name;
            }
        }

        var user = {
            username: $scope.user.username,
            password: $scope.user.password,
            firstName: $scope.user.firstName,
            middleName: $scope.user.middleName,
            lastName: $scope.user.lastName,
            birthdate: $filter('date')($scope.user.birthdate, 'yyyy-MM-dd'),
            country: country,
            city: city,
            email: $scope.user.email,
            phone: $scope.user.phone,
            gender: $scope.user.gender
        };

        if ($scope.regForm.$valid) {
            Register.save( user )
                .$promise.then( function( response ) {
                    if ( response.status == 'success' && response.token && response.user_id) {
                        $auth.setToken( response.token );
                        $localStorage.user = {
                            id: response.user_id,
                            name: $scope.user.username
                        };
                        $rootScope.user = $localStorage.user;
                        $rootScope.auth = $auth.isAuthenticated();
                        popup.success("success", "Welcome to Huddle," + $scope.user.username + "!");
                        $location.path('/');
                    } else {
                        popup.error( 'Error', response.message );
                    }
                }, function ( response ) {
                    popup.connection();
                })
        }

    };

})
