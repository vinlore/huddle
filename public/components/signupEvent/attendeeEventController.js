angular.module('attendeeEventCtrl',[])
.controller('attendeeEventController', function($scope, $stateParams, $state){

  $scope.user = {
      Username: null,
      OldPassword: null,
      NewPassword: null,
      ConfirmPassword: null,
      FirstName: null,
      MiddleName: null,
      LastName: null,
      Birthdate: null,
      Gender: null,
      Country: null,
      City: null,
      Email: null,
      HomePhone: null,
      OtherPhone: null,
  };
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

  $scope.submitRequest = function () {

  }

})
