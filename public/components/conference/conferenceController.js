angular.module( 'conferenceCtrl', [] )
.controller( 'conferenceController', function( $scope, $filter, Conferences, Gmap, $stateParams, $resource, popup, Events, $rootScope   ) {

    $scope.citiesOnly = {
        types: ['(cities)']
    };

    $scope.conference = {};

    $scope.loadConference = function () {
        Conferences.fetch().get( {cid: $stateParams.conferenceId} )
            .$promise.then( function( response ) {
                if ( response ) {
                    var conf = response;
                    conf.startDate = new Date( conf.start_date+'T00:00:00' );
                    conf.endDate = new Date( conf.end_date+'T00:00:00' );
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

    $scope.inventory = []

    $scope.arrivalTransport = []

    $scope.departureTransport = []

    $scope.accommodations = []

    $scope.events = []
    var eventBackup = {};

    $scope.editEvent = [];

    $scope.editEvent = function ( event, $index, e ) {
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
            date: $filter('date')($scope.events[$index].date, 'yyyy-MM-dd'),
            address: address,
            description: $scope.events[$index].description,
            capacity: $scope.events[$index].capacity,
            start_time: $filter('time')($scope.events[$index].start_time),
            end_time: $filter('time')($scope.events[$index].end_time),
            country: $scope.events[$index].country,
            city: city,
            capacity: $scope.events[$index].capacity,
            age_limit: $scope.events[$index].age_limit,
            gender_limit: $scope.events[$index].gender_limit,
            facilitator: $scope.events[$index].facilitator
        }
        Events.fetch().update( {cid: $stateParams.conferenceId, eid: $scope.events[$index].id}, eventDetails )
            .$promise.then( function( response ) {
                if ( response.status == 200 ) {
                    $scope.editEvent[$index] = false;
                    eventBackup = {};
                    popup.alert('success', 'Changes have been saved.');
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
                if ( response.status == 200 ) {
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


    $scope.loadEvents = function () {
        Events.fetch().query( {cid: $stateParams.conferenceId} )
            .$promise.then( function( response ) {
                if ( response ) {
                    $scope.events = response;
                    for (var i = 0; i < response.length; i++) {
                        $scope.events[i].date = new Date($scope.events[i].date+'T00:00:00');
                        var time1 = $scope.events[i].start_time.split(':');
                        $scope.events[i].start_time = time1[0]+time1[1];
                        var time2 = $scope.events[i].end_time.split(':');
                        $scope.events[i].end_time = time2[0]+time2[1];
                    }
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.loadEvents();

    
    $scope.loadInventory = function () {
        Conferences.inventory().query( {cid: $stateParams.conferenceId} )
            .$promise.then( function( response ) {
                if ( response ) {
                    $scope.inventory = response;
                } else {
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.loadInventory();

    $scope.loadAccommodations = function () {
        Conferences.accommodations().query( {cid: $stateParams.conferenceId} )
            .$promise.then( function( response ) {
                if ( response ) {
                    $scope.accommodations = response;
                } else {
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.loadAccommodations();

    $scope.loadArrivalVehicles = function () {
        Conferences.vehicles().query( {cid: $stateParams.conferenceId, type: 'arrival'} )
            .$promise.then( function( response ) {
                if ( response ) {
                    $scope.arrivalVehicles = response;
                } else {
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.loadArrivalVehicles();

    $scope.loadDepartVehicles = function () {
        Conferences.vehicles().query( {cid: $stateParams.conferenceId, type: 'departure'} )
            .$promise.then( function( response ) {
                if ( response ) {
                    $scope.departVehicles = response;
                } else {
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.loadDepartVehicles();

    $scope.checkConferenceAttendance = function () {
        if ($rootScope.user)
        Conferences.attendees().query({cid: $stateParams.conferenceId, pid: $rootScope.user.id})
            .$promise.then( function (response) {
                if (response) {
                    $scope.conferenceAttendance = response['0'].pivot.status;
                } else {
                    $scope.conferenceAttendance = null;
                }
            }, function () {
                $scope.conferenceAttendance = null;
            })
    }

    $scope.checkConferenceAttendance();

    $scope.checkEventAttendance = function () {
        if ($rootScope.user)
        Events.attendees().query({cid: $stateParams.conferenceId, pid: $rootScope.user.id})
            .$promise.then( function (response) {
                if (response) {
                    $scope.eventAttendance = response['0'].pivot.status;
                } else {
                    $scope.eventAttendance = null;
                }
            }, function () {
                $scope.eventAttendance = null;
            })
    }

    //$scope.checkEventAttendance();
})
