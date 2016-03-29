angular.module( 'manageConferenceAttendeesCtrl', [] )
.controller( 'manageConferenceAttendeesController', function ($scope, ngTableParams, $stateParams, $filter, Conferences) {

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

});
