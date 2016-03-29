angular.module( 'manageConferenceAttendeesCtrl', [] )
.controller( 'manageConferenceAttendeesController', function ($scope, ngTableParams, $stateParams, $filter, Conferences, popup) {

  // Conference ID
  $scope.conferenceId = $stateParams.conferenceId;

  //////// Load Data ////////

  $scope.tableParams = new ngTableParams(
  {
  },
  {
    counts: [],
    getData: function ($defer, params) {
      Conferences.attendees().query( {cid: $scope.conferenceId} )
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

  $scope.approve = function(id) {

    Conferences.attendees().update( {cid: $scope.conferenceId, pid: id}, {status: 'approved'})
    .$promise.then( function( response ) {
      if ( response.status == 200 ) {
        console.log( 'Changes saved to profile_attends_conferences (approve)' );
        popup.alert( 'success', 'Approve success.' );
      } else {
        popup.error( 'Error', response.message );
      }
    }, function () {
      popup.connection();
    })

    $scope.tableParams.reload();
  }

  $scope.deny = function(id) {

    Conferences.attendees().update( {cid: $scope.conferenceId, pid: id}, {status: 'denied'})
    .$promise.then( function( response ) {
      if ( response.status == 200 ) {
        console.log( 'Changes saved to profile_attends_conferences (deny)' );
        popup.alert( 'success', 'Deny success.' );
      } else {
        popup.error( 'Error', response.message );
      }
    }, function () {
      popup.connection();
    })

    $scope.tableParams.reload();
  }

});
