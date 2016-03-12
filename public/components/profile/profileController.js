angular.module ( 'profileCtrl', [] )
.controller('profileController', function ( $scope ) {

  $scope.user = {
      Username: "Tino",
      OldPassword: null,
      NewPassword: null,
      ConfirmPassword: null,
      FirstName: "Haniel",
      MiddleName: null,
      LastName: "Martino",
      Birthdate: null,
      Gender: null,
      Country: "Canada",
      City: "Vancouver",
      Email: "Haniel_Martino@hotmail.com",
      HomePhone: "9999999999",
      OtherPhone: "1234567890"
  };

  $scope.saveNameChanges = function () {

  };

  $scope.saveContactChanges = function () {

  };

  $scope.savePasswordChanges = function () {

  };

  $scope.getUserInfo = function () {
      // get username after login
      return "Username"
  }

  $scope.submit = function () {
      //update function
  };

  $scope.deleteAccount = function () {

  };
  
});
