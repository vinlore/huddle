angular.module('manageTransportationCtrl',[])
.controller('manageTransportationController', function($scope, ngTableParams, Conferences, $stateParams){

  // Conference ID
  $scope.conferenceId = $stateParams.conferenceId;

  console.log($scope.conferenceId);

  $scope.dataArrive = {};

  $scope.dataDepart = {};

  $scope.data = [];


  //////// Load Data ////////

  $scope.loadVehicles = function() {

      // Load arrival vehicles
      Conferences.vehicles().query( {cid: $scope.conferenceId, type:'arrival'} )
      .$promise.then( function( response ) {
        if ( response ) {
          $scope.dataArrive = response;
          $scope.data.push($scope.dataArrive);
        } else {
          popup.error( 'Error', response.message );
        }
      }, function () {
        popup.connection();
      })

      // Load departure vehicles
      Conferences.vehicles().query( {cid: $scope.conferenceId, type:'departure'} )
      .$promise.then( function( response ) {
        if ( response ) {
          $scope.dataDepart = response;
          $scope.data.push($scope.dataDepart);
        } else {
          popup.error( 'Error', response.message );
        }
      }, function () {
        popup.connection();
      })
  }

  $scope.loadVehicles();

  console.log($scope.dataArrive);
  console.log($scope.dataDepart);

  // $scope.tableParams = new ngTableParams(
  // {
  // },
  // {
  //   counts: [],
  //   getData: function ($defer, params) {
  //     Conferences.vehicles().query( {cid: $scope.conferenceId} )
  //     .$promise.then( function( response ) {
  //       if ( response ) {
  //         console.log("here");
  //         console.log(response);
  //         $scope.data = response;
  //         $scope.data = params.sorting() ? $filter('orderBy') ($scope.data, params.orderBy()) : $scope.data;
  //         $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
  //         $defer.resolve($scope.data);
  //       } else {
  //         popup.error( 'Error', response.message );
  //       }
  //     }, function () {
  //       popup.connection();
  //     })
  //     console.log("here2");
  //   }
  // });

  // $scope.temp = []

  // $scope.vehicles = [
  // {
  //   type: "Car",
  //   passengers: 4,
  //   attendees: [
  //   {
  //     name: "James"
  //   },
  //   {
  //     name: "Viggy"
  //   },
  //   {
  //     name: "Haniel"      
  //   }
  //   ]
  // },
  // {
  //   type: "Taxi",
  //   passengers: 4,
  //   attendees: [
  //   {
  //     name: "Chris"
  //   },
  //   {
  //     name: "Martin"        
  //   }
  //   ]
  // },
  // {
  //   type: "Pickup Truck",
  //   passengers: 0,
  //   attendees: [
  //   {
  //     name: "Gabby"
  //   }
  //   ]
  // },
  // {
  //   type: "Elephant",
  //   passengers: 1,
  //   attendees: []
  // }
  // ]

  // $scope.temp = $scope.vehicles.slice();

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