angular.module('manageRoomsCtrl',[])
.controller('manageRoomsController', function($scope, ngTableParams, $stateParams, $filter, $log){

	var aId = $stateParams.accommodationId;

	$scope.accommodation = {
		accommodationId: 1,
		name: "Hotel-1",
		address: "1128 West Georgia Street",
		city: "Vancouver",
		country: "Canada",
	}

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

	$scope.tableParams = new ngTableParams(
	{
	}, 
	{
		counts: [],
		getData: function ($defer, params) {
			$scope.data = params.sorting() ? $filter('orderBy') ($scope.rooms, params.orderBy()) : $scope.rooms;
			$scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
			$defer.resolve($scope.data);
		}
	});

});