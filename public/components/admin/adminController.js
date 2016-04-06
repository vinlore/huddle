angular.module('adminCtrl', [])
.controller('adminController', function($scope, $location, $log, Conferences, Events, popup, $state, checkPermissions, checkPermission) {

    $scope.conferences = [];
    $scope.events = []; // array of arrays of events
    $scope.radioModel = '';

    $scope.checkPermission = function(permission, thing, id) {
        return checkPermission(permission, thing, id);
    }

    $scope.checkPermissions = function(type, thing, id) {
        return checkPermissions(type, thing, id);
    }

	$scope.loadConferences = function () {
        Conferences.fetch().query()
            .$promise.then( function ( response ) {
                if ( response ) {
                    $scope.conferences = response;
                    for (var i=0; i<response.length; i++) {
                        $scope.loadEvents($scope.conferences[i].id, i);
                    }
                } else {
                    $scope.conferences = [];
                }
            })
    };

    $scope.loadConferences();

    $scope.loadEvents = function(cid, index) {
        Events.fetch().query( {cid: cid} )
            .$promise.then( function ( events ) {
                if ( events ) {
                    for (var i=0; i<events.length; i++) {
                        var date = events[i].date.split('-');
                        events[i].date = new Date(parseInt(date[0]), parseInt(date[1])-1, parseInt(date[2]));
                        
                        // Parse start time from database to Date object
                        var time1 = events[i].start_time.split(':');
                        var startTime = new Date();
                        startTime.setHours(time1[0]);
                        startTime.setMinutes(time1[1]);
                        events[i].start_time = startTime;

                        // Parse end time from database to Date object
                        var time2 = events[i].end_time.split(':');
                        var endTime = new Date();
                        endTime.setHours(time2[0]);
                        endTime.setMinutes(time2[1]);
                        events[i].end_time = endTime;
                    }
                    $scope.events[index] = events;
                } else {
                    $scope.events[index] = [];
                }
            })
    }

    $scope.deleteConference = function ( cid, e ) {
        e.preventDefault();
        e.stopPropagation();
        var modalInstance = popup.prompt('Delete', 'Are you sure you want to delete this conference?');

        modalInstance.result.then( function ( result ) {
            if (result) {
                Conferences.fetch().delete({cid: cid})
                    .$promise.then( function ( response ) {
                        if (response.status == 200) {
                            popup.alert('success', 'Conference successfully deleted!');
                            $scope.loadConferences();
                        } else {
                            popup.error('Error');
                        }
                    }, function () {
                        popup.connection();
                    })
            }
        })
    };

    $scope.deleteEvent = function ( cid, eid, e ) {
        e.preventDefault();
        e.stopPropagation();
        var modalInstance = popup.prompt('Delete', 'Are you sure you want to delete this event?');

        modalInstance.result.then( function ( result ) {
            if (result) {
                Events.fetch().delete({cid: cid, eid: eid})
                    .$promise.then( function ( response ) {
                        if (response.status == 200) {
                            popup.alert('success', 'Event successfully deleted!');
                            $scope.loadConferences();
                        } else {
                            popup.error('Error');
                        }
                    }, function () {
                        popup.connection();
                    })
            }
        })
    };

    show = function(events) {
    	alert("hi");
		if (events.show == false) {
			events.show = true;
		}
	}

    $scope.goConferenceManagers = function (cid, event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        $state.go('conference-managers', {conferenceId: cid});
    }

    $scope.goEventManagers = function (eid, event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        $state.go('event-managers', {eventId: eid});
    }

    $scope.goCreateEvent = function (cid, event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        $state.go('create-event', {conferenceId: cid});
    }

    $scope.goAccommodations = function(id, event){
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        $state.go('manage-accommodations', {conferenceId: id});
    }

    $scope.goConferenceAttendees = function(id, event){
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        $state.go('manage-attendees-conference', {conferenceId: id});
    }

    $scope.goEventAttendees = function(cid, eid, event){
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        $state.go('manage-attendees-event', {conferenceId: cid, eventId: eid});
    }

    $scope.goConferenceTransportation = function(id, event){
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        $state.go('manage-transportation-conference', {conferenceId: id});
    }

    $scope.goEventTransportation = function(cid, eid, event){
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        $state.go('manage-transportation-event', {conferenceId: cid, eventId: eid});
    }

	$scope.goInventory = function(id, event){
		if (event) {
				event.preventDefault();
				event.stopPropagation();
		}
		$location.url('/manage-inventory-' + id);
	}

	$scope.goReports = function(id, event){
		if (event) {
				event.preventDefault();
				event.stopPropagation();
		}
		$state.go('reports', {conferenceId: id});
	}

})
