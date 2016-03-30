angular.module('manageTransportationCtrl',[])
.controller('manageTransportationController', function($scope, ngTableParams, Conferences, $stateParams, popup, $uibModal){

  // Conference ID
  $scope.conferenceId = $stateParams.conferenceId;

  // Initial data array for holding arrival/departure response jsons
  $scope.data = [];

  // Initial input data array
  $scope.vehicle = {
    name: null,
    capacity: null
  }

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

  //////// Button Functions ////////

  $scope.add = function(vehicle, index) {

    var type;

    if (index == 0) {
      type = 'arrival';
    } else {
      type = 'departure';
    }

    vehicle.passenger_count = 0;

    Conferences.vehicles().save( {cid: $scope.conferenceId, type: type}, vehicle )
        .$promise.then( function( response ) {
          if ( response.status == 200 ) {
            console.log(vehicle);
            console.log( 'Changes saved to rooms' );
            popup.alert( 'success', 'Changes have been saved.' );

            // clear input data
            $scope.vehicle.name = null;
            $scope.vehicle.capacity = null;
          } else {
            popup.error( 'Error', response.message );
          }
        }, function () {
          popup.connection();
        })

    // refresh data (need angular.copy or else view won't show new data when input data clears because of reference)
    $scope.data[index].push(angular.copy(vehicle));
  }

  $scope.del = function(vehicle, parent, index) {

    if (event) {
      event.preventDefault();
      event.stopPropagation();
    }

    console.log(parent);
    console.log(index);
    var modalInstance = popup.prompt( 'Delete', 'Are you sure you want to delete?' );

    modalInstance.result.then( function ( result ) {
      if ( result ) {
        if (vehicle.passenger_count > 0) {
          popup.error( 'Error', 'Cannot delete vehicles with passengers.' );
        } else {
          Conferences.vehicles().delete( {cid: $scope.conferenceId, vid: vehicle.id} )
            .$promise.then( function( response ) {
              if ( response.status == 200 ) {
                console.log( 'Vehicle has been successfully deleted' );
                popup.alert( 'success', 'Vehicle has been successfully deleted.' );
              } else {
                popup.error( 'Error', response.message );
              }
            }, function () {
                      popup.connection();
            })

          // remove data from view
          $scope.data[parent].splice(index, 1);
        }
      }
    } )
  }

  $scope.export = function() {
  }

})