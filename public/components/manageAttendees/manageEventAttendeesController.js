angular.module( 'manageEventAttendeesCtrl', [] )
.controller( 'manageEventAttendeesController', function ($scope, ngTableParams, $stateParams, $filter, Events, popup) {

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

	//////// Button Functions ////////

  	$scope.approve = function(id) {

	    Events.attendees().update( {eid: $scope.eventId, pid: id}, {status: 'approved'})
	    .$promise.then( function( response ) {
	      if ( response.status == 200 ) {
	        console.log( 'Changes saved to profile_attends_events (approve)' );
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

	    Events.attendees().update( {eid: $scope.eventId, pid: id}, {status: 'denied'})
	    .$promise.then( function( response ) {
	      if ( response.status == 200 ) {
	        console.log( 'Changes saved to profile_attends_events (deny)' );
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
