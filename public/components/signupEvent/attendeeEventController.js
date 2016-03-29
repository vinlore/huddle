angular.module('attendeeEventCtrl',[])
.controller('attendeeEventController', function($scope, $stateParams, $state, ProfileAttendsEvents){

  $scope.header = "Application";


  $scope.event = {
      name: $stateParams.event_name,
  }

  $scope.arrival = {
    RideRequired: null
  }

  $scope.departure = {
    RideRequired: null
  }


  $scope.loadAttendeeProfile = function() {
    Events.attendees().query({eid: $stateParams.event_id, pid: $stateParams.profile_id})
    .$promise.then(function(response){
      if(response){
        var profile_arr = response;
        var profile = profile_arr[0].pivot;
        $scope.user = {
          profile_id: profile.profile_id,
          first_name: profile.first_name,
          last_name: profile.last_name,
          birthdate: $filter('date')(profile.birthdate, 'yyyy-MM-dd'),
          gender: profile.gender,
          arrv_ride_req: profile.arrv_ride_req,
          dept_ride_req: profile.dept_ride_req,
          status: profile.status
        };
        console.log($scope.user);
      } else {
        popup.error( 'Error', response.message );
      }
    }, function () {
      popup.connection();
    })
  };
  $scope.loadAttendeeProfile();

  $scope.submitRequest = function() {
      var profile = {
        profile_id: $scope.user.profile_id,
        first_name: $scope.user.first_name,
        last_name: $scope.user.last_name,
        birthdate: $filter('date')($scope.user.birthdate, 'yyyy-MM-dd'),
        gender: $scope.user.gender,
        country: $scope.user.country,
        city: $scope.user.city,
        arrv_ride_req: $scope.user.arrv_ride_req,
        dept_ride_req: $scope.user.dept_ride_req,
        status: 'pending'
      }
      ProfileAttendsEvents.status().update({eid: $stateParams.event_id , pid: $stateParams.profile_id}, profile)
      .$promise.then(function(response) {
        if (response.status == 200) {
          popup.alert('success', 'Event profile updated.');
          $state.go('profile');
        } else {
          popup.error('Error', response.message);
        }
      }, function() {
        popup.connection();
      });
  };

})
