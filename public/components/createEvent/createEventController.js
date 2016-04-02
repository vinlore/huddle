angular.module( 'createEventCtrl', [])
.controller( 'createEventController', function( $scope, Countries, Events, $stateParams, $filter, $location, popup, $state ) {
    $scope.header = "Create ";
    $scope.event = {
        conference_id: $stateParams.conferenceId,
        name: null,
        description: null,
        facilitator: null,
        date: null,
        start_time: null,
        end_time: null,
        address: null,
        city: null,
        country: null,
        age_limit: null,
        gender_limit: null,
        description: null,
        capacity: null
    }
    $scope.creation = true;

    $scope.countries = Countries;

    $scope.changeCountry = function (country) {
        $scope.citiesOnly.componentRestrictions = {country: country.code};
    }

    $scope.citiesOnly = {
        types: ['(cities)']
    };

    $scope.addressOnly = {
        types: ['address']
    }

    $scope.calendar = {
        isOpen1: false
    };

    $scope.submit = function () {
        var city, address, country;
        if ( $scope.event.city ) {
            city = $scope.event.city;
            if ( $scope.event.city.name ) {
                city = $scope.event.city.name;
            }
        }

        if ( $scope.event.country ) {
            country = $scope.event.country;
            if ( $scope.event.country.name ) {
                country = $scope.event.country.name;
            }
        }

        if ( $scope.event.address) {
            address = $scope.event.address;
            if ( $scope.event.address.formatted_address ) {
                address = $scope.event.address.formatted_address;
            }
        }

        var _event = {
          conference_id: $scope.event.conference_id,
          name: $scope.event.name,
          description: $scope.event.description,
          facilitator: $scope.event.facilitator,
          date: $filter('date')($scope.event.date, 'yyyy-MM-dd'),
          start_time: $filter('date')($scope.event.start_time, 'HH:mm'),
          end_time: $filter('date')($scope.event.end_time, 'HH:mm'),
          address: address,
          city: city,
          country: country,
          age_limit: $scope.event.age_limit,
          gender_limit: $scope.event.gender_limit,
          capacity: $scope.event.capacity
        }

        Events.fetch().save( { cid: _event.conference_id }, _event )
            .$promise.then( function( response ) {
                if ( response.status == 200 ) {
                    popup.alert('success', 'Event has been created for approval!');
                    $location.url('/admin');
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }

})
