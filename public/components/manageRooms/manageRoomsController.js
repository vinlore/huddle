angular.module('manageRoomsCtrl',[])
.controller('manageRoomsController', function($scope, ngTableParams, $stateParams, $filter, Conferences, popup){

	// Accommodation ID
	$scope.accommodationId = $stateParams.accommodationId;

	console.log($scope.conferenceId);
	console.log($scope.accommodationId);

	// Initial input data array
	$scope.room = {
    	room_no: null,
    	guest_count: null,
    	capacity: null
    }

    //////// Load Data ////////

	$scope.tableParams = new ngTableParams(
	{
	},
	{
		counts: [],
		getData: function ($defer, params) {
			Conferences.rooms().query( {aid: $scope.accommodationId} )
			.$promise.then( function( response ) {
				if ( response ) {
					console.log("here");
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

    $scope.add = function(room) {
    	$scope.hasChanges = true;

    	// add new row to temp array
    	$scope.temp.push(room);

    	// clear input data
    	$scope.room = null;

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
  		$scope.temp = $scope.rooms.slice();
  		$scope.tableParams.reload();
  	}

  	$scope.save = function() {
  		$scope.hasChanges = false;
  		$scope.rooms = $scope.temp.slice();
  	}

  	$scope.export = function() {
    
  }

});