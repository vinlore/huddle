angular.module('manageEventTransportationCtrl',[])
.controller('manageEventTransportationController', function($scope, ngTableParams, Events, $stateParams, popup, Passengers){

  // Event ID
  $scope.eventId = $stateParams.eventId;

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
      Events.vehicles().query( {eid: $scope.eventId, type:'arrival'} )
      .$promise.then( function( response ) {
        if ( response ) {
          for (var i=0; i < response.length; i++) {
            response[i].attendees = Passengers.query({vid: response[i].id});
          }
          $scope.data[0] = response;
        } else {
          popup.error( 'Error', response.message );
        }
      }, function () {
        popup.connection();
      })

      // Load departure vehicles
      Events.vehicles().query( {eid: $scope.eventId, type:'departure'} )
      .$promise.then( function( response ) {
        if ( response ) {
          for (var i=0; i < response.length; i++) {
            response[i].attendees = Passengers.query({vid: response[i].id});
          }
          $scope.data[1] = response;
        } else {
          popup.error( 'Error', response.message );
        }
      }, function () {
        popup.connection();
      })
  }

  $scope.loadVehicles();

  //////// Button Functions ////////

  // $scope.add = function(vehicle, index) {

  //   var type;

  //   if (index == 0) {
  //     type = 'arrival';
  //   } else {
  //     type = 'departure';
  //   }

  //   vehicle.passenger_count = 0;

  //   Conferences.vehicles().save( {cid: $scope.conferenceId, type: type}, vehicle )
  //       .$promise.then( function( response ) {
  //         if ( response.status == 200 ) {
  //           console.log(vehicle);
  //           console.log( 'Changes saved to rooms' );
  //           popup.alert( 'success', 'Changes have been saved.' );

  //           // clear input data
  //           $scope.vehicle.name = null;
  //           $scope.vehicle.capacity = null;
  //         } else {
  //           popup.error( 'Error', response.message );
  //         }
  //       }, function () {
  //         popup.connection();
  //       })

  //   $scope.loadVehicles();
  // }

  // $scope.del = function(vehicle, parent, index) {

  //   if (event) {
  //     event.preventDefault();
  //     event.stopPropagation();
  //   }

  //   console.log(parent);
  //   console.log(index);
  //   var modalInstance = popup.prompt( 'Delete', 'Are you sure you want to delete?' );

  //   modalInstance.result.then( function ( result ) {
  //     if ( result ) {
  //       if (vehicle.passenger_count > 0) {
  //         popup.error( 'Error', 'Cannot delete vehicles with passengers.' );
  //       } else {
  //         Conferences.vehicles().delete( {cid: $scope.conferenceId, vid: vehicle.id} )
  //           .$promise.then( function( response ) {
  //             if ( response.status == 200 ) {
  //               console.log( 'Vehicle has been successfully deleted' );
  //               popup.alert( 'success', 'Vehicle has been successfully deleted.' );
  //             } else {
  //               popup.error( 'Error', response.message );
  //             }
  //           }, function () {
  //                     popup.connection();
  //           })

  //         $scope.loadVehicles();
  //       }
  //     }
  //   } )
  // }

  $scope.export = function() {
  }

  $scope.removeAttendee = function(vid, pid) {
    Passengers.delete({vid: vid, pid: pid})
      .$promise.then( function (response) {
        if (response.status = 200) {
          popup.alert('success', 'User no longer taking this vehicle');
          $scope.loadVehicles();
        } else {
          popup.error('Error', response.message);
        }
      })
  }

})