angular.module('manageAccommodationsCtrl',[])
.controller('manageAccommodationsController', function($scope, ngTableParams, $stateParams, $filter, $location, $log){

	$scope.conferenceId = $stateParams.conferenceId;

	//////// Data Structures ////////

	$scope.accommodations = [
	{
		accommodationId: 1,
		name: "Hotel-1",
		address: "1128 West Georgia Street",
		city: "Vancouver",
		country: "Canada",
	},
	{
		accomodationId: 2,
		name: "Hotel-2",
		address: "5911 Minoru Blvd",
		city: "Richmond",
		country: "Canada"
	}
	]

	$scope.temp = []

	// initial input data
	$scope.accom = {
    	name: null,
    	address: null,
    	city: null,
    	country: null
    }

    //////// Intial State ////////

	// copy actual data into a temp array for protection
	$scope.temp = $scope.accommodations.slice();
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

	$scope.open = function(id) {
		$location.url('/manage-rooms-' + id);
	}

    $scope.add = function(accom) {
    	$scope.hasChanges = true;

    	// add new row to temp array
    	$scope.temp.push(accom);

    	// clear input data
    	$scope.accom = null;

    	$log.log($scope.temp);

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
  		$scope.temp = $scope.accommodations.slice();
  		$scope.tableParams.reload();
  	}

  	$scope.save = function() {
  		$scope.hasChanges = false;
  		$scope.accommodations = $scope.temp.slice();
  	}

})
