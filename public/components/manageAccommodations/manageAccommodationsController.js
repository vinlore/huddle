angular.module('manageAccommodationsCtrl',[])
.controller('manageAccommodationsController', function($scope, ngTableParams, $stateParams, $filter, $uibModal, $log){

	//$var id = $stateParams.conferenceId;

	$scope.accommodations = [
	{
		name: "Hotel-1",
		address: "1128 West Georgia Street",
		city: "Vancouver",
		country: "Canada",
		// rooms: [
		// {
		// 	room_no: "1000",
		// 	guest_count: 0,
		// 	capacity: 2
		// },
		// {
		// 	room_no: "1001",
		// 	guest_count: 1,
		// 	capacity: 2
		// },
		// {
		// 	room_no: "1002",
		// 	guest_count: 2,
		// 	capacity: 2
		// }

		// ]
	},
	{
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
})