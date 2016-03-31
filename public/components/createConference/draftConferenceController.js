angular.module( 'draftConferenceCtrl', [])
.controller( 'draftConferenceController', function( $stateParams, $scope, Countries, Conferences, $filter, $location, popup ) {
    $scope.header = "Draft";
    $scope.creation = false;
    $scope.draft = true;

    $scope.countries = Countries;

    $scope.citiesOnly = {
        types: ['(cities)']
    };

    $scope.addressOnly = {
        types: ['address']
    }

    $scope.calendar = {
        isOpen1: false,
        isOpen2: false
    };

    $scope.items = [
        {
            name: null,
            num: null
        }
    ]

    $scope.changeCountry = function (country) {
        $scope.citiesOnly.componentRestrictions = {country: country.code};
    }

    $scope.loadConference = function () {
        Conferences.fetch().get({cid: $stateParams.conference_id})
            .$promise.then( function( response ) {
                if ( response ) {
                    $scope.conference = response;
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            } )
    }
    $scope.loadConference();

    $scope.submit = function () {
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
            capacity: $scope.conference.capacity,
            attendee_count: 0
        }

        Conferences.fetch().update( {cid: $scope.conference.conference_id}, conference)
            .$promise.then( function( response ) {
                if ( response.status == 200 ) {
                    $state.go('admin');
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }

})
