angular.module( 'manageAccountsCtrl', [] )
    .controller( 'manageAccountsController', function ( $scope, $filter, Roles, $localStorage, $auth, popup ) {

        $scope.search = null;
        $scope.selectedConference = null;
        $scope.selectedEvent = null;
        $scope.conferenceSpecific = false;
        $scope.eventSpecific = false;

        $scope.roles = [];

        $scope.loadRoles = function () {
        	Roles.query()
        		.$promise.then( function ( response ) {
	                if ( response ) {
	                    $scope.roles = response;
	                } else {
	                    popup.error( 'Error', response.message );
	                }
	            }, function () {
	                popup.connection();
	            })
        }

        $scope.loadRoles();

        $scope.conferences = [
            {
                "conferenceId": 123,
                "name": "India Conference",
                "events": [
                    {
                        "eventId": 1,
                        "name": "Event1"
			    },
                    {
                        "eventId": 2,
                        "name": "Event2"
			    },
                    {
                        "eventId": 3,
                        "name": "Event3"
			    }
			]
	    },
            {
                "conferenceId": 234,
                "name": "Canada Conference"
	    },
            {
                "conferenceId": 987,
                "name": "France Conference"
	    },
            {
                "conferenceId": 1,
                "name": "USA Conference"
	    }
	];

        $scope.accounts = [
            {
                username: "BobTheBuilder",
                firstName: "Bob",
                lastName: "Builder",
                permissions: {
                    admin: true,
                    conference: true,
                    conferenceEdit: true,
                    conferenceAccommodation: true,
                    conferenceTransport: true,
                    conferenceAttendee: true,
                    conferenceInventory: true,
                    event: true,
                    eventEdit: true,
                    eventTransport: true,
                    eventAttendee: true,
                }
		},
            {
                username: "Batman",
                firstName: "Bruce",
                lastName: "Wayne",
                permissions: {
                    admin: false,
                    conference: false,
                    conferenceEdit: true,
                    conferenceAccommodation: false,
                    conferenceTransport: false,
                    conferenceAttendee: false,
                    conferenceInventory: true,
                    event: false,
                    eventEdit: false,
                    eventTransport: false,
                    eventAttendee: false,
                }
		}
	]

        $scope.newRole = {
            name: null,
            permissions: {
                "conference.status": false,
                "conference.store": false,
                "conference.show": false,
                "conference.update": false,
                "conference.destroy": false,
                "user.update": false,
                "role.store": false,
                "role.update": false,
                "role.destroy": false,
                "event.store": false,
                "event.show": false,
                "event.update": false,
                "event.status": false,
                "event.destroy": false,
                "conferenceAttendees.show": false,
                "conferenceAttendees.update": false,
                "conferenceAttendees.destroy": false,
                "eventAttendees.show": false,
                "eventAttendees.update": false,
                "eventAttendees.destroy": false,
                "profile.show": false,
                "profile.update": false,
                "profile.destroy": false,
                "conferenceVehicles.store": false,
                "conferenceVehicles.show": false,
                "conferenceVehicles.update": false,
                "conferenceVehicles.destroy": false,
                "eventVehicles.store": false,
                "eventVehicles.show": false,
                "eventVehicle.update": false,
                "eventVehicle.destroy": false,
                "accommodations.store": false,
                "accommodations.show": false,
                "accommodations.update": false,
                "accommodations.destroy": false
            }
        }

        $scope.changeConference = function () {
            $scope.events = $scope.conferences[ $scope.selectedConference ].events;
            $scope.conferenceSpecific = true;
        }

        $scope.changeEvent = function () {
            if ( $scope.events ) {
                $scope.eventSpecific = true;
            } else {
                $scope.eventSpecific = false;
            }
        }

        $scope.reset = function () {
            $scope.search = null;
            $scope.selectedConference = null;
            $scope.selectedEvent = null;
            $scope.events = null;
            $scope.conferenceSpecific = false;
            $scope.eventSpecific = false;
        }

        $scope.createRole = function () {
        	var newRole = $scope.newRole;
            Roles.save( newRole )
	            .$promise.then( function ( response ) {
	                if ( response.status == 'success' ) {
	                    // TODO success alert
	                } else {
	                    popup.error( 'Error', response.message );
	                }
	            }, function () {
	                popup.connection();
	            })
        }

        $scope.deleteRole = function ( id ) {
        	Roles.delete( {id: id} )
        		.$promise.then( function ( response ) {
	                if ( response.status == 'success' ) {
	                    // TODO success alert
	                } else {
	                    popup.error( 'Error', response.message );
	                }
	            }, function () {
	                popup.connection();
	            })
        }

        $scope.events = null;

    } )
