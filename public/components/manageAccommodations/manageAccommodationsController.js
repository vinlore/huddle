angular.module('manageAccommodationsCtrl',[])
.controller('manageAccommodationsController', function($scope, ngTableParams, $stateParams, $filter, $location, $log){

	var id = $stateParams.conferenceId;

	$log.log(id);

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

	$scope.tableParams = new ngTableParams(
	{
	}, 
	{
		counts: [],
		getData: function ($defer, params) {
			$scope.data = params.sorting() ? $filter('orderBy') ($scope.accommodations, params.orderBy()) : $scope.accommodations;
			$scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
			$defer.resolve($scope.data);
		}
	});

	$scope.open = function(id) {
		$location.url('/manage-rooms-' + id);
	}
})