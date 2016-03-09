angular.module('manageInventoryCtrl',[])
.controller('manageInventoryController', function($scope){

  $scope.conference = {
      name: "Conference",
  }

  $scope.item = {
      name: null,
      quantity: null,
  };

  $scope.items= [
    {
      id : 'item1',
      name: null,
      quantity: null,
    }
  ]

  $scope.addItem = function () {
    var newItem = $scope.items.length + 1;
    $scope.items.push({'id':'item'+newItem});
  }

  $scope.removeItem = function (index) {
    $scope.items.splice(index, 1);
  }

  $scope.saveChanges = function () {

  }

  $scope.cancel = function () {

  }



})
