angular.module ( 'profileCtrl', [] )
.controller('profileController', function ( $scope ) {

  $scope.user = {
      "Username": null,
      "OldPassword": null,
      "NewPassword": null,
      "ConfirmPassword": null,
      "FirstName": null,
      "MiddleName": null,
      "LastName": null,
      "Gender": null,
      "Birthdate": null,
      "Country": null,
      "City": null,
      "Email": null,
      "HomePhone": null,
      "OtherPhone": null
  };

  $scope.saveChanges = function () {

  };

  $scope.getUserInfo = function () {
      // get username after login
      return "Username"
  }

  $scope.submit = function () {
      //update function
  };

});
