angular.module('signupEventCtrl',[])
.controller('signupEventController', function($scope, $stateParams, Events, popup, $state, $rootScope){

  $scope.header = "Sign Up";

  $scope.event = {
      name: $stateParams.name,
      id: $stateParams.eventId
  }

  $scope.attendee = {
    arrv_ride_req: true,
    dept_ride_req: null,
    status: 'pending'
  }

  $scope.submitRequest = function() {
          var profile = {
            arrv_ride_req: attendee.arrv_ride_req,
            dept_ride_req: attendee.dept_ride_req,
            id: event.id,
            profile_id: $rootScope.user.id,
          }
          Events.attendees().save({ eid: profile.id, pid: profile.profile_id}, profile)
              .$promise.then(function(response) {
                  if (response.status == 200) {
                      popup.alert('success', 'You have been successfully signed up for approval to attend this event.');
                      $state.go('/');
                  } else {
                      popup.error('Error', response.message);
                  }
              }, function() {
                  popup.connection();
              });
      };

})
