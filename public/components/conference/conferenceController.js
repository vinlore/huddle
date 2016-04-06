angular.module( 'conferenceCtrl', [] )
.controller( 'conferenceController', function( $scope, $filter, Conferences, Gmap, $stateParams, $resource, popup, Events, $rootScope, checkPermission ) {

    $scope.citiesOnly = {
        types: ['(cities)']
    };

    $scope.checkPermission = function(permission, thing, id) {
        return checkPermission(permission, thing, id);
    }

    $scope.conference = {};

    $scope.loadConference = function () {
        Conferences.fetch().get( {cid: $stateParams.conferenceId} )
            .$promise.then( function( response ) {
                if ( response ) {
                    var date1 = response.start_date.split('-');
                    response.startDate = new Date(parseInt(date1[0]), parseInt(date1[1])-1, parseInt(date1[2]));
                    var date2 = response.end_date.split('-');
                    response.endDate = new Date(parseInt(date2[0]), parseInt(date2[1])-1, parseInt(date2[2]));
                    $scope.conference = response;
                    $scope.background = 'assets/img/' + $scope.conference.country + '/big/' + $filter( 'randomize' )( 3 ) + '.jpg';
                } else {
                    popup.error( 'Error', response.message );
                }
            } )
    }

    $scope.loadConference();

    var conferenceBackup = {};

    $scope.attendanceLoaded = false; // hide sign up button while conference attendance is loading
    $scope.attendanceLoaded2 = false; // hide sign up button while event attendance is loading

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
            start_time: $filter('date')($scope.events[$index].start_time, 'HH:mm'),
            end_time: $filter('date')($scope.events[$index].end_time, 'HH:mm'),
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
            })
    };

    // Restores from conference backup if changes do not want to be saved to server
    $scope.reset = function() {
        $scope.conference = conferenceBackup;
        $scope.editConference = false;
        conferenceBackup = {};
    }


    $scope.loadEvents = function () {
        Conferences.events().query( {cid: $stateParams.conferenceId, status: 'approved'} )
            .$promise.then( function( response ) {
                if ( response ) {
                    for (var i = 0; i < response.length; i++) {
                        var date = response[i].date.split('-');
                        response[i].date = new Date(parseInt(date[0]), parseInt(date[1])-1, parseInt(date[2]));

                        // Parse start time from database to Date object
                        var time1 = response[i].start_time.split(':');
                        var startTime = new Date();
                        startTime.setHours(time1[0]);
                        startTime.setMinutes(time1[1]);
                        response[i].start_time = startTime;

                        // Parse end time from database to Date object
                        var time2 = response[i].end_time.split(':');
                        var endTime = new Date();
                        endTime.setHours(time2[0]);
                        endTime.setMinutes(time2[1]);
                        response[i].end_time = endTime;

                        $scope.checkEventAttendance(response[i].id, i);
                    }
                    $scope.events = response;
                } else {
                    popup.error( 'Error', response.message );
                }
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
            })
    }

    $scope.loadDepartVehicles();

    $scope.checkConferenceAttendance = function () {
        if ($rootScope.user)
        Conferences.attendees().get({cid: $stateParams.conferenceId, pid: $rootScope.user.profile_id})
            .$promise.then( function (response) {
                $scope.attendanceLoaded = true;
                if (response.pivot) {
                    $scope.conferenceAttendance = response.pivot.status;
                } else {
                    $scope.conferenceAttendance = null;
                }
            }, function () {
                $scope.attendanceLoaded = true;
            })
    }

    $scope.checkConferenceAttendance();

    $scope.eventAttendance = [];

    $scope.checkEventAttendance = function (eid, ind) {
        if ($rootScope.user)
        Events.attendees().get({eid: eid, pid: $rootScope.user.profile_id})
            .$promise.then( function (response) {
                $scope.attendanceLoaded2 = true;
                if (response.pivot) {
                    $scope.eventAttendance[ind] = response.pivot.status;
                } else {
                    $scope.eventAttendance[ind] = null;
                }
            }, function () {
                $scope.eventAttendance = null;
            })
    }

    $scope.leaveConference = function () {
        Conferences.attendees().delete({cid: $stateParams.conferenceId, pid: $rootScope.user.profile_id})
            .$promise.then(function (response) {
                if (response.status == 200) {
                    popup.alert('success', 'You are no longer attending this conference.');
                    $scope.checkConferenceAttendance();
                }
            })
    }

    $scope.leaveEvent = function (eid) {
        Events.attendees().delete({eid: eid, pid: $rootScope.user.profile_id})
            .$promise.then(function (response) {
                if (response.status == 200) {
                    popup.alert('success', 'You are no longer attending this event.');
                    $scope.checkConferenceAttendance();
                }
            })
    }
})
