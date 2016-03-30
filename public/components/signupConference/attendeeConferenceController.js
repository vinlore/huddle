var app = angular.module('attendeeConfCtrl', []);
app.controller('attendeeConferenceController', function($scope, $stateParams, Conferences, Countries, Profile, popup, $rootScope, $filter, $state) {

  $scope.calendar = {
    isOpen1: false,
    isOpen2: false,
    isOpen3: false
  };

  $scope.accordionIsOpen = [];
  $scope.countries = Countries;
  $scope.header = "Application";

  $scope.conference = {
      conference_id: $stateParams.conference_id,
      name: $stateParams.conference_name
  }
  $scope.user = {}

  $scope.loadAttendeeProfile = function() {
    Conferences.attendees().get({cid: $stateParams.conference_id, pid: $stateParams.profile_id})
    .$promise.then(function(response){
      if(response){
        var profile = response.pivot;
        $scope.user = profile;
        console.log(profile);
      } else {
        popup.error( 'Error', response.message );
      }
    }, function () {
      popup.connection();
    })
  };
  $scope.loadAttendeeProfile();

  $scope.submitRequest = function(){
      $scope.user.status = 'pending';
      Conferences.attendees().update({cid: $stateParams.conference_id, pid: $stateParams.profile_id}, $scope.user)
      .$promise.then( function ( response ) {
        if ( response ) {
            $state.go('profile');
            popup.alert( 'success', "Conference profile successfully updated" );
        } else {
            popup.error( 'Error', response.message );
        }
    }, function () {
        popup.connection();
    })
  };

})
