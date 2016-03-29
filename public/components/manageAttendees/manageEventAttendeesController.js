angular.module( 'manageEventAttendeesCtrl', [] )
.controller( 'manageEventAttendeesController', function ($scope, ngTableParams, $stateParams, $filter, Events) {

	// Event ID
	$scope.eventId = $stateParams.eventId;

	//////// Load Data ////////

	$scope.tableParams = new ngTableParams(
	  {
	  },
	  {
	    counts: [],
	    getData: function ($defer, params) {
	      Events.attendees().query( {eid: $scope.eventId} )
	      .$promise.then( function( response ) {
	        if ( response ) {
	          console.log(response);
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

