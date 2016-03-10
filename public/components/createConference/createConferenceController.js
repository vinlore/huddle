angular.module( 'createConferenceCtrl', [])
.controller( 'createConferenceController', function( $scope, Countries, Conferences, $filter ) {
    
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

    $scope.addItem = function() {
        var item = {
            name: null,
            num: null
        }
        $scope.items.push( item );
    }

    $scope.removeItem = function( ind ) {
        $scope.items.splice( ind, 1 );
    }

    $scope.accommodations = [
        {
            name: null,
            address: null,
            rooms: [
                {
                    name: null,
                    capacity: null
                }
            ]
        }
    ]

    $scope.addAccommodation = function() {
        var accommodation = {
            name: null,
            address: null,
            rooms: [
                {
                    name: null,
                    capacity: null
                }
            ]
        }
        $scope.accommodations.push( accommodation );
    }

    $scope.removeAccommodation = function( ind ) {
        $scope.accommodations.splice( ind, 1 );
    }

    $scope.addRoom = function( ind ) {
        var room = {
            name: null,
            capacity: null
        }
        $scope.accommodations[ind].rooms.push( room );
    }

    $scope.removeRoom = function( ind, ind2 ) {
        $scope.accommodations[ind].rooms.splice( ind2, 1 );
    }

    $scope.arrTransport = [
        {
            name: null,
            capacity: null
        }
    ]

    $scope.addArrival = function() {
        var item = {
            name: null,
            capacity: null
        }
        $scope.arrTransport.push( item );
    }

    $scope.removeArrival = function( ind ) {
        $scope.arrTransport.splice( ind, 1 );
    }

    $scope.depTransport = [
        {
            name: null,
            capacity: null
        }
    ]

    $scope.addDeparture = function() {
        var item = {
            name: null,
            capacity: null
        }
        $scope.depTransport.push( item );
    }

    $scope.removeDeparture = function( ind ) {
        $scope.depTransport.splice( ind, 1 );
    }

    $scope.submit = function () {
        var conference = {
            conference: {
                name: $scope.conference.name,
                address: $scope.conference.address,
                country: $scope.conference.country,
                city: $scope.conference.city.formatted_address,
                startDate: $filter('date')($scope.conference.startDate, 'yyyy-MM-dd'),
                endDate: $filter('date')($scope.conference.endDate, 'yyyy-MM-dd'),
                description: $scope.conference.description,
                capacity: $scope.conference.capacity
            }
        }

        Conferences.save( conference )
            .$promise.then( function( response ) {
                if ( response.status == 'success' ) {
                    console.log( 'Conference request successfully made' );
                } else {
                    console.log( 'Error' + response.code + response.message );
                }
            })
    }

})