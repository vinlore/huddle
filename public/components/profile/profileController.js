angular.module( 'profileCtrl', [] )
.controller( 'profileController', function ( $scope, Profile, ProfileAttendsConferences, ProfileAttendsEvents, Conferences, Events, $filter, popup, Users, $rootScope, ngTableParams ) {

    $scope.user = {};

    $scope.tableParams = new ngTableParams (
        {},
        {
            counts: [],
            getData: function($defer, params) {
                if ($rootScope.user)
                Profile.query( { uid: $rootScope.user.id } )
                    .$promise.then( function ( response ) {
                        if ( response ) {
                            for (var i=0; i < response.length; i++) {
                                response[i].birthdate = new Date(response[i].birthdate+'T00:00:00');
                                if (response[i]['is_owner'] == 1) {
                                    $scope.user = response[i];  
                                    $scope.loadConferences();
                                    $scope.loadEvents();
                                    response.splice(i, i+1);
                                }
                            }
                            $scope.family = response;
                            $defer.resolve($scope.family);
                        } else {
                            popup.error('Error', response.error);
                        }
                    }, function () {
                        popup.connection();
                    })
            }
        })

    $scope.saveNameChanges = function () {
        var profile = {
            first_name: $scope.user.FirstName,
            last_name: $scope.user.LastName,
            middle_name: $scope.user.MiddleName
        };
        Profile.update( {uid: $scope.user.user_id, pid: $scope.user.id}, profile )
            .$promise.then( function ( response ) {
                if ( response.status == 200 ) {
                    popup.alert( 'success', 'Name successfully changed.' );
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    };

    $scope.saveContactChanges = function () {
        var profile = {
            email: $scope.user.Email,
            phone: $scope.user.HomePhone
        };
        Profile.update( {uid: $scope.user.user_id, pid: $scope.user.id}, profile )
            .$promise.then( function ( response ) {
                if ( response.status == 200 ) {
                    popup.alert( 'success', 'Contact information successfully changed.' );
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    };

    $scope.saveAddressChanges = function () {
        var profile = {
            city: $scope.user.City,
            country: $scope.user.Country
        };
        Profile.update( {uid: $scope.user.user_id, pid: $scope.user.id}, profile )
            .$promise.then( function ( response ) {
                if ( response.status == 200 ) {
                    popup.alert( 'success', 'Contact information successfully changed.' );
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    };

    $scope.savePasswordChanges = function () {
        var password = {
            password: $scope.user.NewPassword
        };
        Users.update( { id: $rootScope.user.id }, password )
            .$promise.then( function ( response ) {
                if ( response.status == 200 ) {
                    popup.alert( 'success', 'Password successfully changed.' );
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    };

    $scope.deleteAccount = function () {
        Users.delete( user )
            .$promise.then( function ( response ) {
                if ( response.status == 200 ) {
                    popup.alert( 'success', 'User successfully deleted.' );
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    };

    $scope.conferences = []
    $scope.loadConferences = function () {
        ProfileAttendsConferences.fetch().query({pid: $scope.user.id})
            .$promise.then( function ( response ) {
                if ( response ) {
                    $scope.conferences = response;
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    };

    $scope.events = []
    $scope.loadEvents = function () {
        ProfileAttendsEvents.fetch().query({pid: $scope.user.id})
            .$promise.then( function ( response ) {
                if ( response ) {
                    $scope.events = response;
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    };

    $scope.newMember = {
        first_name: null,
        middle_name: null,
        last_name: null,
        birthdate: null
    }

    $scope.addMember = function () {
        var member = $scope.newMember;
        member.birthdate = $filter('date')(member.birthdate, 'yyyy-MM-dd');
        Profile.save({uid: $scope.user.user_id}, member)
            .$promise.then( function (response) {
                if (response.status == 200) {
                    popup.alert('success', 'New member successfully added.');
                    $scope.resetMember();
                    $scope.tableParams.reload();
                } else {
                    popup.error('Error', response.message);
                }
            }) 
    }

    $scope.removeMember = function (member) {
        Profile.delete({uid: $scope.user.user_id, pid: member.id})
            .$promise.then( function (response) {
                if (response.status == 200) {
                    popup.alert('success', 'Member has been successfully removed.');
                    $scope.tableParams.reload();
                } else {
                    popup.error('Error', response.message);
                }
            }) 
    }

    $scope.resetMember = function () {
        $scope.newMember = {
            first_name: null,
            middle_name: null,
            last_name: null,
            birthdate: null
        }
    }

} );
