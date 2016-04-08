angular.module( 'manageAccountsCtrl', [] )
.controller( 'manageAccountsController', function ( $scope, $filter, Roles, popup, Users, ngTableParams ) {

    $scope.search = {selectedUser: null};

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
            })
    }

    $scope.loadRoles();

    $scope.tableParams = new ngTableParams(
        {
            page: 1,
            count: 10
        },
        {
            counts: [],
            total: 0,
            getData: function($defer, params) {
                Users.get({username: $scope.search.selectedUser, page: params.page()}).$promise.then( function (response) {
                    if (response) {
                        params.total(response.total);
                        $defer.resolve(response.data);
                    }
                })
            }
        }
    )

    $scope.users = [];

    $scope.newRole = {
        name: null,
        permissions: {
            "conference.status": false,
            "conference.store": false,
            "conference.update": false,
            "conference.destroy": false,
            "role.show": false,
            "role.store": false,
            "role.update": false,
            "role.destroy": false,
            "event.store": false,
            "event.update": false,
            "event.status": false,
            "event.destroy": false,
            "conference_attendee.status": false,
            "conference_attendee.show": false,
            "conference_attendee.update": false,
            "conference_attendee.destroy": false,
            "event_attendee.status": false,
            "event_attendee.show": false,
            "event_attendee.update": false,
            "event_attendee.destroy": false,
            "item.store": false,
            "item.show": false,
            "item.update": false,
            "item.destroy": false,
            "conference_vehicle.store": false,
            "conference_vehicle.show": false,
            "conference_vehicle.update": false,
            "conference_vehicle.destroy": false,
            "event_vehicle.store": false,
            "event_vehicle.show": false,
            "event_vehicle.update": false,
            "event_vehicle.destroy": false,
            "accommodation.store": false,
            "accommodation.show": false,
            "accommodation.update": false,
            "accommodation.destroy": false,
            "room.show": false,
            "room.store": false,
            "room.update": false,
            "room.destroy": false,
            "user.show": false,
            "user.update": false,
            "user.destroy": false
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

    $scope.givePermissions = function (user) {
        var id = user.roles['0'].pivot.role_id;
        var permissions;
        for (var i = 0; i < $scope.roles.length; i++) {
            if ($scope.roles[i].id == id) {
                permissions = $scope.roles[i].permissions;
            }
        }
        user.permissions = permissions;
    }

    $scope.createRole = function () {
    	var newRole = $scope.newRole;
        Roles.save( newRole )
            .$promise.then( function ( response ) {
                if ( response.status == 200 ) {
                    popup.alert( 'success', 'Role successfully added.' );
                    $scope.loadRoles();
                } else {
                    popup.error( 'Error', response.message );
                }
            })
    }

    $scope.updateRole = function ( role ) {
    	var updateRole = {
    		name: role.name,
    		permissions: role.permissions
    	}
        var modalInstance = popup.prompt("Update Role" , "Are you sure you want to update this role's permissions?");

        modalInstance.result.then( function ( result ) {
            if (result) {
            	Roles.update( {id: role.id}, updateRole )
            		.$promise.then( function ( response ) {
            			if ( response.status == 200 ) {
            				popup.alert( 'success', 'Role successfully updated.' );
            			} else {
            				popup.error( 'Error', response.message );
            			}
            		})
            }
        })
    }

    $scope.deleteRole = function ( id ) {
        var modalInstance = popup.prompt("Delete Role" , "Are you sure you want to delete this role?");

        modalInstance.result.then( function ( result ) {
    	   if (result) {
                Roles.delete( {id: id} )
                .$promise.then( function ( response ) {
                    if ( response.status == 200 ) {
                        popup.alert( 'success', 'Role successfully deleted.' );
                        $scope.loadRoles();
                    } else {
                        popup.error( 'Error', response.message );
                    }
                })
           }
        })
    }

    $scope.updateUserRole = function ( user ) {
        var updateUser = {
            role_id: user.roles['0'].pivot.role_id,
            permissions: user.permissions
        }
        var modalInstance = popup.prompt("Update User" , "Are you sure you want to update " + user.username + "'s permissions?");

        modalInstance.result.then( function ( result ) {
            if ( result ) {
                Users.update( {id: user.id}, updateUser )
                    .$promise.then( function ( response ) {
                        if ( response.status == 200 ) {
                            popup.alert( 'success', 'User\'s permissions have been changed.' );
                        } else {
                            popup.error( 'Error', response.message );
                        }
                    })
            }
        } )

    }

    $scope.deleteUser = function ( user ) {
        var modalInstance = popup.prompt("Delete User" , "Are you sure you want to delete " + user.username + "?");

        modalInstance.result.then( function ( result ) {
    	   if (result) {
                Users.delete( user )
            		.$promise.then( function ( response ) {
            			if ( response.status == 200 ) {
            				popup.alert( 'success', 'User successfully deleted.' );
            			} else {
            				popup.error( 'Error', response.message );
            			}
            		})
            }
        })
    }

    $scope.events = null;

} )
