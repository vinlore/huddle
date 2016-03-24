angular.module( 'manageAccountsCtrl', [] )
.controller( 'manageAccountsController', function ( $scope, $filter, Roles, popup, Users, ngTableParams ) {

    $scope.search = null;
    $scope.selectedConference = null;
    $scope.selectedEvent = null;
    $scope.conferenceSpecific = false;
    $scope.eventSpecific = false;

    $scope.selectedRole = [];

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

    $scope.tableParams = new ngTableParams(
        {
            page: 1,
            count: 10
        },
        {
            total: 0,
            getData: function($defer, params) {
                Users.query().$promise.then( function (response) {
                    if (response) {
                        $scope.users = response;
                        params.total(response.length);
                        $defer.resolve(response);
                    }
                })
            }
        }
    )

    $scope.users = [];

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

    $scope.newRole = {
        name: null,
        permissions: {
            "conference.status": false,
            "conference.store": false,
            "conference.show": false,
            "conference.update": false,
            "conference.destroy": false,
            "user.show": false,
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

    $scope.givePermissions = function (role, user) {
        user.permissions = role.permissions;
    }

    $scope.createRole = function () {
    	var newRole = $scope.newRole;
        Roles.save( newRole )
            .$promise.then( function ( response ) {
                if ( response.status == 'success' ) {
                    popup.alert( 'success', 'Role successfully added.' );
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.updateRole = function ( role ) {
    	var updateRole = {
    		name: role.name,
    		permissions: role.permissions
    	}
    	Roles.update( {id: role.id}, updateRole )
    		.$promise.then( function ( response ) {
    			if ( response.status == 'success' ) {
    				popup.alert( 'success', 'Role successfully updated.' );
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
                    popup.alert( 'success', 'Role successfully deleted.' );
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.updateUserRole = function ( user, role ) {
        var updateUser = {
            role_id: role,
            permissions: user.permissions
        }
        var modalInstance = popup.prompt("Updating User" , "Are you sure you want to update " + user.username + "'s permissions?");

        modalInstance.result.then( function ( result ) {
            if ( result ) {
                Users.update( {id: user.id}, updateUser )
                    .$promise.then( function ( response ) {
                        if ( response.status == 'success' ) {
                            popup.alert( 'success', 'User\'s permissions have been changed.' );
                        } else {
                            popup.error( 'Error', response.message );
                        }
                    }, function () {
                        popup.connection();
                    })
            }
        } )
    	
    }

    $scope.deleteUser = function ( user ) {
    	Users.delete( user )
    		.$promise.then( function ( response ) {
    			if ( response.status == 'success' ) {
    				popup.alert( 'success', 'User successfully deleted.' );
    			} else {
    				popup.error( 'Error', response.message );
    			}
    		}, function () {
    			popup.connection();
    		})
    }

    $scope.events = null;

} )
