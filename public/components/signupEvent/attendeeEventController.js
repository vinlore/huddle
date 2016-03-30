angular.module('attendeeEventCtrl',[])
.controller('attendeeEventController', function($scope, $stateParams, $state, ProfileAttendsEvents, Events, popup){

  $scope.header = "Application";
  $scope.event = {
      event_id: $stateParams.event_id,
      name: $stateParams.event_name
  }
  console.log($scope.event.event_id);

  $scope.loadAttendeeProfile = function() {
    Events.attendees().get({eid: $stateParams.event_id, pid: $stateParams.profile_id})
    .$promise.then(function(response){
      if(response){
        var profile = response.pivot;
        $scope.attendee = {
          arrv_ride_req: profile.arrv_ride_req,
          dept_ride_req: profile.dept_ride_req
        }
        console.log(response);
      } else {
        popup.error( 'Error', response.message );
      }
    }, function () {
      popup.connection();
    })
  };
  $scope.loadAttendeeProfile();

  $scope.submitRequest = function(){
      var attendee = {
        arrv_ride_req: $scope.attendee.arrv_ride_req,
        dept_ride_req: $scope.attendee.dept_ride_req,
        status:'pending'
      }
      Events.attendees().update({eid: $stateParams.event_id, pid: $stateParams.profile_id}, attendee)
      .$promise.then( function ( response ) {
        if ( response ) {
            $state.go('profile');
            popup.alert( 'success', "Event profile successfully updated" );
        } else {
            popup.error( 'Error', response.message );
        }
    }, function () {
        popup.connection();
    })
  };

})
