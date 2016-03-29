angular.module( 'profileCtrl', [] )
.controller( 'profileController', function ( $scope, Profile, ProfileAttendsConferences, ProfileAttendsEvents, Conferences, Events, $filter, popup, Users, $rootScope, $state, ngTableParams ) {


    $scope.user = {};
    $scope.animationsEnabled = true;

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
                                if (response[i]['is_owner']) {
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
            first_name: $scope.user.first_name,
            last_name: $scope.user.last_name,
            middle_name: $scope.user.middle_name
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
            email: $scope.user.email,
            phone: $scope.user.phone
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
            city: $scope.user.city,
            country: $scope.user.country
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
            password: $scope.user.new_password
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

    $scope.loadProfile = function () {
        Profile.query( { uid: $rootScope.user.id } )
            .$promise.then( function ( response ) {
                if ( response ) {
                    var profile = response[0];
                    $scope.user = {
                        id: profile.id,
                        first_name: profile.first_name,
                        middle_name: profile.middle_name,
                        last_name: profile.last_name,
                        birthdate: new Date(profile.birthdate),
                        gender: profile.gender,
                        country: profile.country,
                        city: profile.city,
                        email: profile.email,
                        phone: profile.phone
                    };
                    $scope.loadConferences();
                    $scope.loadEvents();
                } else {
                    popup.error('Error', response.error);
                }
            }, function () {
                popup.connection();
            })
    }
    $scope.loadProfile();

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
                    //console.log(response);
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

    $scope.cancelConferenceApplication = function(index){
          var conference = {
            id: $scope.conferences[index].id
          }
        //console.log($scope.conferences);
        ProfileAttendsConferences.status().update({cid: conference.id , pid: $scope.user.id},{status: 'cancelled'})
          .$promise.then( function (response) {
              if ( response.status == 200 ) {
                  $scope.loadConferences()
                  popup.alert( 'success', 'Conference application cancelled' );
              } else {
                  popup.error( 'Error', response.message );
              }
          }, function () {
              popup.connection();
          })
    };

    $scope.viewConferenceApplication = function(index){
      var conference = {
        pid: $scope.conferences[index].pivot.profile_id,
        cid: $scope.conferences[index].pivot.conference_id,
        name: $scope.conferences[index].name,
      }
      $state.go('attendee-conference-profile', {conference_name: conference.name,
                                                conference_id: conference.cid,
                                                profile_id: conference.pid
                                              });
    };

    $scope.viewEventApplication = function(index){
      var _event = {
        pid: $scope.events[index].pivot.profile_id,
        eid: $scope.events[index].pivot.event_id,
        name: $scope.events[index].name
      }
      $state.go('attendee-event-profile', {event_name: _event.name,
                                            event_id: _event.cid,
                                            profile_id: _event.pid
                                          });
    };
})
