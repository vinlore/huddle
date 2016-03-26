angular.module('manageRoomsCtrl',[])
.controller('manageRoomsController', function($scope, ngTableParams, $stateParams, $filter, $log){

	var aId = $stateParams.accommodationId;

	//////// Data Structures ////////

	$scope.accommodation = {
		accommodationId: 1,
		name: "Hotel-1",
		address: "1128 West Georgia Street",
		city: "Vancouver",
		country: "Canada",
	}

	$scope.temp = []

	$scope.rooms = [
	{
		room_no: "1000",
		guest_count: 0,
		capacity: 2
	},
	{
		room_no: "1001",
		guest_count: 1,
		capacity: 2
	},
	{
		room_no: "1002",
		guest_count: 2,
		capacity: 2
	}
	]

	// initial input data
	$scope.room = {
    	room_no: null,
    	guest_count: null,
    	capacity: null
    }

    //////// Intial State ////////

	// copy actual data into a temp array for protection
	$scope.temp = $scope.rooms.slice();
	$scope.hasChanges = false;

	$scope.tableParams = new ngTableParams(
	{
	}, 
	{
		counts: [],
		getData: function ($defer, params) {
			$scope.data = params.sorting() ? $filter('orderBy') ($scope.temp, params.orderBy()) : $scope.temp;
			$scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
			$defer.resolve($scope.data);
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