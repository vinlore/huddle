angular.module('signupConfCtrl',[])
.controller('signupConferenceController', function($scope){

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

  $scope.emergencyContact = {
    FirstName: null,
    MiddleName: null,
    LastName: null,
    PhoneNumber: null,
    Email: null
  }

  $scope.conference = {
      name: "Indian Conference",
      country: null,
      city: null,
      address: null,
      startDate: null,
      endDate: null,
      description: null
  }

  $scope.arrival = {
    RideRequired: null,
    AirlineNumber: null,
    Airport: null,
    ArrivalDate: null,
    ArrivalTime: null
  }

  $scope.departure = {
    RideRequired: null,
    AirlineNumber: null,
    Airport: null,
    DepartureDate: null,
    DepartureTime: null
  }

  $scope.accommodation = {
    type: null,
  }

  $scope.medical = {
    Condition: null,
  }

  $scope.familymembers = [
    {
      id : 'member1',
      FirstName: null,
      MiddleName: null,
      LastName: null,
      Age: null,
      Gender: null,
      Country: null,
      City: null,
    }
  ]

  $scope.addFamilyMember = function () {
    var newFamMem = $scope.familymembers.length + 1;
    $scope.familymembers.push({'id':'member'+newFamMem});
  }

  $scope.removeFamilyMember = function (index) {
    $scope.familymembers.splice(index, 1);
  }

  $scope.submitRequest = function () {

  }

})
