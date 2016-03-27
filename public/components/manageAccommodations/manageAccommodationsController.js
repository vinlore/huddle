angular.module('manageAccommodationsCtrl',[])
.controller('manageAccommodationsController', function($scope, ngTableParams, $stateParams, $filter, $location, $log, Conferences, popup, $uibModal){

	// Conference ID
	$scope.conferenceId = $stateParams.conferenceId;

    //////// Load Data ////////

	$scope.tableParams = new ngTableParams(
	{
	},
	{
		counts: [],
		getData: function ($defer, params) {
			Conferences.accommodations().query( {cid: $scope.conferenceId} )
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

	$scope.open = function(id) {
		$location.url('/manage-rooms-' + id);
	}

	$scope.add = function(accom) {

		// Adds acommodation to db
		Conferences.accommodations().save( {cid: $scope.conferenceId}, accom )
		.$promise.then( function( response ) {
			if ( response.status == 200 ) {
				console.log( 'Changes saved to accommodations' );
				popup.alert( 'success', 'Changes have been saved.' );
			} else {
				popup.error( 'Error', response.message );
			}
		}, function () {
			popup.connection();
		})

    	// refresh tableParams to reflect changes
    	$scope.tableParams.reload();
    }

    $scope.del = function(id) {
    	var modalInstance = popup.prompt( 'Delete', 'Are you sure you want to delete?' );

    	modalInstance.result.then( function ( result ) {
    		if ( result ) {
    			Conferences.accommodations().delete( {cid: $scope.conferenceId, aid: id} )
    			.$promise.then( function( response ) {
    				if ( response.status == 200 ) {
    					console.log( 'Accommodation has been successfully deleted' );
    					popup.alert( 'success', 'Accommodation has been successfully deleted.' );
    				} else {
    					popup.error( 'Error', response.message );
    				}
    			}, function () {
    				popup.connection();
    			})

    			$scope.tableParams.reload();

    		}
    	} )
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

  	$scope.export = function() {

  	}

  })
