angular.module( 'profileCtrl', [] )
.controller( 'profileController', function ( $scope, Profile, ProfileAttendsConferences, ProfileAttendsEvents, Conferences, Events, $filter, popup, Users, $rootScope, $state ) {

    $scope.user = {};
    $scope.animationsEnabled = true;

    $scope.saveNameChanges = function () {
        var profile = {
            first_name: $scope.user.FirstName,
            last_name: $scope.user.LastName,
            middle_name: $scope.user.MiddleName
        };
        Profile.update( {uid: $rootScope.user.id, pid: $scope.user.id}, profile )
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
        Profile.update( {uid: $rootScope.user.id, pid: $scope.user.id}, profile )
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
        Profile.update( {uid: $rootScope.user.id, pid: $scope.user.id}, profile )
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

    $scope.loadProfile = function () {
        Profile.get( { uid: $rootScope.user.id } )
            .$promise.then( function ( response ) {
                if ( response ) {
                    var profile = response;
                    $scope.user = {
                        id: profile.id,
                        Username: $rootScope.user.name,
                        OldPassword: null,
                        NewPassword: null,
                        ConfirmPassword: null,
                        FirstName: profile.first_name,
                        MiddleName: profile.middle_name,
                        LastName: profile.last_name,
                        Birthdate: new Date(profile.birthdate),
                        Gender: profile.gender,
                        Country: profile.country,
                        City: profile.city,
                        Email: profile.email,
                        HomePhone: profile.phone
                    };
                    $scope.loadConferences();
                    $scope.loadEvents();
                    //console.log($scope.conferences[0].pivot);
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
                    console.log($scope.events);
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    };

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
