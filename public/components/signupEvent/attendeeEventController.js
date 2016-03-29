angular.module('attendeeEventCtrl',[])
.controller('attendeeEventController', function($scope, $stateParams, $state, ProfileAttendsEvents, Events, Countries){

  $scope.header = "Application";
  $scope.countries = Countries;

  $scope.event = {
      event_id: $stateParams.event_id,
      name: $stateParams.event_name
  }

  $scope.loadAttendeeProfile = function() {
    Events.attendees().get({eid: $stateParams.event_id, pid: $stateParams.profile_id})
    .$promise.then(function(response){
      if(response){
        var profile = response;
        /*$scope.user = {
          profile_id: profile.profile_id,
          first_name: profile.first_name,
          last_name: profile.last_name,
          birthdate: $filter('date')(profile.birthdate, 'yyyy-MM-dd'),
          gender: profile.gender,
          arrv_ride_req: profile.arrv_ride_req,
          dept_ride_req: profile.dept_ride_req,
          status: profile.status
        };*/
        console.log($scope.user);
      } else {
        popup.error( 'Error', response.message );
      }
    }, function () {
      popup.connection();
    })
  };
  $scope.loadAttendeeProfile();

})
