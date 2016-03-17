angular.module('manageAccountsCtrl', [])
.controller('manageAccountsController', function( $scope, $filter ) {
	
	$scope.search = null;
	$scope.selectedConference = null;
	$scope.selectedEvent = null;
	$scope.conferenceSpecific = false;
	$scope.eventSpecific = false;

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

	$scope.role = {
		name: null,
		permissions: {
			conference: {
				create: false,
				edit: false,
				delete: false
			},
			conAccommodations: {
				create: false,
				view: false,
				edit: false,
				delete: false
			},
			conAttendees: {
				create: false,
				view: false,
				edit: false,
				delete: false
			},
			conInventory: {
				create: false,
				view: false,
				edit: false,
				delete: false
			},
			conVehicles: {
				create: false,
				view: false,
				edit: false,
				delete: false
			},
			event: {
				create: false,
				edit: false,
				delete: false
			},
			eveVehicles: {
				create: false,
				view: false,
				edit: false,
				delete: false
			}
		}
	}

	$scope.changeConference = function () {
		$scope.events = $scope.conferences[$scope.selectedConference].events;
		$scope.conferenceSpecific = true;
	}

	$scope.changeEvent = function () {
		if ($scope.events) {
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

	$scope.events = null;

})