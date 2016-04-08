angular.module('attendeeEventCtrl',[])
.controller('attendeeEventController', function($scope, $stateParams, $state, ProfileAttendsEvents, Events, popup){

  $scope.header = "Application";
  $scope.event = {
      event_id: $stateParams.event_id,
      name: $stateParams.event_name
  }

  $scope.attendee = {};
  $scope.loadAttendeeProfile = function() {
    Events.attendees().get({eid: $stateParams.event_id, pid: $stateParams.profile_id})
    .$promise.then(function(response){
      if(response){
        $scope.attendee = response.pivot;
      } else {
        popup.error( 'Error', response.message );
      }
    })
  };
  $scope.loadAttendeeProfile();

  $scope.submitRequest = function(){
    if ( $scope.seForm.$valid ) {
      var attendee = {
        profile_id: $stateParams.profile_id,
        arrv_ride_req: $scope.attendee.arrv_ride_req,
        dept_ride_req: $scope.attendee.dept_ride_req
      }
      Events.attendees().update({eid: $stateParams.event_id, pid: $stateParams.profile_id}, attendee)
      .$promise.then( function ( response ) {
        if ( response ) {
            $state.go('profile');
            popup.alert( 'success', "Event profile successfully updated" );
        } else {
            popup.error( 'Error', response.message );
        }
      })
    }
  };

})
