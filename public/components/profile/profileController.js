angular.module ( 'profileCtrl', [] )
.controller('profileController', function ( $scope ) {

  $scope.user = {
      "Username": null,
      "Password": null,
      "Confirm Password": null,
      "First Name": null,
      "Middle Name": null,
      "Last Name": null,
      "Age": null,
      "Country": null,
      "City": null,
      "Email": null,
      "Home Phone": null,
      "Other Phone": null
  };

  $scope.saveChanges = function () {

  };

  $scope.submit = function () {

  };

});
