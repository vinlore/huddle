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
        gender: null,
        receive: false
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
            password_confirmation: $scope.user.confirm,
            first_name: $scope.user.firstName,
            middle_name: $scope.user.middleName,
            last_name: $scope.user.lastName,
            birthdate: $filter('date')($scope.user.birthdate, 'yyyy-MM-dd'),
            country: country,
            city: city,
            email: $scope.user.email,
            phone: $scope.user.phone,
            gender: $scope.user.gender,
            receive_email: $scope.user.receive
        };

        if ($scope.regForm.$valid) {
            Register.save( user )
                .$promise.then( function( response ) {
                    if ( response.status == 200 && response.token && response.user_id && response.permissions) {
                        $auth.setToken( response.token );
                        $localStorage.user = {
                            id: response.user_id,
                            name: $scope.user.username,
                            permissions: response.permissions,
                            profile_id: response.profile_id,
                            conferences: response.manages_conf,
                            events: response.manages_event
                        };
                        $rootScope.user = $localStorage.user;
                        $rootScope.auth = $auth.isAuthenticated();
                        popup.alert("success", "Welcome to Huddle," + $scope.user.username + "!");
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
