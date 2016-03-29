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



})
