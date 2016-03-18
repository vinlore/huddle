angular.module('manageTransportationCtrl',[])
.controller('manageTransportationController', function($scope){

  $scope.temp = []

  $scope.vehicles = [
  {
    type: "Car",
    passengers: 4,
    attendees: [
    {
      name: "James"
    },
    {
      name: "Viggy"
    },
    {
      name: "Haniel"      
    }
    ]
  },
  {
    type: "Taxi",
    passengers: 4,
    attendees: [
    {
      name: "Chris"
    },
    {
      name: "Martin"        
    }
    ]
  },
  {
    type: "Pickup Truck",
    passengers: 0,
    attendees: [
    {
      name: "Gabby"
    }
    ]
  },
  {
    type: "Elephant",
    passengers: 1,
    attendees: []
  }
  ]

  $scope.temp = $scope.vehicles.slice();

  $scope.addVehicle = function() {
    if ($scope.temp.length == 0) {
      $scope.temp = $scope.vehicles.slice();

      $scope.temp.push({
        type: $scope.type,
        passengers: $scope.passengers
      });
    } else {
      $scope.temp.push({
        type: $scope.type,
        passengers: $scope.passengers
       });
    }

    $scope.type = "";
    $scope.passengers = "";
  }

  $scope.removeVehicle = function(index, event) {
    if (event) {
      event.preventDefault();
      event.stopPropagation();
    }

    if ($scope.temp.length == 0) {
      $scope.temp = $scope.vehicles.slice();
      $scope.temp.splice(index, 1);
    } else {
      $scope.temp.splice(index, 1);
    }
  }

  $scope.saveChanges = function() {
    $scope.vehicles = $scope.temp.slice();
    $scope.temp = [];
  }

  $scope.cancel = function() {
    $scope.temp = [];
  }

  $scope.export = function() {
  }

})