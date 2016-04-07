angular.module( 'createConferenceCtrl', [])
.controller( 'createConferenceController', function( $scope, Countries, Conferences, $filter, $location, popup ) {

    $scope.creation = true;
    $scope.header = "Create ";
    $scope.conference = {
        name: null,
        country: null,
        city: null,
        address: null,
        startDate: null,
        endDate: null,
        description: null,
        capacity: null
    }

    $scope.countries = Countries;

    // day after today
    $scope.tomorrow = new Date(Date.now() + 86400000);

    $scope.citiesOnly = {
        types: ['(cities)']
    };

    $scope.addressOnly = {
        types: ['address']
    }

    $scope.calendar = {
        isOpen1: false,
        isOpen2: false
    }

    $scope.checkEndDate = function () {
        var start = new Date($scope.conference.startDate);
        var end = new Date($scope.conference.endDate);
        if (end.getTime() <= start.getTime()) {
            $scope.ccForm.endDate.$invalid = true;
        } else {
            $scope.ccForm.endDate.$invalid = false;
        }
    }

    $scope.changeCountry = function (country) {
        $scope.citiesOnly.componentRestrictions = {country: country.code};
    }

    $scope.submit = function () {
        if ($scope.ccForm.$valid) {
            var city, address, country;
            if ( $scope.conference.city ) {
                city = $scope.conference.city;
                if ( $scope.conference.city.name ) {
                    city = $scope.conference.city.name;
                }
            }

            if ( $scope.conference.country ) {
                country = $scope.conference.country;
                if ( $scope.conference.country.name ) {
                    country = $scope.conference.country.name;
                }
            }

            if ( $scope.conference.address) {
                address = $scope.conference.address;
                if ( $scope.conference.address.formatted_address ) {
                    address = $scope.conference.address.formatted_address;
                }
            }

            var conference = {
                name: $scope.conference.name,
                address: address,
                country: country,
                city: city,
                start_date: $filter('date')($scope.conference.startDate, 'yyyy-MM-dd'),
                end_date: $filter('date')($scope.conference.endDate, 'yyyy-MM-dd'),
                description: $scope.conference.description,
                capacity: $scope.conference.capacity
            }

            Conferences.fetch().save( conference )
                .$promise.then( function( response ) {
                    if ( response.status == 200 ) {
                        popup.alert('success', 'Your conference has been successfully created!')
                        $location.path('/admin');
                    } else {
                        popup.error( 'Error', response.message );
                    }
                })
        }
    }

})
