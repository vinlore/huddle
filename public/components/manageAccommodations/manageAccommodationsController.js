angular.module('manageAccommodationsCtrl',[])
.controller('manageAccommodationsController', function($scope, ngTableParams, $stateParams, $filter, Conferences, popup, $uibModal, $location){

	// Conference ID
	$scope.conferenceId = $stateParams.conferenceId;

	// Initial input data
	$scope.accom = {
    	name: null,
    	address: null,
    	city: null,
    	country: null
    }
    
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
		$location.url('/manage-rooms-' + $scope.conferenceId + '-' + id);
	}

	$scope.add = function(accom) {

		// Adds acommodation to accommodations table
		Conferences.accommodations().save( {cid: $scope.conferenceId}, accom )
		.$promise.then( function( response ) {
			if ( response.status == 200 ) {
				console.log( 'Changes saved to accommodations (add)' );
				popup.alert( 'success', 'Changes have been saved.' );
				
				// clear input data
    			$scope.accom = null;
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
  		$scope.tableParams.reload();
  	}

  	$scope.save = function(id, ac) {
  		// Adds acommodation to accommodations table
		Conferences.accommodations().update( {cid: $scope.conferenceId, aid: id}, ac)
		.$promise.then( function( response ) {
			if ( response.status == 200 ) {
				console.log( 'Changes saved to accommodations (update)' );
				popup.alert( 'success', 'Changes have been saved.' );
			} else {
				popup.error( 'Error', response.message );
			}
		}, function () {
			popup.connection();
		})

		$scope.tableParams.reload();
  	}

  	$scope.export = function() {

  	}

  })
