angular.module( 'conferenceCtrl', [] )
.controller( 'conferenceController', function( $scope, $filter, Conferences, Gmap, $stateParams, $resource, popup, Events ) {

    $scope.citiesOnly = {
        types: ['(cities)']
    };

    $scope.conference = {};

    $scope.loadConference = function () {
        Conferences.fetch().get( {cid: $stateParams.conferenceId} )
            .$promise.then( function( response ) {
                if ( response ) {
                    var conf = response;
                    conf.startDate = new Date( conf.start_date );
                    conf.endDate = new Date( conf.end_date );
                    $scope.conference = conf;
                    $scope.background = 'assets/img/' + $scope.conference.country + '/big/' + $filter( 'randomize' )( 3 ) + '.jpg';
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            } )
    }

    $scope.loadConference();

    var conferenceBackup = {};

    $scope.background = { 'background-image': 'url(assets/img/overlay.png), url(assets/img/' + $scope.conference.country + '/big/' + $filter( 'randomize' )( 3 ) + '.jpg)' };

    $scope.inventory = [
        {
            name: "Water"
        },
        {
            name: "Toothbrush"
        },
        {
            name: "Towel"
        }
    ]

    $scope.arrivalTransport = [
        {
            vehicleId: 123,
            name: "Bus",
            passengerCount: 30,
            capacity: 40
        }
    ]

    $scope.departureTransport = [
        {
            vehicleId: 323,
            name: "Car",
            passengerCount: 2,
            capacity: 4
        }
    ]

    $scope.accommodations = [
        {
            accommodationsId: 123,
            name: "Some dude's house",
            address: "1234 Fake street",
            rooms: [
                {
                    roomId: 134,
                    room_no: 1,
                    capacity: 4
                },
                {
                    roomId: 135,
                    room_no: 2,
                    capacity: 3
                }
            ]
        }
    ]

    $scope.events = []
    var eventBackup = {};

    $scope.editEvent = [];

    $scope.editEvent = function ( event, $index, e ) {
        e.preventDefault();
        e.stopPropagation();
        $scope.editEvent[$index] = true;
        angular.extend( eventBackup, event );
    }

    $scope.resetEvent = function( event, $index, e ) {
        e.preventDefault();
        e.stopPropagation();
        $scope.events[$index] = eventBackup;
        $scope.editEvent[$index] = false;
        eventBackup = {};
    }

    $scope.updateEvent = function ( event, $index, e ) {
        e.preventDefault();
        e.stopPropagation();
        $scope.editEvent[$index] = false;
        eventBackup = {};
        saveEvent($index);
    }

    var saveEvent = function ( $index ) {
        var address, city;
        if ( $scope.events[$index].address) {
            address = $scope.events[$index].address;
            if ( $scope.events[$index].address.formatted_address ) {
                address = $scope.events[$index].address.formatted_address;
            }
        }
        if ( $scope.events[$index].city ) {
            city = $scope.events[$index].city;
            if ( $scope.events[$index].city.name ) {
                city = $scope.events[$index].city.name;
            }
        }

        var eventDetails = {
            name: $scope.events[$index].name,
            date: $filter('date')($scope.events[$index].startDate, 'yyyy-MM-dd'),
            address: address,
            description: $scope.events[$index].description,
            capacity: $scope.events[$index].capacity,
            city: city,
            capacity: $scope.events[$index].capacity,
            age_limit: $scope.events[$index].ageLimit,
            gender_limit: $scope.events[$index].genderLimit,
            facilitator: $scope.events[$index].facilitator
        }
        Event.fetch().update( {cid: $stateParams.conferenceId, eid: $scope.event[index].eventId}, eventDetails )
            .$promise.then( function( response ) {
                if ( response.status == 'success' ) {
                    console.log( 'Changes saved to conference' );
                    // TODO success alert
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.calendar = {
        isOpen1: false,
        isOpen2: false
    };

    $scope.eventCalendar = [];

    $scope.editConference = false;

    // Makes conference fields editable and creates a 'backup' of the conference data
    $scope.edit = function() {
        $scope.editConference = true;
        angular.extend( conferenceBackup, $scope.conference );
    }

    // Saves any conference changes to server
    $scope.update = function() {
        var confDetails = {
            name: $scope.conference.name,
            start_date: $filter('date')($scope.conference.startDate, 'yyyy-MM-dd'),
            end_date: $filter('date')($scope.conference.endDate, 'yyyy-MM-dd'),
            address: $scope.conference.address,
            description: $scope.conference.description,
            capacity: $scope.conference.capacity,
            city: $scope.conference.city,
            country: $scope.conference.country
        }
        Conferences.fetch().update( {cid: $stateParams.conferenceId}, confDetails )
            .$promise.then( function( response ) {
                if ( response.status == 'success' ) {
                    console.log( 'Changes saved to conference' );
                    $scope.editConference = false;
                    conferenceBackup = {};
                    popup.alert( 'success', 'Changes have been saved.' );
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    };

    // Restores from conference backup if changes do not want to be saved to server
    $scope.reset = function() {
        $scope.conference = conferenceBackup;
        $scope.editConference = false;
        conferenceBackup = {};
    }

    /*
    $scope.loadEvents = function () {
        Events.fetch().query( {cid: $stateParams.conferenceId} )
            .$promise.then( function( response ) {
                if ( response.status == 'success' && response.events ) {
                    $scope.events = response.events;
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.loadEvents();

    $scope.loadInventory = function () {
        Conferences.inventory().get( {cid: $stateParams.conferenceId} )
            .$promise.then( function( response ) {
                if ( response.status == 'success' && response.inventory ) {
                    $scope.inventory = response.inventory;
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.loadInventory();

    $scope.loadAccommodations = function () {
        Conferences.accommodations().get( {cid: $stateParams.conferenceId} )
            .$promise.then( function( response ) {
                if ( response.status == 'success' && response.accommodations ) {
                    $scope.accommodations = response.accommodations;
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.loadAccommodations();

    $scope.loadArrivalVehicles = function () {
        Conferences.vehicles().get( {cid: $stateParams.conferenceId, type: 'arrival'} )
            .$promise.then( function( response ) {
                if ( response.status == 'success' && response.vehicles ) {
                    $scope.arrivalVehicles = response.vehicles;
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.loadArrivalVehicles();

    $scope.loadDepartVehicles = function () {
        Conferences.vehicles().get( {cid: $stateParams.conferenceId, type: 'departure'} )
            .$promise.then( function( response ) {
                if ( response.status == 'success' && response.vehicles ) {
                    console.log( 'Retrieved departure vehicles' ); console.log( response.vehicles );
                    $scope.departVehicles = response.vehicles;
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.loadDepartVehicles();*/
})
