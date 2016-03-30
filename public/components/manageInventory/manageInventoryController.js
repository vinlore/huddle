angular.module('manageInventoryCtrl',[])
.controller('manageInventoryController', function($scope, $stateParams, ngTableParams, $filter, popup, Conferences, $uibModal){

  // Conference ID
  $scope.conferenceId = $stateParams.conferenceId;

  // Initial input data
  $scope.item = {
    conference_id: $scope.conferenceId,
    name: null,
    quantity: null
  }

  //////// Load Data ////////

  $scope.tableParams = new ngTableParams(
  {
  },
  {
    counts: [],
    getData: function ($defer, params) {
      Conferences.inventory().query( {cid: $scope.conferenceId} )
      .$promise.then( function( response ) {
        if ( response ) {
          $scope.data = response;
          $scope.data = params.sorting() ? $filter('orderBy') ($scope.data, params.orderBy()) : $scope.data;
          $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
          $defer.resolve($scope.data);
        } else {
          popup.error( 'Error', response.message );
        }
      }, function () {
        popup.connection();
      })

    }
  });
  
  //////// Button Functions ////////

  $scope.add = function(item) {

    Conferences.inventory().save( {cid: $scope.conferenceId}, item )
    .$promise.then( function( response ) {
      if ( response.status == 200 ) {
        console.log( 'Changes saved to items (add)' );
        popup.alert( 'success', 'Changes have been saved.' );
        
        // clear input data
        $scope.item.name = null;
        $scope.item.quantity = null;
      } else {
        popup.error( 'Error', response.message );
      }
    }, function () {
      popup.connection();
    })

      // refresh tableParams to reflect changes
      $scope.tableParams.reload();
    }

    $scope.del = function(id) {
      var modalInstance = popup.prompt( 'Delete', 'Are you sure you want to delete?' );

      modalInstance.result.then( function ( result ) {
        if ( result ) {
          Conferences.inventory().delete( {cid: $scope.conferenceId, iid: id} )
          .$promise.then( function( response ) {
            if ( response.status == 200 ) {
              console.log( 'Item has been successfully deleted' );
              popup.alert( 'success', 'Item has been successfully deleted.' );
            } else {
              popup.error( 'Error', response.message );
            }
          }, function () {
            popup.connection();
          })

          $scope.tableParams.reload();

        }
      } )
    }

  $scope.updateQuantity = function(item, n) {
    item.quantity = n;

    Conferences.inventory().update( {cid: $scope.conferenceId, iid: item.id}, item)
    .$promise.then( function( response ) {
      if ( response.status == 200 ) {
        console.log( 'Changes saved to inventory (update)' );
        popup.alert( 'success', 'Changes have been saved.' );
      } else {
        popup.error( 'Error', response.message );
      }
    }, function () {
      popup.connection();
    })

    $scope.tableParams.reload();

  }

  $scope.export = function() {

  }
})
