angular.module( 'manageEventAttendeesCtrl', [] )
.controller( 'manageEventAttendeesController', function ($scope, ngTableParams, $stateParams, $filter, Events, popup) {

	// Event ID
	$scope.eventId = $stateParams.eventId;

	$scope.radioModel = '';

	//////// Load Data ////////

    $scope.load = function() {
		$scope.tableParams = new ngTableParams(
		  {
		  	filter: {
                'pivot.status' : $scope.radioModel
            }
		  },
		  {
		    counts: [],
		    getData: function ($defer, params) {
		      	// organize filter as $filter understand it (graph object)
                var filters = {};
                angular.forEach(params.filter(), function(val, key) {
                    var filter = filters;
                    var parts = key.split('.');
                    for (var i = 0; i < parts.length; i++) {
                        if (i != parts.length - 1) {
                            filter[parts[i]] = {};
                            filter = filter[parts[i]];
                        } else {
                            filter[parts[i]] = val;
                        }
                    }
                })

			    Events.attendees().query( {eid: $scope.eventId} )
			      .$promise.then( function( response ) {
			        if ( response ) {
			          	$scope.data = response;

			          	console.log(JSON.stringify(params.filter()));

                       	// filter with $filter (don't forget to inject it)
                        var filteredDatas =
                            params.filter() ?
                            $filter('filter')($scope.data, filters) :
                            $scope.data;

                        // ordering
                        var sorting = params.sorting();
                        var key = sorting ? Object.keys(sorting)[0] : null;
                        var orderedDatas = sorting ? $filter('orderBy')(filteredDatas, key, sorting[key] == 'desc') : filteredDatas;

                        $defer.resolve(orderedDatas);
			        } else {
			          popup.error( 'Error', response.message );
			        }
			      }, function () {
			        popup.connection();
			      })

		    }
		});
	}

	$scope.load();

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
