angular.module('signupEventCtrl',[])
.controller('signupEventController', function($scope, $stateParams, Profile, Events, popup, $state, $rootScope){

  $scope.header = "Sign Up";

  $scope.event = {
      name: $stateParams.name,
      id: $stateParams.eventId,
      conference_id: $stateParams.conferenceId
  }

  $scope.attendee = {
    arrv_ride_req: false,
    dept_ride_req: false,
  }

  var calcAge = function(date) {
    var today = new Date();
    var birthdate = date;
    var age = today.getFullYear() - birthdate.getFullYear();
    var m = today.getMonth() - birthdate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthdate.getDate())) {
        age--;
    }
    return age;
  }

  var createDate = function (date) {
      if (date) {
          var input = date.split('-');
          return new Date(parseInt(input[0]), parseInt(input[1])-1, parseInt(input[2]));
      } else {
          return null;
      }
  }

  $scope.loadProfile = function(){
  Profile.query( { uid: $rootScope.user.id } )
      .$promise.then( function ( response ) {
          if ( response ) {
            $scope.profile = response[0];
            $scope.age = calcAge(createDate($scope.profile.birthdate));

          } else {
              popup.error('Error', response.error);
          }
      }, function () {
          popup.connection();
      })
    }
    $scope.loadProfile();

    $scope.loadEvent = function(){
      Events.fetch().get( { cid: $stateParams.conferenceId, eid: $stateParams.eventId} )
          .$promise.then( function( response ) {
              if ( response ) {
                  $scope.event = response;

              } else {
                  popup.error( 'Error', response.message );
              }
          })
    }
    $scope.loadEvent();

    $scope.submitRequest = function () {
        if ( $scope.age >= $scope.event.age_limit ){
          $scope.submitRequestApplication();
        } else {
          var warningMessage = 'Unable to signup for '+ $scope.event.name +' Event. You do not meet the age limit of ' + $scope.event.age_limit + '+.'
          var modalInstance = popup.warning('Event Signup', warningMessage);
          modalInstance.result.then( function ( result ) {
            if (result) {
              $state.go('conference', {conferenceId: $scope.event.conference_id});
            }
          })
      }
    };

  $scope.submitRequestApplication = function() {
          var profile = {
            profile_id: $rootScope.user.profile_id,
            arrv_ride_req: $scope.attendee.arrv_ride_req,
            dept_ride_req: $scope.attendee.dept_ride_req,
            status: 'pending'
          }
          Events.attendees().save({ eid: $scope.event.id}, profile)
              .$promise.then(function(response) {
                  if (response.status == 200) {
                      popup.alert('success', 'You have been successfully signed up for approval to attend this event.');
                      $state.go('home');
                  } else {
                      popup.error('Error', response.message);
                  }
              }, function() {
                  popup.connection();
              });
      };
})
