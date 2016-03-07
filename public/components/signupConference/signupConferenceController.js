angular.module('signupConfCtrl',[])
.controller('signupConferenceController', function($scope){

  $scope.user = {
      "Username": null,
      "OldPassword": null,
      "NewPassword": null,
      "ConfirmPassword": null,
      "FirstName": null,
      "MiddleName": null,
      "LastName": null,
      "Birthdate": null,
      "Gender": null,
      "Country": null,
      "City": null,
      "Email": null,
      "HomePhone": null,
      "OtherPhone": null
  };

  $scope.submitRequest = function () {

  };

})
