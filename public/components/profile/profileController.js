angular.module( 'profileCtrl', [] )
.controller( 'profileController', function ( $scope, Profile, ProfileAttendsConferences, ProfileAttendsEvents, ProfileRooms, ProfileConferenceVehicles, ProfileEventVehicles, Conferences, Events, $filter, popup, Users, $rootScope, $state, ngTableParams, Password ) {

    $scope.today = new Date();

    $scope.user = {};
    $scope.animationsEnabled = true;
    $scope.members = [];

    $scope.passwordPopover = [
        'AT LEAST 1 letter',
        'AT LEAST 8 characters',
        'AT LEAST 1 number',
        'NO consecutive whitespaces',
        'NO start or end with whitespace'
    ];

    $scope.tableParams = new ngTableParams (
        {},
        {
            counts: [],
            getData: function($defer, params) {
                if ($rootScope.user)
                Profile.query( { uid: $rootScope.user.id } )
                    .$promise.then( function ( response ) {
                        if ( response ) {
                            var members = [];
                            for (var i=0; i < response.length; i++) {
                                response[i].birthdate = new Date(response[i].birthdate+'T00:00:00');
                                if (response[i]['is_owner']) {
                                    response[i].phone = parseInt(response[i].phone);
                                    $scope.user = response[i];
                                    $scope.loadConferences();
                                    $scope.loadEvents();
                                } else {
                                    members.push(response[i]);
                                }
                            }
                            $defer.resolve(members);
                        } else {
                            popup.error('Error', response.error);
                        }
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
            })
    };

    $scope.savePasswordChanges = function () {
        if ($scope.user.confirm == $scope.user.password) {
            var password = {
                old_password: $scope.user.old_password,
                new_password: $scope.user.password,
                new_password_confirmation: $scope.user.confirm
            };
            Password.update().save( { uid: $rootScope.user.id }, password )
                .$promise.then( function ( response ) {
                    if ( response.status == 200 ) {
                        popup.alert( 'success', 'Password successfully changed.' );
                    } else {
                        popup.error( 'Error', response.message );
                    }
                })
        } else {
            popup.error('Error', 'Passwords do not match!');
        }
    };

    $scope.deleteAccount = function () {
        Users.delete( user )
            .$promise.then( function ( response ) {
                if ( response.status == 200 ) {
                    popup.alert( 'success', 'User successfully deleted.' );
                } else {
                    popup.error( 'Error', response.message );
                }
            })
    };


    $scope.conferences = []
    $scope.loadConferences = function () {
        ProfileAttendsConferences.fetch().query({pid: $scope.user.id})
            .$promise.then( function ( response ) {
                if ( response ) {

                    ProfileRooms.fetch().query({pid: $scope.user.id})
                        .$promise.then( function (rooms) {
                            for (var i=0; i<response.length; i++) {
                                for (var j=0; j<rooms.length; j++) {
                                    if (response[i].id == rooms[j].conference_id) {
                                        response[i].room = {no: rooms[j].room_no, accomm: rooms[j].accommodation.name};
                                    }
                                }
                            }
                        })

                    ProfileConferenceVehicles.fetch().query({pid: $scope.user.id})
                        .$promise.then( function (vehicles) {
                            for (var i=0; i<response.length; i++) {
                                for (var k=0; k<vehicles.length; k++) {
                                    if (response[i].id == vehicles[k].conference_id) {
                                        if (vehicles[k].type == 'arrival') {
                                            response[i].arrival = vehicles[k].name;
                                        } else if (vehicles[k].type == 'departure') {
                                            response[i].departure = vehicles[k].name;
                                        }
                                    }
                                }
                            }
                        })

                    $scope.conferences = response;

                } else {
                    popup.error( 'Error', response.message );
                }
            })
    };

    var createTime = function (time) {
        if (time) {
            var time1 = time.split(':');
            var result = new Date();
            result.setHours(time1[0]);
            result.setMinutes(time1[1]);
            return result;
        } else {
            return null;
        }
    }

    $scope.events = []
    $scope.loadEvents = function () {
        ProfileAttendsEvents.fetch().query({pid: $scope.user.id})
            .$promise.then( function ( response ) {
                if ( response ) {
                    for (var i=0; i < response.length; i++) {
                        response[i].start_time =  createTime(response[i].start_time);
                        response[i].end_time = createTime(response[i].end_time);
                        ProfileEventVehicles.fetch().query({pid: $scope.user.id})
                            .$promise.then( function (vehicles) {
                                for (var i=0; i<response.length; i++) {
                                    for (var k=0; k<vehicles.length; k++) {
                                        if (response[i].id == vehicles[k].event_id) {
                                            if (vehicles[k].type == 'arrival') {
                                                response[i].arrival = vehicles[k].name;
                                            } else if (vehicles[k].type == 'departure') {
                                                response[i].departure = vehicles[k].name;
                                            }
                                        }
                                    }
                                }
                            })
                    }
                    $scope.events = response;
                } else {
                    popup.error( 'Error', response.message );
                }
            })
    };

    $scope.newMember = {
        first_name: null,
        middle_name: null,
        last_name: null,
        birthdate: null,
        gender: null
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
            birthdate: null,
            gender: null
        }
    }

    $scope.memberPage = function(member){

      $state.go('member-profile', {member_pid: member.id});
    }
    $scope.cancelConferenceApplication = function (index) {
        var modalInstance = popup.prompt('Delete', 'Are you sure you want to delete your conference application?');

        modalInstance.result.then( function ( result ) {
            if (result) {
                $scope.cancelConferenceApp(index);
            }
        })
    };

    $scope.cancelConferenceApp = function(index){
          var conference = {
            id: $scope.conferences[index].id
          }
        //console.log($scope.conferences);
        Conferences.attendees().delete({cid: conference.id , pid: $scope.user.id})
          .$promise.then( function (response) {
              if ( response.status == 200 ) {
                  $scope.loadConferences();
                  popup.alert( 'success', 'Conference application deleted' );
              } else {
                  popup.error( 'Error', response.message );
              }
          })
    };

    $scope.cancelEventApplication = function (index) {
        var modalInstance = popup.prompt('Delete', 'Are you sure you want to delete your event reservation?');

        modalInstance.result.then( function ( result ) {
            if (result) {
                $scope.cancelEventApp(index);
            }
        })
    };

  $scope.cancelEventApp = function(index){
      var _event = {
        id: $scope.events[index].id,
        profile_id: $scope.events[index].pivot.profile_id
      }
      Events.attendees().delete({eid: _event.id, pid: _event.profile_id})
      .$promise.then( function (response) {
          if ( response.status == 200 ) {
              $scope.loadEvents()
              popup.alert( 'success', 'Events application deleted.' );
          } else {
              popup.error( 'Error', response.message );
          }
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
                                            event_id: _event.eid,
                                            profile_id: _event.pid
                                          });
    };
})
