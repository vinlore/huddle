angular.module ( 'userRegCtrl', [] )
.controller ( 'userRegController', function ( $scope ) {
    
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

    $scope.requiredField = function ( ind ) {
        return ind == 3 || ind == 5 || ind == 6;
    };

    $scope.register = function () {

    };

})