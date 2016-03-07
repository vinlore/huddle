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
      FamilyMembers : [
        {
          FirstName: null,
          MiddleName: null,
          LastName: null,
          Birthdate: null,
          Gender: null,
          Country: null,
          City: null,
        }
      ]
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

  $scope.addFamilyMember = function () {
    var member = {

    }
    user.FamilyMembers.push(member);
  }

  $scope.submitRequest = function () {

  };

})
