angular.module('manageInventoryCtrl',[])
.controller('manageInventoryController', function($scope, $stateParams, ngTableParams, $filter){

  $scope.conferenceId = $stateParams.conferenceId;

  $scope.items = [
  {
    name: "water",
    quantity: 5000
  },
  {
    name: "chocolate bars",
    quantity: 1000
  },
  {
    name: "mics",
    quantity: 25
  }
  ]

  $scope.temp = []

  // initial input data
  $scope.item = {
    name: null,
    quantity: null,
  };

  //////// Intial State ////////

  // copy actual data into a temp array for protection
  $scope.temp = $scope.items.slice();
  $scope.hasChanges = false;

  $scope.tableParams = new ngTableParams(
  {
  }, 
  {
    counts: [],
    getData: function ($defer, params) {
      $scope.data = params.sorting() ? $filter('orderBy') ($scope.temp, params.orderBy()) : $scope.temp;
      $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
      $defer.resolve($scope.data);
    }
  });
  
  //////// Button Functions ////////

  $scope.add = function(item) {
    $scope.hasChanges = true;

    // add new row to temp array
    $scope.temp.push(item);

    // clear input data
    $scope.item = null;

    // refresh tableParams to reflect changes
    $scope.tableParams.reload();
  }

  $scope.del = function(index) {
    $scope.hasChanges = true;
    $scope.temp.splice(index, 1);
    $scope.tableParams.reload();
  }

  $scope.cancel = function() {
    $scope.hasChanges = false;

    // revert temp array to the same as original (i.e. row array)
    $scope.temp = $scope.items.slice();
    $scope.tableParams.reload();
  }

  $scope.save = function() {
    $scope.hasChanges = false;
    $scope.items = $scope.temp.slice();
  }

  $scope.export = function() {
    
  }
})
